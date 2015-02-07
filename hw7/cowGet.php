<?php
/**
 * Created by PhpStorm.
 * User: Ravjot
 * Date: 09/08/14
 * Time: 2:57 AM
 */
include "cow.php";
if (isset($_SESSION["username"]))
{
    if(isset($_POST["todo"]) )
    {
        /*
            print('{
                    "hi":[{"name":"ravjot"}]
                    }');
          */
        global $TODOLIST;
        $todo = $_POST["todo"];
        //array_push($TODOLIST,$TODOLIST ,$todo);

        //$file = 'list_'. $USER .'.json';
        //$file = 'list_'. $_SESSION["username"] .'.json';
        $user =$_SESSION["username"];
        //$file = 'list_'. $user .'.json';
        $file = './filedir/list_'. $user .'.json';
        if(file_exists($file))
        {
            $TODOLIST = json_decode(file_get_contents($file), true);
        }
        $TODOLIST[] = $todo;
        $fp = fopen($file, 'w');
        fwrite($fp, json_encode($TODOLIST));
        fclose($fp);
        echo json_encode($TODOLIST);
    }
}
?>