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
    $rows = $db->query("Select * from student");
  ?>
 <body>
	<table>
		<?php 
			foreach($rows as $row){
		?>
		<tr>
			<td><?php print $row["id"] ?></td>
			<td><?php print $row["Name"] ?></td>
		</tr>
		
		<?php
			}
		?>
	</table>
 </body>
</html>