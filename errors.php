<?php
/**
 * ERRORS
 * Error admin.
 *
 * @author Pablo Pizarro R. @ppizarror.com
 * @license MIT
 */

/**
 * Error definitions.
 */
const APP_ERROR_BAD_QUERY_TYPE = "bad_query_type";
const APP_ERROR_BAD_SQL = "bad_sql";
const APP_ERROR_DATA = "data_error";
const APP_ERROR_DIE_QUERY = "die_query";
const APP_ERROR_EMPTY_VALUE = "empty_value";
const APP_ERROR_GET = "get_error";
const APP_ERROR_NO_CONNECTION = "no_connection";

/**
 * Throws error.
 *
 * @param string $errortag - Error code
 * @param array $more - Additional information
 * @param boolean $kill - Program ends
 * @return void
 */
function throw_error($errortag, $more = null, $kill = true)
{
    echo generate_error_array($errortag, $more);
    if ($kill) exit();
}

/**
 * Return an error message.
 *
 * @param string $errortag - Error tag
 * @param array $more - Additional information
 * @return string - JSON error
 */
function generate_error_array($errortag, $more = null)
{
    if (is_null($more)) {
        $arr = array("error" => $errortag);
    } else {
        $arr = array("error" => $errortag, "more" => $more);
    }
    return json_encode($arr);
}

/**
 * Throws an error and close database connection.
 *
 * @param string $errortag - Error code
 * @param mysqli $db - Database connection
 * @param array $more - Additional information
 * @param boolean $kill - Program ends
 * @return void
 */
function throw_error_close_db($errortag, $db, $more = null, $kill = true)
{
    $db->close();
    throw_error($errortag, $more, $kill);
}