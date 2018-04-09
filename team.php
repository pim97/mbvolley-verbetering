
<?php
	
session_start();
?>
<?php

// Nodig als de database wordt gebruikt in dit script
require_once 'tools/db.php';
$mysqli =  get_mysqli();

// Haal het team ID uit het HTTP request
$team_id = 0;
if(isset($_GET['teamid'])) {
    $team_id = $_GET['teamid'];
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>MBV Volley</title>
		<?php include 'head.html' ?>		
	</head>
	<body>
		<?php include 'header.php' ?>
		<main class="container">
		<?php
		// Display Team id & team

			$sql = "SELECT * FROM team WHERE id=".$team_id;
			$result = $mysqli->query($sql);
			if($result->num_rows >0) {
				$row = $result->fetch_assoc();
				$teamnaam = $row['naam'];
				echo '<div class="well"><h1>Team '. $team_id . ': '. $teamnaam .'</h1></div>';
		    } ?>

		<div role="tabpanel">
			<!-- navigatie tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#spelers" aria-controls="spelers" role="tab" data-toggle="tab">De spelers</a></li>

				<!-- Nog niet werkende navigatie tabs 
				<li role="presentation"><a href="#wedstrijden" aria-controls="wedstrijden" role="tab" data-toggle="tab">Wedstrijden</a></li>
				<li role="presentation"><a href="#uitslagen" aria-controls="uitslagen" role="tab" data-toggle="tab">Uitslagen</a></li>
				<li role="presentation"><a href="#statistieken" aria-controls="statistieken" role="tab" data-toggle="tab">Statistieken</a></li>
				-->
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="spelers">
					<?php 
					// Dispay spelers van dit team
					
					$sql = "SELECT * FROM team_has_lid WHERE team=".$team_id;
					$teamlid_id = $mysqli->query($sql);
						echo '<table class="table table-striped">';
						
						// Haal informatie op van de teamleden uit database
						foreach($teamlid_id as $teamlid) { 
						
							$sql = "SELECT * FROM lid WHERE id=".(int)$teamlid['lid'];
							$lid = $mysqli->query($sql);
							
							// Display naam van elk teamlid in table met icon
							foreach($lid as $ld) {
								?>
								<tr>
									<td class="col-sm-1">
										<i class="fa fa-user fa-3x"></i>
									</td>
									<td class="col-sm-11">
									<strong><a href="lid.php?lidid=<?php echo $ld['id']?>"><?php echo $ld['naam'] ?></a></strong><br/>
									</td>
								</tr>
							<?php 
							} 
						}
						echo "</table>";
					 ?>
				</div>
			</div>
		</div>

		</main>
	</body>
</html>
 