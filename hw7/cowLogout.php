<?php
/**
 * Created by PhpStorm.
 * User: Ravjot
 * Date: 09/08/14
 * Time: 2:56 AM
 */
include "cow.php";
if (isset($_SESSION["username"]))
{
    session_destroy();
    echo("Done");
}
?>