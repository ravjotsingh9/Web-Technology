<!DOCTYPE html>
<!--
	Name: 			Ravjot Singh
	S. No.:			87050134
	Description:	PHP file
	File Content:	This file contains reviews of movies dynamically
-->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>Rancid Tomatoes</title>
		<meta charset="utf-8">
		<link href="movie.css" type="text/css" rel="stylesheet">
		<link href=" http://ws.mss.icics.ubc.ca/~cics516/cur/hw/hw2/images/rotten.gif" type="image/gif" rel="shortcut icon" />
		<style type="text/css"></style>
		<?php 
		// retreive name of the movie from get request
				$movie = $_REQUEST["film"];
				//$movie = "tmnt2";
				//echo $movie;
		?>
	</head>

	<body>
		<div class="banner">	
			<img src=" http://ws.mss.icics.ubc.ca/~cics516/cur/hw/hw2/images/banner.png" alt="Rancid Tomatoes">
		</div>
		
		<h1>
			<?php
			// print the name of the movie
				$lines = file("$movie/info.txt");
				print $lines[0];
				print "($lines[1])";
			?>
		</h1>
			<div class="content">
				<div class="rightcontent">
					<div>
						<img src=" <?php print $movie ?>/overview.png" alt="general overview">
					</div>

					<dl class="padlist">
						<?php
							$lines = file("$movie/overview.txt");
							//Read Overview and display the content
							foreach($lines as $line)
							{
								$tokens = explode(":",$line);
							
						?>
						
							<dt>
								<?php
									print $tokens[0];
								?>
							</dt>
							<dd>
								<?php 
									if($tokens[0] != "LINKS") 
									{
										print $tokens[1];
									}
									else // If it is link concatenate the fist two tokens
									{
										print $tokens[1].$tokens[2];
									}
								?>
							</dd>
						<?php
							}
						?>
					</dl>
				</div>
	
				<div class="leftcontent">
					<div class="rottenbigimage">
						<?php
						// Decide which big image is to displayed
							$bigimg = "a";
							$lines = file("$movie/info.txt");
							if($lines[2]<60)
							{
								 $bigimg = "rottenbig";
							}
							else
							{
								$bigimg = "freshbig";
							}
						?>
						<img src=" http://ws.mss.icics.ubc.ca/~cics516/cur/hw/hw3/images/<?php print "$bigimg" ?>.png" alt="Rotten">
						<?php print "$lines[2]";?>%
					</div>
					<?php
					// count the number reviews
						$folder = $movie;
						$filenames = glob("$folder/review*");
						if (((count($filenames)))%2==0)
						{
							$left = (int)((((count($filenames)))/2)-1);
						}
						else
						{
							$left = (int)((((count($filenames)))/2));
						}
					?>
					<div class="leftdiv">
					<?php
					// display the reviews in the left div
					for($i=0; $i <= $left ; $i++)
						{
							$lines = file("$filenames[$i]");
						if($filenames[$i] != "info.txt" && $filenames[$i] != "overview.txt")
							{
								
								//if($lines[1] == "FRESH\n")
								//{
									$IMG ="http://ws.mss.icics.ubc.ca/~cics516/cur/hw/hw3/images/" . trim(strtolower($lines[1])) . ".gif";
								//}
								//else
								//{
									//$IMG ="http://ws.mss.icics.ubc.ca/~cics516/cur/hw/hw3/images/rotten.gif";
								//}
									
					?>
										
						<p class="review">
							<img src=<?php print $IMG?> alt="Image" >
							<q>
								<?php
									
									print $lines[0];
								?>
							</q>
						</p>
						<p class="reviewer">
							<img src=" http://ws.mss.icics.ubc.ca/~cics516/cur/hw/hw2/images/critic.gif" alt="Critic">
							<?php
									print $lines[2];
							?> <br>
							<em>
								<?php
									print $lines[3];
								?>
							</em>
						</p>
						
						<?php
							}
						}
					
					?>
					</div>
					<div class="rightdiv">
					<?php
					// display rest of the reviews in the right div
					for($i = $left+1; $i < count($filenames) ; $i++)
					{
						$lines = file("$filenames[$i]");
						if($filenames[$i] != "info.txt" && $filenames[$i] != "overview.txt")
							{
							
								$IMGE ="http://ws.mss.icics.ubc.ca/~cics516/cur/hw/hw3/images/" . trim(strtolower($lines[1])) . ".gif";
								
									
					?>
										
						<p class="review">
							<img src=<?php print $IMGE?> alt="Image" >
							<q>
								<?php
									
									print $lines[0];
								?>
							</q>
						</p>
						<p class="reviewer">
							<img src=" http://ws.mss.icics.ubc.ca/~cics516/cur/hw/hw2/images/critic.gif" alt="Critic">
							<?php
									print $lines[2];
							?> <br>
							<em>
								<?php
									print $lines[3];
								?>
							</em>
						</p>
						<?php
							}
						}
						?>
					</div>
				</div>
				<p class="footer">(1-<?php print count($filenames)?>) of <?php print count($filenames) ?></p>
			</div>
		<div class="fixed">
			<a href="https://webster.cs.washington.edu/validate-html.php"><img src=" http://ws.mss.icics.ubc.ca/~cics516/cur/hw/hw1/images/w3c-html.png" alt="Valid HTML5"></a> <br>
			<a href="https://webster.cs.washington.edu/validate-css.php"><img src=" http://ws.mss.icics.ubc.ca/~cics516/cur/hw/hw2/images/w3c-css.png" alt="Valid CSS"></a>
		</div>
	

</body></html>