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
		}while(($check->rowCount() > 1));
		$rows = $db->prepare(
								"SELECT m1.name, m1.year 
								FROM movies AS m1, movies AS m2, roles AS r1, roles AS r2, actors AS a1, actors AS a2
								WHERE a1.first_name=:fname AND a1.last_name=:lname 
									AND a2.first_name= 'kevin' AND a2.last_name= 'Bacon'
									AND r1.actor_id = a1.id AND r2.actor_id = a2.id
									AND r1.movie_id = m1.id AND r2.movie_id = m2.id
									AND r1.movie_id = r2.movie_id
								ORDER BY m1.year DESC, m1.name"
							);
		
		$rows->bindValue (":fname", $selectname);
		$rows->bindValue (":lname", $lastname);
		$rows->execute();
	   
    } 
	catch (PDOException $e) 
	{
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
	<caption>Films with <?php print "$selectname $lastname"; ?> and Kevin Bacon</caption>
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
		print "$firstname $lastname wasn't in any films with Kevin Bacon.";
	}
?>

		
<?php include("bottom.html"); ?>
	