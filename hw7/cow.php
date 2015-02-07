<?php
/**
 * Created by PhpStorm.
 * User: Ravjot
 * Date: 09/08/14
 * Time: 2:56 AM
 */

//global $TODOLIST;
$TODOLIST = array();
session_save_path("/ubc/icics/mss/ravjot1/public_html/php_tmp");
session_start();
$_SESSION["username"];
?>