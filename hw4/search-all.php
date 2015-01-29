<?php include("top.html"); ?>
<?php include ("common.php"); ?>
<?php
	$firstname = $_REQUEST['firstname'];
	$lastname = $_REQUEST['lastname'];	
	$count = 0;
    try 
	{
		$check = $db->query("SELECT * from actors where first_name LIKE '$firstname%' AND last_name='$lastname'");
		$selectname = $firstname;
		do
		{
			$val = 0;
			$num = 0;
			foreach($check as $r)
			{
				if($r['film_count'] == $val)
				{
					if($r['id'] > $num)
					{
						continue;
					}
				}
				else if($r['film_count'] > $val)
{
					$val = $r['film_count'];
					$selectname = $r['first_name'];
				}
				$num = $r['id'];
			}
		}while($check->rowCount() > 1);
		
		$rows = $db->prepare(	"SELECT a.id, m.name, m.year 
								FROM actors AS a, movies AS m, roles AS r 
								WHERE a.id = r.actor_id 
									AND m.id = r.movie_id 
									AND a.first_name=:fname 
									AND a.last_name=:lname
									ORDER BY m.year DESC, m.name
								");
		$rows->bindValue (":fname", $selectname);
		$rows->bindValue (":lname", $lastname);
		$rows->execute();
    } 
	catch (PDOException $e) {
		header ("HTTP/1.1 500 Server Error");
		die    ("HTTP/1.1 500 Server Error: Error reading from database: {$e->getMessage()}");
    }
	
?>
		
<h1>Result for <?php print "$firstname $lastname"; ?></h1>
<?php 
	if ($rows->rowCount() > 0) 
	{
?>
<table>
	<caption>Films of <?php print "$firstname $lastname"; ?></caption>
	<tr>
		<th>#</th>
		<th>Title</th>
		<th>Year</th>
	</tr>
	<?php 
		foreach ($rows as $rowIndex => $row)
		{ 
	?>
	<tr>
		<td><?php print ++$count; ?></td>
		<td><?php print $row['name']; ?></td>
		<td><?php print $row['year']; ?></td>
	</tr>
	<?php
		}
	?>
</table>
	<?php 
		 
		}
		else
		{
			print "Actor $firstname $lastname not found.";
		}
	?>

<?php include("bottom.html"); ?>