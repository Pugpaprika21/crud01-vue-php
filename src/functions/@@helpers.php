<?php

if (!function_exists('url_where')) {

    /**
     * @param string $path_url
     * @param array $query_str
     * @return string|void
     */
    function url_where($path_url, $query_str = array())
    {
        $params = "";
        if (count($query_str) > 0) $params = "?";

        if (file_exists($path_url)) {

            $query = http_build_query($query_str, '', '&');
            $query_encoded = base64_encode($query);

            return "{$path_url}{$params}{$query_encoded}";
        }

        http_response_code(Http::NOT_FOUND);
    }
}

if (!function_exists('redirect_to')) {

    /**
     * @param string $path 
     * @param array $queryParams
     * @return void
     */
    function redirect_to($path, $queryParams = [])
    {
        $queryString = http_build_query($queryParams);

        if (file_exists($path)) {

            if (count($queryParams) > 0) {
                header("location: {$path}?{$queryString}");
                exit();
            } else {
                header("location: {$path}");
                exit();
            }
        } else {
            http_response_code(404);
            exit();
        }
    }
}

if (!function_exists('echo_r')) {
    /**
     * @param null $param
     * @param boolean $exist
     * @return void
     */
    function echo_r($param = null, $exist = true)
    {
        $data = print_r($param, true);
        echo sprintf("<pre><div id='debug-data' style='padding: 10px; color: #FFFFFF; background-color: #000000;'>%s</div></pre>", $data);
        if ($exist) exit;
    }
}

if (!function_exists('token_generator')) {

    /**
     * #token_generator();
     *
     * @param string $salt
     * @return void
     */
    function token_generator($salt = "example_salt")
    {
        $token = uniqid();
        $token = hash("sha256", $token . $salt . time());
        return $token;
    }
}

if (!function_exists('now')) {

    /**
     * @param string $time_zone -> D = DATE, T = TIME, F = DATE AND TIME
     * @return string
     */
    function now($format_date_as_time = 'F')
    {
        $formatted_now = '';
        switch (strtoupper($format_date_as_time)) {
            case 'D':
                $formatted_now = date('Y-m-d');
                break;
            case 'T':
                $formatted_now = date('H:i:s', time());
                break;
            default:
                $formatted_now = date('Y-m-d') . ' ' . date('H:i:s', time());
                break;
        }
        return $formatted_now;
    }
}

if (!function_exists('date_toThai')) {

    /**
     * format data '2023-04-06 18:43:07';
     *
     * @param string $datetime
     * @return void
     */
    function date_toThai($datetime)
    {
        $months = array(
            'มกราคม',
            'กุมภาพันธ์',
            'มีนาคม',
            'เมษายน',
            'พฤษภาคม',
            'มิถุนายน',
            'กรกฎาคม',
            'สิงหาคม',
            'กันยายน',
            'ตุลาคม',
            'พฤศจิกายน',
            'ธันวาคม'
        );

        $datetime = strtotime($datetime);
        $day = date('j', $datetime);
        $month = date('n', $datetime);
        $year = date('Y', $datetime) + 543;
        $hour = date('H', $datetime);
        $minute = date('i', $datetime);
        $second = date('s', $datetime);

        $month = $months[$month - 1];

        return "$day $month $year เวลา $hour:$minute:$second น.";
    }
}

if (!function_exists('ip')) {

    /**
     * @return string
     */
    function ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}

if (!function_exists('write_log')) {

    /**
     * #write_log("oooo", "../logs/process/insert_user.txt");
     * 
     * @param string $message
     * @param string $file
     * @param bool $stop_write
     * @return int|false
     */
    function write_log($message, $file = 'log.txt', $stop_write = false)
    {
        if ($stop_write == false) return;

        $log = function () use ($message, $file) {
            $time = now('DT');
            $log = "[$time] $message\n";
            return file_put_contents($file, $log, FILE_APPEND | LOCK_EX);
        };

        if (file_exists($file)) return $log();
        return $log();
    }
}

if (!function_exists('write_json')) {

    /**
     * #write_json("oooo", "../logs/json/data.json");
     * 
     * @param string|array $message
     * @param string $file
     * @param boolean $stop_write
     * @return int|false
     */
    function write_json($message, $file = 'log.json', $stop_write = true)
    {
        if ($stop_write == false) return false;

        if (is_array($message)) $message = json_encode($message, JSON_PRETTY_PRINT);

        $log = function () use ($message, $file) {
            $time = now('DT');
            $log = "$message";
            return file_put_contents($file, $log);
        };

        if (file_exists($file)) return $log();
        return $log();
    }
}

if (!function_exists('anyRequest')) {

    /**
     * @return string $type 
     * @return array
     */
    function anyRequest($type = '')
    {
        $methods = [
            'POST' => $_POST,
            'GET' => $_GET,
            'FILES' => $_FILES,
            'REQUEST' =>  $_REQUEST,
            'CLIENT' => json_decode(file_get_contents('php://input'), true)
        ];

        $typeUpper = strtoupper($type);
        if ($typeUpper == 'CLIENT') return $methods[$typeUpper];
        return $methods;
    }
}

if (!function_exists('download_file')) {

    /**
     * #download_file('../../public/img/logo.PNG');
     *
     * @param string $file_path
     * @return void
     */
    function download_file($file_path)
    {
        if (file_exists($file_path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            return;
        }
        throw new Exception("File not found : {$file_path}");
    }
}

if (!function_exists('thai_number')) {

    /**
     * @param string|int $number
     * @return void
     */
    function thai_number($number)
    {
        $thai_number_array = array(
            0 => '๐',
            1 => '๑',
            2 => '๒',
            3 => '๓',
            4 => '๔',
            5 => '๕',
            6 => '๖',
            7 => '๗',
            8 => '๘',
            9 => '๙'
        );

        $thai_number = '';
        $number = intval($number);
        $length = strlen($number);

        for ($i = 0; $i < $length; $i++) {
            $digit = $number % 10;
            $thai_number = $thai_number_array[$digit] . $thai_number;
            $number = intval($number / 10);
        }

        return $thai_number;
    }
}

if (!function_exists('line_notify')) {

    /**
     * @param string $token
     * @param string $message
     * @param string|null $image_url
     * @return array
     */
    function line_notify($token, $message, $image_url = null)
    {
        $line_api = 'https://notify-api.line.me/api/notify';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $line_api,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Authorization: Bearer {$token}"
            ),
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query(array(
                'message' => $message,
                'imageThumbnail' => $image_url,
                'imageFullsize' => $image_url,
            )),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }
}

if (!function_exists('view')) {

    /**
     * @param string $view_file 
     * @param array $view_vars 
     * @param bool $viewVar_debug 
     * @return string|void 
     */
    function view($view_file, $view_vars = [], $var_debug = false)
    {
        $view_path = __DIR__  .  $view_file;
        if (!file_exists($view_path)) {
            http_response_code(404);
            echo_r([
                'view_file' => $view_file,
                'view_root_dir' => $view_path,
                'view_vars' => $view_vars
            ]);
        }

        extract($view_vars);
        ob_start();
        require_once $view_path;

        $view_content = ob_get_clean();

        if ($var_debug) echo_r(['view_vars_debug' => $view_vars]);

        return $view_content;
    }
}

if (!function_exists('rend_string')) {

    /**
     * @param string $input_str
     * @param integer $length
     * @return string
     */
    function rend_string($input_str = '', $length = 10)
    {
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ{$input_str}";
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('file_upload')) {

    /**
     * file_upload('../../upload/image', [
     *      'name' => $file['user_profile']['name'],
     *      'tmp_name' => $file['user_profile']['tmp_name']
     * ]);
     * 
     * return file name
     *
     * @param string $path_upload
     * @param array $file
     * @return string|void 
     */
    function file_upload($path_upload, $file)
    {
        $path = __DIR__ . $path_upload;
        if (!file_exists($path)) {
            http_response_code(404);
            echo_r(['path_upload' => $path_upload, 'file' => $file]);
        }

        $imageFileType = pathinfo($file['name'], PATHINFO_EXTENSION);
        $typeFile = array_merge(['jpg', 'jpeg', 'png'], ['JPG', 'JPEG', 'PNG']);
        if (!in_array($imageFileType, $typeFile)) {
            echo_r(['extension_not_found' => $file]);
        }

        $nameFile = explode('.', $file['name']);
        $file_name = rend_string($nameFile[0]) . round(microtime(true) * 1000) . '.' . $imageFileType;

        $file_target = "{$path}_{$file_name}";
        move_uploaded_file($file['tmp_name'], $file_target);
        chmod($file_target, 0777);

        $d = now('d');
        write_log($file_target,  __DIR__ . "/../../logs/process/upload_files_{$d}.txt");
        return $file_name;
    }
}

if (!function_exists('req')) {

    /**
     * #req('name');
     *
     * @param string $key
     * @return string
     */
    function req($key)
    {
        return isset($_REQUEST[$key]) ? Str::input($_REQUEST[$key]) : "";
    }
}

if (!function_exists('get_b64')) {

    /**
     * #get_b64('name');
     *
     * @param string $key
     * @param null $default
     * @return string|null
     */
    function get_b64($key, $default = null)
    {
        $query_str = array_keys($_GET);
        $decoded_query = base64_decode(isset($query_str[0]) ? $query_str[0] : []);
        $params = array();
        parse_str($decoded_query, $params);

        return isset($params[$key]) ? Str::input($params[$key]) : $default;
    }
}

if (!function_exists('response')) {

    /**
     * @return Http|null
     */
    function response()
    {
        $http = new Http();

        if ($http instanceof Http) return $http;
        return null;
    }
}