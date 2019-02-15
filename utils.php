<?php
/**
 * UTILS
 * General functions.
 *
 * @author Pablo Pizarro R. @ppizarror.com
 * @license MIT
 */

/**
 * Sanitize input
 *
 * @param mysqli $db - Database connection
 * @param string $input - Content
 * @return string - Sanitized input
 */
function sanitize_input($db, $input)
{
    return $db->real_escape_string(htmlspecialchars($input));
}

/**
 * Check {@link $vars} exists in {@link $_POST}.
 *
 * @param array $vars - Variables to check
 * @param boolean $check_size - Check {@link $_POST} size
 * @return boolean - Variables exist
 */
function check_post_vars($vars, $check_size = true)
{

    /**
     * Check variables
     */
    foreach ($vars as $k) {
        if (!isset($_POST[$k])) {
            return false;
        }
    }

    /**
     * Check size
     */
    if ($check_size) {
        $post_length = count(array_keys($_POST));
        if ($post_length !== count($vars)) {
            return false;
        }
    }

    /**
     * Valid
     */
    return true;

}

/**
 * Check variables {@link $vars} exist in {@link $_GET}.
 *
 * @param array $vars - Variables to check
 * @param boolean $check_size - Check {@link $_GET} size
 * @return boolean - Variables exist
 */
function check_get_vars($vars, $check_size = true)
{

    /**
     * Check variables
     */
    foreach ($vars as $k) {
        if (!isset($_GET[$k])) {
            return false;
        }
    }

    /**
     * Check size
     */
    if ($check_size) {
        $get_length = count(array_keys($_GET));
        if ($get_length !== count($vars)) {
            return false;
        }
    }

    /**
     * Valid
     */
    return true;

}

/**
 * Check string size.
 *
 * @param string $s - String
 * @param int $minl - Min size
 * @param int $maxl - Max size
 * @return boolean - String is valid
 */
function validate_string_size($s, $minl = -1, $maxl = -1)
{
    $l = strlen(str_replace("\r", "", str_replace("\n", "", trim($s))));
    if ($minl !== -1 and $maxl !== -1) {
        if ($minl <= $l and $l <= $maxl) {
            return true;
        }
    } else {
        if ($minl === -1) {
            if ($l <= $maxl) {
                return true;
            }
        } else {
            if ($l >= $minl) {
                return true;
            }
        }
    }
    return false;
}

/**
 * Validates number.
 *
 * @param string $number - Number as string
 * @param number $min - Min number
 * @param number $max - Max number
 * @return bool
 */
function validate_number($number, $min, $max)
{
    if (!is_numeric($number)) return false;
    $number = floatval($number);
    return $number >= $min and $number <= $max;
}