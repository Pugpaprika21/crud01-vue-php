<?php

require __DIR__ . '../../src/include/include.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Max-Age: 86400');
header('Content-type: application/json charset=utf-8');

$request = json_decode(file_get_contents('php://input'), true);

if ($request['action_'] == 'insert') {

    $create = []; 
    $create['user_name'] = $request['username'];
    $create['user_pass'] = $request['password'];
    $create['user_token'] = U_SYS_TOKEN;
    $create['user_status'] = 'Y';
    $create['create_user_at'] = '';
    $create['create_date_at'] = CREATE_DATE_AT;
    $create['create_time_at'] = CREATE_TIME_AT;
    $create['create_ip_at'] = U_IP;

    $user_id = db_insert('user_tb', $create, 'user_id');

    $data = db_select('user_tb', '*', "user_id = '{$user_id}'");

    echo json_encode($data);
    unset($create);
    exit;
}
