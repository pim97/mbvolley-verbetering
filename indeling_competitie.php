<?php
	
session_start();
?>
<?php
    // Nodig als de database wordt gebruikt in dit script
    require_once 'tools/db.php';
	$mysqli =  get_mysqli();
	
	$admin_rights = 3;
	$person_rank = 0;
	
	if (isset($_SESSION['id'])) {
		$id = $_SESSION['id'];
	
		$query = "SELECT `verificatie` FROM lid WHERE id=$id";
		$conn = $mysqli->query($query);
		
		foreach($conn as $rank) {
			if ($rank['verificatie'] == $admin_rights) {
				$person_rank = 3;
			}
		}
	
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
			<div class="well">
				<h1>Indeling Competitie</h1>
				<p>Bekijk hier welke teams er bij elkaar in een klasse zitten. Klik op een teamnaam om meer te weten te komen van dat team.</p>
			</div>
			<?php 
				// SQL query ophalen data van klas
				$sqlklassen = "SELECT * FROM klas ORDER BY code";
				$resultklassen = $mysqli->query($sqlklassen);

				if ($resultklassen->num_rows > 0) {
				    // Create tabel voor elke spelersklasse
				    while($klasse = $resultklassen->fetch_assoc()) { ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2><i class="fa fa-cubes"></i> <?php echo $klasse['naam'] ?>
													
							<?php // Als admin rechten geef team toevoegen optie
							if ($person_rank == 3)
							{
							 echo '<a class="btn btn-default" href="teamtoevoegen.php?klasse=' . $klasse['code'] . '"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>';			
							}
							?>
							</h2>
						</div>
						<table class="table table-striped">
							<?php 
								$klasseCode = $klasse['code'];
								$sqlteams = "SELECT * FROM team WHERE klasse='".$klasseCode."'";
								$resultteams = $mysqli->query($sqlteams);
								if($resultteams->num_rows > 0) {
									while ($team = $resultteams->fetch_assoc()) {
										$link  = "<tr><td width = 30px>";
										$link .= '<i class="fa fa-users"></i></td><td>';
										$link .= '<a href="team.php?teamid='.$team['id'].'">';
										$link .=  $team['naam'].'</a></td></tr>';
										echo $link;
									}
								} else {
									echo '<div class="alert alert-warning" role="alert">'.
									'<i class="fa fa-exclamation-triangle"></i> Er zijn geen teams in deze klasse</div>';
								}
							?>
						</table>
						</div>
				    <?php }
				} else {
					echo '<div class="alert alert-warning" role="alert">'.
						'<i class="fa fa-exclamation-triangle"></i> Er zijn geen klassen in deze competitie</div>';
				}

			?>
		</main>
	</body>
</html>
 