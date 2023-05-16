<?php

/**
 * @author Pug_DEV <!>
 * 
 * @override <mysqli>
 */

if (!function_exists('db_conn')) {

    /**
     * #db_conn();
     *
     * @return mysqli|bool
     */
    function db_conn()
    {
        $db_config = require __DIR__ . '../../../src/configs/db_settings.php';
        
        if (isset($db_config)) {
            $conn = mysqli_connect($db_config['DB']['HOST'], $db_config['DB']['USER'], $db_config['DB']['PASS'], $db_config['DB']['NAME']);
            mysqli_set_charset($conn, $db_config['DB']['CHAR_SET']);
            return (!$conn) ? false : $conn;
        }
        return false;
    }
}

if (!function_exists('db_select')) {

    /**
     * #db_select('USER_TB');
     *
     * @param string $tbl
     * @param string $fields
     * @param string $condi
     * @return array
     */
    function db_select($tbl, $fields = '*', $condi = '')
    {
        $conn = db_conn();
        $items = [];
        $wheres = ($condi != '') ? "WHERE {$condi}" : "";
        $sql_select = "SELECT {$fields} FROM {$tbl} {$wheres}";

        $d = now('D');
        $query_ = mysqli_query($conn, $sql_select);
        write_log($sql_select,  __DIR__ . "/../../logs/process/query_select_{$d}.txt");

        while ($rows = mysqli_fetch_assoc($query_)) array_push($items, $rows);

        mysqli_close($conn);
        if (count($items) > 1) return $items;
        return !empty($items[0]) ? $items[0] : $items;
    }
}

if (!function_exists('db_insert')) {

    /**
     * #db_insert('USER_TB', ['NAME' => 'alex', 'PASS' => '1234']);
     *
     * @param string $tbl
     * @param array $data
     * @param string $PK
     * @return int|bool
     */
    function db_insert($tbl, $data, $PK = '_')
    {
        $conn = db_conn();
        $fields = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";

        $d = now('D');
        $sql_insert = "INSERT INTO {$tbl}({$fields}) VALUES({$values})";
        
        $query_ = mysqli_query(db_conn(), $sql_insert);
        write_log($sql_insert,  __DIR__ . "/../../logs/process/query_insert_{$d}.txt");

        if ($query_) {
            if ($PK != '_') {
                $item = [];
                $query_pk = mysqli_query($conn, "SELECT MAX({$PK}) AS MAX_ID FROM {$tbl}");
                while ($row = mysqli_fetch_assoc($query_pk)) {
                    array_push($item, $row);
                }
                mysqli_close($conn);
                return !empty($item[0]['MAX_ID']) ? $item[0]['MAX_ID'] : false;
            }
            mysqli_close($conn);
            return true;
        }

        mysqli_close($conn);
        return false;
    }
}

if (!function_exists('db_update')) {

    /**
     * #db_update('USER_TB', ['NAME' => 'alex', 'PASS' => '1234'], "USR_ID = '1'");
     *
     * @param string $tbl
     * @param array $data
     * @param string $condi
     * @return bool
     */
    function db_update($tbl, $data, $condi)
    {
        $fields = '';
        foreach ($data as $fields_ => $values_) {
            $fields .= !empty($fields) ? ', ' : '';
            $fields .= "{$fields_} = '{$values_}'";
        }

        $conn = db_conn();
        $d = now('D');
        $sql_upd = "UPDATE {$tbl} SET {$fields} WHERE {$condi}";
        write_log($sql_upd,  __DIR__ . "/../../logs/process/query_update_{$d}.txt");

        $query_upd = mysqli_query($conn, $sql_upd);

        mysqli_close($conn);
        return ($query_upd) ? true : false;
    }
}

if (!function_exists('db_delete')) {

    /**
     * #db_delete('USER_TB', "USR_ID = '1'");
     *
     * @param string $tbl
     * @param string $condi
     * @return bool
     */
    function db_delete($tbl, $condi)
    {
        $conn = db_conn();
        $sql_del = "DELETE FROM {$tbl} WHERE {$condi}";
        $d = now('D');
    
        $query_del = mysqli_query($conn, $sql_del);
        write_log($sql_del,  __DIR__ . "/../../logs/process/query_delete_{$d}.txt");

        mysqli_close($conn);
        return ($query_del) ? true : false;
    }
}

if (!function_exists('db_lastId')) {

    /**
     * #db_lastId('user_tb', 'usr_id');
     *
     * @param string $tbl
     * @param string $field_max
     * @return integer
     */
    function db_lastId($tbl, $field_max)
    {
        $conn = db_conn();
        $sql_ld = "SELECT MAX({$field_max}) AS MAX_ID FROM {$tbl}";
        
        $d = now('D');
        $query_ = mysqli_query($conn, $sql_ld);
        write_log($sql_ld,  __DIR__ . "/../../logs/process/query_select_{$d}.txt");

        mysqli_close($conn);

        if ($query_) {
            $max_res = mysqli_fetch_assoc($query_);
            unset($query_);
            return $max_res['MAX_ID'];
        }
        return 0;
    }
}

if (!function_exists('db_numRows')) {

    /**
     * #db_numRows('USER_TB');
     *
     * @param string $tbl
     * @return string|int
     */
    function db_numRows($tbl)
    {
        $conn = db_conn();
        $rows_ = 0;
        $sql_num = "SELECT * FROM {$tbl}";
        $d = now('D');
    
        $qurey_ = mysqli_query($conn, $sql_num);
        write_log($sql_num,  __DIR__ . "/../../logs/process/query_select_{$d}.txt");
        
        if ($qurey_) {
            mysqli_free_result($qurey_);
            return mysqli_num_rows($qurey_);
        }
        mysqli_close($conn);
        return $rows_;
    }
}

if (!function_exists('db_excQuery')) {

    /**
     * #db_excQuery('select ...stmt');
     *
     * @param string $sql_stmt
     * @param bool|callable $fetch_auto_array
     * @return mixed
     */
    function db_excQuery($sql_stmt, $fetch_auto_array = true)
    {
        $conn = db_conn();
        $query_ = mysqli_query($conn, $sql_stmt);

        if (!$query_) {
            mysqli_close($conn);
            return false;
        }

        $d = now('D');
        write_log($sql_stmt,  __DIR__ . "/../../logs/process/query_select_{$d}.txt");
        
        if (preg_match('/^SELECT/i', $sql_stmt)) {

            $items = array();
            while ($rows = mysqli_fetch_assoc($query_)) {
                $items[] = $rows;
            }

            if ((count($items) > 1)) {
                $rows_result = $items;
            } else {
                $rows_result = !empty($items[0]) ? $items[0] : $items;
            }

            mysqli_close($conn);

            if (is_callable($fetch_auto_array)) {
                return $fetch_auto_array($rows_result, $sql_stmt);
            } elseif ($fetch_auto_array) {
                return $rows_result;
            }
            return $query_;
        } elseif (preg_match('/^INSERT/i', $sql_stmt) || preg_match('/^UPDATE/i', $sql_stmt) || preg_match('/^DELETE/i', $sql_stmt)) {
            $affected_rows = mysqli_affected_rows($conn);
            mysqli_close($conn);
            return ($affected_rows > 0);
        }
        mysqli_close($conn);
        return false;
    }
}
