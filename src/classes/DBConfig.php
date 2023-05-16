<?php

class DBConfig
{
    /**
     * @return PDO|null
     */
    protected static function createConnect()
    {
        $config = require __DIR__ . "/../configs/public_settings.php";

        if (isset($config)) {
            $dsn = "mysql:host={$config['DB']['HOST']};dbname={$config['DB']['NAME']};charset={$config['DB']['CHAR_SET']}";
            return new PDO($dsn, $config['DB']['USER'], $config['DB']['PASS'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES   => false
            ]);
        }
        return null;
    }
}
