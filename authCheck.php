<?php
$config = array();

$config['config'] = array(
    'corpID' => 0, // EVE Online corp ID (Leave as 0 if not using)
    'corpGroupID' => 0, // The group ID you want assigned to people in the correct corp (Leave as 0 if not using)
    'allianceID' => 0, // EVE Online alliance ID (Leave as 0 if not using)
    'allianceGroupID' => 0, // The group ID you want assigned to people in the correct alliance (Leave as 0 if not using)
    'registeredGroupID' => 14, // The group ID for default registered users (typically 14)
);

$config['database'] = array(
    'host' => 'localhost', //DB Host
    'user' => '', //Username
    'pass' => '', //Password
    'database' => '' //phpBB Database Name
);



//DO NOT EDIT BELOW THIS
//DO NOT EDIT BELOW THIS
//DO NOT EDIT BELOW THIS
//DO NOT EDIT BELOW THIS
//DO NOT EDIT BELOW THIS
//DO NOT EDIT BELOW THIS



require __DIR__ . '/lib/lib.php';
$result = getInfo($config);
while($row = $result->fetch_assoc()) {
    $userID = (string)$row['user_id'];
    $vCode = (string)$row['pf_api_vcode'];
    $keyID = (string)$row['pf_api_keyid'];
    if ($vCode === null || $keyID === null|| (int)$keyID === 0){
        continue;
    }
    $keyInfo = checkStatus($keyID, $vCode, $config);
    if ($keyInfo === null) {
        disableUser($userID, $config);
        continue;
    }
    if ($keyInfo === '1') {
        enableCorp($userID, $config);
    }
    if ($keyInfo === '2') {
        enableAlliance($userID, $config);
    }
}