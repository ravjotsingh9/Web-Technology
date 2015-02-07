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
        $TODOLIST= $_POST["todo"];
        //array_push($TODOLIST,$TODOLIST ,$todo);
        $user =$_SESSION["username"];
        //$file = 'list_'. $user .'.json';
        $file = './filedir/list_'. $user .'.json';
        //$file = 'list_'. $USER .'.json';

            //$TODOLIST = json_decode(file_get_contents($file), true);
            $fp = fopen($file, 'w');
            fwrite($fp, $TODOLIST);
            //fwrite($fp, $_POST["todo"]);
            fclose($fp);

        $TODOLIST = json_decode(file_get_contents($file), true);

        echo json_encode($TODOLIST);
    }
}
?>