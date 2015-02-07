<?php
/**
 * Created by PhpStorm.
 * User: Ravjot
 * Date: 09/08/14
 * Time: 2:56 AM
 */
include "cow.php";



//$_SESSION['username'];
if(isset($_POST["name"]) && isset($_POST["pass"]) )
{
/*
    print('{
            "hi":[{"name":"ravjot"}]
            }');
  */
    $USER = "testuser";
    $PASS = "testpass";
    $username = $_POST["name"];
    $password = $_POST["pass"];
    if(($username === $USER) && ($password === $PASS))
    {
        //create a session that stores username
        $_SESSION["username"] = $username;
        //$file = 'list_'. $_SESSION["username"] .'.json';
        $user =$_SESSION["username"];
        $file = './filedir/list_'. $user .'.json';
        //$TODOLIST = json_decode(file_get_contents($file), true);
        $dir = 'filedir';
        if ( !file_exists($dir) ) {
            mkdir ($dir, 0766);
        }
        if(file_exists($file))
        {
            $TODOLIST = json_decode(file_get_contents($file), true);
        }
        echo json_encode($TODOLIST);
    }
    else
    {
        echo("Login Failed");
    }
}
else
{
    /*
        print('{
            "hi":[{"name":"ravjot"}]
        }');
        */
    global $TODOLIST;
    //$todo = $_POST["todo"];
    //array_push($TODOLIST,$TODOLIST ,$todo);

    //$file = 'results.json';
    $user =$_SESSION["username"];
    //$file = 'list_'. $user .'.json';
    $file = './filedir/list_'. $user .'.json';
    if(file_exists($file))
    {
        $TODOLIST = json_decode(file_get_contents($file), true);
    }

    array_shift($TODOLIST);
    $fp = fopen($file, 'w');
    fwrite($fp, json_encode($TODOLIST));
    fclose($fp);
    echo json_encode($TODOLIST);
}
?>