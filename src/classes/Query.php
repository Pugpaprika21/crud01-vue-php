<?php

class Query extends DBConfig
{
    /**
     * @param string $table
     * @param array $data
     * @param string $byID
     * @return object|bool
     */
    public static function create($table, $data, $byID = "")
    {
        $pdo = self::createConnect();

        $getKeys = implode(', ', array_keys($data));
        $getVals = "'" . implode("', '", array_values($data)) . "'";

        $fullSql = "INSERT INTO {$table} ({$getKeys}) VALUES ({$getVals})";
        $resultQuery = $pdo->query($fullSql)->execute();

        if ($resultQuery) {
            
            if ($byID != "") {
                $resultRow = self::sql("SELECT * FROM {$table} ORDER BY {$byID} DESC LIMIT 1");
                unset($pdo);
                return $resultRow;
            }

            return true;
        }

        return false;
    }

    /**
     * @param string $table
     * @param array $data
     * @param string $byID
     * @return null|bool
     */
    public static function update($table, $data, $byID = "")
    {
        $pdo = self::createConnect();

        if ($byID != "") return null;

        $field = '';
        foreach ($data as $keys => $vals) {
            $field .= !empty($field) ? ', ' : '';
            $field .= "$keys = '$vals'";
        }

        $fullSql = "UPDATE {$table} SET {$field} WHERE 1=1 {$byID}";

        $resultQuery = $pdo->query($fullSql)->execute();
        unset($pdo);
        return $resultQuery;
    }

    /**
     * @param string $table
     * @param string $byID
     * @return null|bool
     */
    public static function delete($table, $byID = "")
    {
        $pdo = self::createConnect();

        if ($byID != "") return null;

        $fullSql = "DELETE FROM {$table} WHERE 1=1 {$byID}";

        $resultQuery = $pdo->query($fullSql)->execute();
        unset($pdo);
        return $resultQuery;
    }

    /**
     * @param string $table
     * @param string $byID
     * @return array|object
     */
    public static function read($table, $byID = "")
    {
        $byID = ($byID != "") ? "AND {$byID}" : "";
        return ($table != "") ? self::sql("SELECT * FROM {$table} WHERE 1=1 {$byID}") : [];
    }

    /**
     * @param string $sqlStmt
     * @return mixed
     */
    public static function sql($sqlStmt)
    {
        $pdo = self::createConnect();
        if ($pdo == null) return null;

        if (strstr($sqlStmt, "SELECT") || strstr($sqlStmt, "select")) {
            $resultQuery = $pdo->query($sqlStmt)->fetchAll();
            unset($pdo);

            if (count($resultQuery) > 1) return $resultQuery;
            return isset($resultQuery[0]) ? $resultQuery[0] : [];
            
        } elseif (strstr($sqlStmt, "UPDATE") || strstr($sqlStmt, "update") || strstr($sqlStmt, "DELETE") || strstr($sqlStmt, "delete")) {
            $resultQuery = $pdo->query($sqlStmt)->execute();
            unset($pdo);
            return $resultQuery;
        }

        $resultQuery = $pdo->query($sqlStmt)->execute();
        unset($pdo);
        return $resultQuery;
    }
}
