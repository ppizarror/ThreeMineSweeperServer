<?php
/**
 * SCORE
 * Score admin.
 *
 * @author Pablo Pizarro R. @ppizarror.com
 * @license MIT
 */

/**
 * ----------------------------------------------------------------------------
 * Library imports
 * ----------------------------------------------------------------------------
 */
require_once("dbconfig.php");
require_once("errors.php");
require_once("server_utils.php");
require_once("utils.php");
require_once("utils.php");
enable_file_cors();

/**
 * ----------------------------------------------------------------------------
 * Creates server connection
 * ----------------------------------------------------------------------------
 */
$db = DbConfig::getConnection();
if ($db->connect_error) throw_error_close_db(APP_ERROR_NO_CONNECTION, $db);

/**
 * ----------------------------------------------------------------------------
 * $_GET only
 * ----------------------------------------------------------------------------
 */
if ($_POST or !$_GET) throw_error(APP_ERROR_DATA);

/**
 * ----------------------------------------------------------------------------
 * Get method
 * ----------------------------------------------------------------------------
 */
if (!check_get_vars(array("m"), false)) {
    throw_error_close_db(APP_ERROR_DATA, $db);
} else {
    $method = sanitize_input($db, $_GET["m"]);
}

/**
 * ----------------------------------------------------------------------------
 * Trigger method
 * ----------------------------------------------------------------------------
 */
switch ($method) {

    /**
     * ------------------------------------------------------------------------
     * Get score
     * ------------------------------------------------------------------------
     */
    case "get":

        // Get variables
        if (!check_get_vars(array("id", "g"), false)) {
            throw_error_close_db(APP_ERROR_DATA, $db);
        }
        $id = sanitize_input($db, urldecode($_GET["id"]));
        $gen = sanitize_input($db, urldecode($_GET["g"]));

        // Validate data
        if (!validate_string_size($id, 32, 32) ||
            !validate_number($gen, 0, 100)) {
            throw_error_close_db(APP_ERROR_DATA, $db);
        }
        $gen = intval($gen);

        // Select data
        $sql = "SELECT country,date,time,user FROM tms_score WHERE gen='{$id}' ORDER BY time ASC LIMIT 10";
        $result = $db->query($sql) or die(generate_error_array(APP_ERROR_DIE_QUERY));
        $newdata = array();
        while ($row = $result->fetch_assoc()) {
            $newdata[] = $row;
        }
        mysqli_free_result($result);
        echo json_encode($newdata);

        // Update statics
        $sql = "UPDATE tms_statics SET games=games+1 WHERE id=1 LIMIT 1";
        $db->query($sql);
        update_table_id_field($db, "gen", $gen, "games");

        break;

    /**
     * ------------------------------------------------------------------------
     * Upload score
     * ------------------------------------------------------------------------
     */
    case "upload":

        // Get variables
        if (!check_get_vars(array("id", "u", "c", "t", "g"), false)) {
            throw_error_close_db(APP_ERROR_DATA, $db);
        }
        $id = sanitize_input($db, urldecode($_GET["id"]));
        $user = sanitize_input($db, urldecode($_GET["u"]));
        $country = sanitize_input($db, urldecode($_GET["c"]));
        $time = sanitize_input($db, urldecode($_GET["t"]));
        $gen = sanitize_input($db, urldecode($_GET["g"]));
        if ($country === "") $country = "none";

        // Validate data
        if (!validate_string_size($id, 32, 32) ||
            !validate_string_size($user, 4, 20) ||
            !validate_string_size($country, 2, 10) ||
            !validate_string_size($time, 1, 10) ||
            !validate_number($time, 0.0001, 86400) ||
            !validate_number($gen, 0, 100)) {
            throw_error_close_db(APP_ERROR_DATA, $db);
        }
        $time = floatval($time);
        $gen = intval($gen);

        // Create date
        try {
            $date = new DateTime();
        } catch (Exception $e) {
            throw_error_close_db(APP_ERROR_DATA, $db);
        }
        $d = $date->format(SERVER_HOUR_FORMAT);

        // Upload to server
        $sql = "INSERT INTO tms_score (gen, user, time, country, date) VALUES ('{$id}','{$user}',{$time},'{$country}','{$d}')";
        if ($db->query($sql) === true) {
            echo json_encode([]);
        } else {
            throw_error_close_db(APP_ERROR_BAD_SQL, $db);
        }

        // Update statics
        $sql = "UPDATE tms_statics SET scoreboard=scoreboard+1 WHERE id=1 LIMIT 1";
        $db->query($sql);
        update_table_id_field($db, "country", $country, "scoreboard");
        update_table_id_field($db, "gen", $gen, "scoreboard");

        break;

    /**
     * ------------------------------------------------------------------------
     * Download stats
     * ------------------------------------------------------------------------
     */
    case "stats":
        $sql = "SELECT * FROM tms_statics";
        $result = $db->query($sql) or die(generate_error_array(APP_ERROR_DIE_QUERY));
        $newdata = array();
        while ($row = $result->fetch_assoc()) {
            $rowdata = [];
            $rowdata["sid"] = $row["id"];
            $rowdata["sc"] = $row["scoreboard"];
            $rowdata["n"] = $row["games"];
            $rowdata["c"] = $row["country"];
            $rowdata["g"] = $row["gen"];
            $newdata[] = $rowdata;
        }
        mysqli_free_result($result);
        echo json_encode($newdata);
        break;

    /**
     * ------------------------------------------------------------------------
     * Unknown method
     * ------------------------------------------------------------------------
     */
    default:
        throw_error_close_db(APP_ERROR_BAD_QUERY_TYPE, $db);
        break;
}

/**
 * ----------------------------------------------------------------------------
 * Close db connection
 * ----------------------------------------------------------------------------
 */
$db->close();