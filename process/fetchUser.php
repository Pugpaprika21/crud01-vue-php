<?php

require __DIR__ . '../../src/include/include.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Max-Age: 86400');
header('Content-type: application/json charset=utf-8');

$action = get_b64('action_');

if ($action == 'fetchAll') {
    $data = db_excQuery("SELECT * FROM user_tb WHERE 1=1 ORDER BY user_id DESC");
    echo json_encode($data);
    exit;
} else {
    echo json_encode([]);
    exit;
}
