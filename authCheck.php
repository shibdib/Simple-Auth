<?php
/** @noinspection PhpIncludeInspection */
require_once __DIR__ . '/config.php';
require __DIR__ . '/lib/lib.php';
logInfo('Initiating Auth Check');
$mysqli = mysqli_connect($config['database']['host'], $config['database']['user'], $config['database']['pass'], $config['database']['database']);
$result = getInfo($mysqli);
while ($row = $result->fetch_assoc()) {
    $userID = (string)$row['user_id'];
    $vCode = (string)$row['pf_api_vcode'];
    $keyID = (string)$row['pf_api_keyid'];
    if ($vCode === null || $keyID === null || (int)$keyID === 0) {
        continue;
    }
    $keyInfo = checkStatus($keyID, $vCode, $config);
    if ($keyInfo === null) {
        disableUser($userID, $config, $mysqli);
        continue;
    }
    if ($keyInfo === '1') {
        enableCorp($userID, $config, $mysqli);
    }
    if ($keyInfo === '2') {
        enableAlliance($userID, $config, $mysqli);
    }
}