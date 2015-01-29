<?php include("top.html"); ?>
<?php include ("common.php"); ?>
<?php
 	$count = 0;
	
    try 
	{
		
		if ($_SERVER ["REQUEST_METHOD"] == "POST")
		{
			
			if (isset($_POST["insert"]))
			{
				//print "I'm Here";
				$errorMsg = "";
				if(isset($_POST['fname']) && isset($_POST['rank']) 
				&& isset($_POST['year'])
				&& $_POST['fname'] != "" && $_POST['rank'] != ""
				&& $_POST['year'] != "" )
				{
					$validName = "/^[a-z][a-z ]*$/i";   
					$validyear   = "/^\\s*(\d{4})\s*$/";
					$fname = $_POST['fname'];
					$rank = $_POST['rank'];
					$year = $_POST['year'];
					
					if (! preg_match ($validName, $fname))
					{
						$errorMsg = "$errorMsg<li>Invalid film name</li>";
					}
					else if((! preg_match ($validyear, $year)) && ($year > '2014'))
					{
						$errorMsg = "$errorMsg<li>Invalid year</li>";
					}
					
					if(isset($_POST['SelectActors']))
					{
							
					
						//print $fname;
						if(isset($_POST['SelectDirector']) && $_POST['SelectDirector']!="" )
						{
							$SelectDirector = $_POST['SelectDirector'];
							//print $SelectDirector;
							if(isset($_POST['SelectGenre']) && $_POST['SelectGenre']!="" && isset($_POST['role']) && $_POST['role']!= "")
							{
								$roles = $_POST['role'];
								$roleArray = explode(":", $roles);
								$SelectGenre = $_POST['SelectGenre'];
								//print $SelectGenre;
								
									for($i=0; $i < count($_POST['SelectActors']); $i++)
									{
										$actors = $_POST['SelectActors'][$i];
										//print $actors;
									}
									$SelectActors =$_POST['SelectActors'];
		
									//find id
									$mid = $db->prepare("Select max(id) as id from movies");
									$mid->execute();
									$id =0;
									foreach($mid as $d)
									{
										$id = $d['id'];
									}
									$id= $id+1;
									//print '------------------'.$id;
									//Insert movie
									$insertmovie = $db->prepare("INSERT INTO movies(id, name, year, rank) values(:id, :fname, :year, :rank) ");
									$insertmovie->bindValue (":id", $id);
									$insertmovie->bindValue (":fname", $fname);
									$insertmovie->bindValue (":year", $year);
									$insertmovie->bindValue (":rank", $rank);
									$insertmovie->execute();
									///print '-1';
									//insert director-movie
									$insertdirectormovie= $db->prepare("INSERT INTO movies_directors values(:d_id, :m_id)");
									$insertdirectormovie->bindvalue(":d_id", $SelectDirector);
									$insertdirectormovie->bindvalue(":m_id", $id);
									$insertdirectormovie->execute();
									//print '-2';
									//inseert movies_genres
									$insertmoviesg= $db->prepare("INSERT INTO movies_genres values(:m_id, :genres)");
									$insertmoviesg->bindvalue(":m_id", $id);
									$insertmoviesg->bindvalue(":genres", $SelectGenre);
									$insertmoviesg->execute();
									//print '-3';
									if(count($roleArray) == count($SelectActors))
									{
										$rcount =0;
										foreach($SelectActors as  $atr)
										{
											//find movie count
											$Qmoviecount= $db->prepare("select film_count from actors where id= :id ");
											$Qmoviecount->bindvalue(":id", $atr);
											$Qmoviecount->execute();
											$moviecount =0;
											foreach($Qmoviecount as $c)
											{
												$moviecount = $c['film_count'];
											}
											$moviecount= $moviecount+1;
											//print '-4';
											//update count
											$updatemoviecount= $db->prepare("UPDATE actors SET film_count = :count where id = :id");
											$updatemoviecount->bindvalue(":count", $moviecount);
											$updatemoviecount->bindvalue(":id", $atr);
											$updatemoviecount->execute();
											//print '-5';
											//insert role
											$updaterole= $db->prepare("insert into roles values(:a_id, :m_id, :rl)");
											$updaterole->bindvalue(":a_id", $atr);
											$updaterole->bindvalue(":m_id", $id);
											$updaterole->bindvalue(":rl", $roleArray[$rcount]);
											$updaterole->execute();
											//print '-6';
											$rcount =$rcount +1;
									}
								}
								else
								{
									$errorMsg = "$errorMsg<li>Actor-Role selection mismatch</li>";
								}
								
							}
							else
							{
								$errorMsg = "$errorMsg<li>Genre Not Selected</li>";
							}
						}
						else
						{
							$errorMsg = "$errorMsg<li>Director Not Selected</li>";
						}
					}
					else
					{
							$errorMsg = "$errorMsg<li>Actor Not Selected</li>
							<li>Also write Role Name per Actor Selected</li>";
					}
				}
				else
				{
					$errorMsg = "$errorMsg<li>All fields in Film Detail are mandatory</li>";
				}
				
				if($errorMsg != "") 
				{
					echo("<ul>" . $errorMsg . "</ul>\n");
				}	 
				else
				{
					echo("<ul>" . "Inserted!!" . "</ul>\n");
				}
			}
			
		}
		$genres = $db->query ("SELECT genre FROM movies_genres GROUP BY genre");
	   $actors = $db->query ("SELECT id, first_name, last_name FROM actors");
	   $directors = $db->query ("SELECT id, first_name, last_name FROM directors");
	}
	catch (PDOException $e) 
	{
		header ("HTTP/1.1 500 Server Error");
		die    ("HTTP/1.1 500 Server Error: Error reading from database: {$e->getMessage()}");
    }
	
	?>


	<form method="post">
		<fieldset>
			<legend>Contribute to IMDB</legend>
			<span class="add-filmLabel">Enter Details</span>
			<div>
				<input type="text"  name="fname" id="fname" placeholder="Film name"><br/>
				<input type="text"  name="rank" id="rank" placeholder="Film Rank"><br/>
				<input type="text"  name="year" id="year" placeholder="Year">
				
			</div>

			<br/>
			
			<div>
				<span>Select Actors</span><br/> 
					
				<select multiple name = "SelectActors[]" >
				<?php 
					foreach($actors as $actor)
					{ 
				?>
					<option value="<?php print $actor['id']; ?>" >
					<?php print $actor['first_name'].$actor['last_name']; ?>
					</option>
					
				<?php 
					} 
				?>
				</select>				
			</div>
			<br/>
			<div>
				<span>Actor Roles</span><br/>
				<input type="text" name="role" size="40" id="role" placeholder="Robert:William:Shezuka:Rahul">
			</div>
			<br/>
			<div>
				<span>Director</span> <br/>
				<select name="SelectDirector">
					<option value="">
					Select One Value
					</option>
					<?php 
						foreach($directors as $rowIndex => $director)
						{ 
					?>
						<option value = "<?php print $director['id'];?>">
							<?php print $director['first_name'].$director['last_name']; ?>
						</option>
					<?php 
						} 
					?>
				</select>
			</div>
			<br/>
			
			<div>
				<span>Genre</span><br/> 
				<select name = "SelectGenre">
					<?php 
						foreach($genres as $genre)
						{ 
					?>
						<option value="<?php print $genre['genre']; ?>">
							<?php print $genre['genre']; ?>
						</option>
					<?php 
						} 
					?>
				</select>
			</div>
			<br/>
			
			<div>
				<input type="submit" name="insert" value="Insert">
			</div>
		</fieldset>
		
	</form>
	<br/>
	<br/>
<?php include("bottom.html"); ?>
