<!DOCTYPE html>
<html>

  <?php
    
    // PHP Initialization
    ini_set         ('display_errors', 1);
    error_reporting (E_ALL | E_STRICT);
    
    // Open the DB
    $dbunix_socket = '/ubc/icics/mss/cics516/db/cur/mysql/mysql.sock';
    $dbuser        = 'cics516';
    $dbpass        = 'cics516password';
    $dbname        = 'cics516';
    try {
      $db = new PDO ("mysql:unix_socket=$dbunix_socket;dbname=$dbname", $dbuser, $dbpass);
      $db->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      header ("HTTP/1.1 500 Server Error");
      die    ("HTTP/1.1 500 Server Error: Database Unavailable ({$e->getMessage()})");
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['insert'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $s = $db->prepare ("insert into student values (:id,:name);");
        $s->bindParam (":id", $id);
        $s->bindParam (":name", $name);
        try {
          $s->execute();
        } catch (PDOException $e) {
          print ("<p>Error inserting</p>");
        }
      } else if (isset($_POST['delete'])) {
        $s = $db->prepare ("delete from student where id = :id;");
        $s->bindParam (":id", $id);
        foreach ($_POST['selectedrow'] as $rownum) {
          $id = $_POST['id'][$rownum];
          $s->execute();
        }
      } else if (isset($_POST['update'])) {
        $s = $db->prepare ("update student set name = :name where id = :id;");
        $s->bindParam (":id", $id);
        $s->bindParam (":name", $name);
        foreach ($_POST['selectedrow'] as $rownum) {
          $id   = $_POST['id'][$rownum];
          $name = $_POST['studentname'][$rownum];
          $s->execute();
        }
      }
    }
    
    $rows = $db->query ("select * from student;");
    
  ?>

  <body>
    <form action="" method="post">
      <table>
        <?php foreach ($rows as $rownum => $row): ?>
          <tr>
            <input type="hidden" name="id[]" value="<?php print $row['id']; ?>" />
            <td><input type="checkbox" name="selectedrow[]" value="<?php print $rownum; ?>" /></td>
            <td><?php print $row['id']; ?></td>
            <td><input type="text" name="studentname[]" value="<?php print $row['name']; ?>" /></td>
          </tr>
        <?php endforeach ?>
      </table>
      <input type="submit" name="delete" value="Delete" />
      <input type="submit" name="update" value="Update" />
    </form>

    <form action="" method="post">
      <label>ID <input type="text" name="id" /></label>
      <label>Name <input type="text" name="name" /></label>
      <input type="submit" name="insert" value="Insert" />
    </form>
  </body>
</html>