<?php
require_once __DIR__ . '/config/config.php';
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
    enableUser($userID, $config);
}