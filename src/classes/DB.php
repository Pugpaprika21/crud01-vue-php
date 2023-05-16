<?php

class DB
{
    /**
     * @param array $dbConfig
     * @param string $drivers
     * @return mixed
     */
    public static function selectDriver($dbConfig, $drivers = "mysql")
    {
        $driverToUpper = strtoupper($drivers);
        if (isset($dbConfig['DB'])) {

            // switch ($driverToUpper) {
            //     case 'MYSQL':

            //     case 'MSSQL':

            //     case 'MYSQL':

            //     default:
            // }
        }
    }
}
