<?php
function getInfo($config)
{
    $mysqli = mysqli_connect($config['database']['host'], $config['database']['user'], $config['database']['pass'], $config['database']['database']);
    return mysqli_query($mysqli, 'SELECT * FROM phpbb_profile_fields_data');
}

function disableUser($userID, $config)
{
    $mysqli = mysqli_connect($config['database']['host'], $config['database']['user'], $config['database']['pass'], $config['database']['database']);
    $registeredID = $config['config']['registeredGroupID'];
    $group = mysqli_query($mysqli, "SELECT * FROM phpbb_user_group WHERE user_id = $userID AND group_id != $registeredID");
    $rowCount = mysqli_num_rows($group);
    if ((int)$rowCount > 0) {
        mysqli_query($mysqli, "DELETE FROM phpbb_user_group WHERE user_id = $userID AND group_id != $registeredID");
        logInfo("User removed from groups. userID - ({$userID})");
    }
}

function enableCorp($userID, $config)
{
    $mysqli = mysqli_connect($config['database']['host'], $config['database']['user'], $config['database']['pass'], $config['database']['database']);
    $corpGroup = $config['config']['corpGroupID'];
    $group = mysqli_query($mysqli, "SELECT * FROM phpbb_user_group WHERE user_id = $userID AND group_id = $corpGroup");
    $rowCount = mysqli_num_rows($group);
    if ((int)$rowCount === 0) {
        mysqli_query($mysqli, "INSERT INTO table_name (group_id,user_id,group_leader,user_pending) VALUES ($corpGroup,$userID,0,0);");
        logInfo("User added to corp group. userID - ({$userID})");
    }
}

function enableAlliance($userID, $config)
{
    $mysqli = mysqli_connect($config['database']['host'], $config['database']['user'], $config['database']['pass'], $config['database']['database']);
    $allianceGroup = $config['config']['allianceGroupID'];
    $group = mysqli_query($mysqli, "SELECT * FROM phpbb_user_group WHERE user_id = $userID AND group_id = $allianceGroup");
    $rowCount = mysqli_num_rows($group);
    if ((int)$rowCount === 0) {
        mysqli_query($mysqli, "INSERT INTO table_name (group_id,user_id,group_leader,user_pending) VALUES ($allianceGroup,$userID,0,0);");
        logInfo("User added to alliance group. userID - ({$userID})");
    }
}

function checkStatus($keyID, $vCode, $config)
{
    // Initialize a new request for this URL
    $url = "https://api.eveonline.com/account/Characters.xml.aspx?keyID={$keyID}&vCode={$vCode}";
    $xml = makeApiRequest($url);
    if ($xml === null) {
        logInfo('API Returned null, skipping.');
        return '3';
    }
    if (@$xml->result->rowset->row === null) {
        logInfo('API Returned null, skipping.');
        return '3';
    }
    foreach ($xml->result->rowset->row as $character) {
        if ($character->attributes()->errorCode !== null) {
            $error = $character->attributes()->errorCode;
            if ((int)$error === 222 || 223 || 202 || 203 || 204) {
                logInfo("API Key Disabled. KeyID - ({$keyID})");
                return null;
            }
            logInfo("API Error #{$error} Detected.");
        }
        $corpID = $character->attributes()->corporationID;
        if ((int)$corpID === (int)$config['config']['corpID'] && (int)$config['config']['corpID'] !== 0) {
            return '1';
        }
        $allianceID = $character->attributes()->allianceID;
        if ((int)$allianceID === (int)$config['config']['allianceID'] && (int)$config['config']['allianceID'] !== 0) {
            return '2';
        }
    }
    return null;
}

function makeApiRequest($url)
{
    try {
        // Initialize a new request for this URL
        $ch = curl_init($url);
        // Set the options for this request
        curl_setopt_array($ch, array(
            CURLOPT_FOLLOWLOCATION => true, // Yes, we want to follow a redirect
            CURLOPT_RETURNTRANSFER => true, // Yes, we want that curl_exec returns the fetched data
            CURLOPT_SSL_VERIFYPEER => true, // Do not verify the SSL certificate
            CURLOPT_USERAGENT => 'MAMBA Auth', // Useragent
            CURLOPT_TIMEOUT => 15,
        ));
        // Fetch the data from the URL
        $data = curl_exec($ch);
        // Close the connection
        curl_close($ch);
        // Return a new SimpleXMLElement based upon the received data
        return new SimpleXMLElement($data);
    } catch (Exception $e) {
        return null;
    }
}

function logInfo($msg)
{
    $log = fopen(__DIR__ . '/../authLog.log',"a");
    $date = date('m-d-Y H:i:s');
    fwrite($log,PHP_EOL . "$date - $msg");
}