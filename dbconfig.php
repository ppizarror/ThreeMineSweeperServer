<?php
/**
 * DBCONFIG
 * Main connection class.
 *
 * @author Pablo Pizarro R. @ppizarror.com
 * @license MIT
 */

/**
 * Server configuration
 */
const SERVER_DAY_FORMAT = "Y-m-d";
const SERVER_HOUR_FORMAT = "Y-m-d H:i:s";
const SERVER_TIMEZONE = "America/Santiago";

/**
 * Set timezone
 */
date_default_timezone_set(SERVER_TIMEZONE);

/**
 * Class DbConfig
 * Database connection.
 *
 * @example
 *      $db = DbConfig::getConnection();
 *      $sql = "..."
 *      $result = $db->query($sql);
 *      $res = array();
 *      while ($row = $result->fetch_assoc()) {
 *          $res[] = $row;
 *      }
 *      $db->close();
 */
class DbConfig
{
    private static $db_host = "localhost"; // Server
    private static $db_name = "tms"; // Database
    private static $db_pass = ""; // Password
    private static $db_port = 3306; // Server port
    private static $db_user = "root"; // MySQL user

    /**
     * Set database connection.
     * @return mysqli
     */
    public static function getConnection()
    {
        $mysqli = new mysqli(self::$db_host, self::$db_user, self::$db_pass, self::$db_name, self::$db_port);
        $mysqli->set_charset("utf8");
        return $mysqli;
    }
}