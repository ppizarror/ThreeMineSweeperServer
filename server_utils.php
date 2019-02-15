<?php
/**
 * SERVER UTILS
 * Utilitary functions.
 *
 * @package server
 * @author Pablo Pizarro R. @ppizarror.com
 * @license MIT
 */

/**
 * Get maximum file upload size.
 *
 * @return int - Tamaño máximo del servidor
 * @since 1.8.5
 **/
function getMaximumFileUploadSize()
{
    return min(convertPHPSizeToBytes(ini_get("post_max_size")), convertPHPSizeToBytes(ini_get("upload_max_filesize")));
}

/**
 * Get PHP.ini file settings.
 *
 * @param string $sSize - Configuration id
 * @return integer - Bits value
 */
function convertPHPSizeToBytes($sSize)
{
    $sSuffix = strtoupper(substr($sSize, -1));
    if (!in_array($sSuffix, array("P", "T", "G", "M", "K"))) {
        return (int)$sSize;
    }
    $iValue = substr($sSize, 0, -1);
    switch ($sSuffix) {
        /** @noinspection PhpMissingBreakStatementInspection */
        case "P":
            $iValue *= 1024;
        // Fallthrough intended
        /** @noinspection PhpMissingBreakStatementInspection */
        case "T":
            $iValue *= 1024;
        // Fallthrough intended
        /** @noinspection PhpMissingBreakStatementInspection */
        case "G":
            $iValue *= 1024;
        // Fallthrough intended
        /** @noinspection PhpMissingBreakStatementInspection */
        case "M":
            $iValue *= 1024;
        // Fallthrough intended
        case "K":
            $iValue *= 1024;
            break;
    }
    return (int)$iValue;
}

/**
 * Enables cors.
 *
 * @return void
 */
function enable_file_cors()
{
    header("Access-Control-Allow-Origin: *");
}

/**
 * Search and updates.
 *
 * @param mysqli $db
 * @param string $searchfield
 * @param string $search
 * @param string $updatefield
 */
function update_table_id_field($db, $searchfield, $search, $updatefield)
{
    $sql = "SELECT id FROM tms_statics WHERE {$searchfield}='{$search}' LIMIT 1";
    $result = $db->query($sql);
    $results[] = $result->fetch_assoc();
    mysqli_free_result($result);

    if (is_null($results[0])) { // Country not found, then insert
        if (is_numeric($search)) {
            $sql = "INSERT INTO tms_statics ({$updatefield},{$searchfield}) VALUES (1,{$search})";
        } else {
            $sql = "INSERT INTO tms_statics ({$updatefield},{$searchfield}) VALUES (1,'{$search}')";
        }
        $db->query($sql);
    } else {
        $id = $results[0]["id"];
        if ($id === 1) return; // Null object
        /** @noinspection SqlWithoutWhere */
        $sql = "UPDATE tms_statics SET {$updatefield}={$updatefield}+1 WHERE id={$id} LIMIT 1";
        $db->query($sql);
    }
}