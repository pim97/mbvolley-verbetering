
<?php
	
session_start();
?>

<?php
// Nodig als de database wordt gebruikt in dit script
require_once 'tools/db.php';
$mysqli =  get_mysqli();
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
			<div class="well"><h1>Standen</h1></div>
			<?php 
				$sqlklassen = "SELECT * FROM klas ORDER BY code";
				$resultklassen = $mysqli->query($sqlklassen);

				if ($resultklassen->num_rows > 0) {
				    // output data of each row
				    while($klasse = $resultklassen->fetch_assoc()) { ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2><i class="fa fa-cubes"></i> <?php echo $klasse['naam'] ?></h2>
						</div>
						<table class="table table-striped">
							<tr>
								<th>#</th>
								<th>Team</th>
								<th>W</th>
								<th>P</th>
								<th>Sv</th>
								<th>St</th>
								<th>S</th>
								<th>Str.p</th>
							</tr>
							<?php 
								$klasseCode = $klasse['code'];
								$sqlteams = "SELECT * FROM STATSVIEW WHERE klasse='".$klasseCode."'";
								$resultteams = $mysqli->query($sqlteams);
								if($resultteams && $resultteams->num_rows > 0) {
									$i = 1;
									while ($team = $resultteams->fetch_assoc()) {
										// Een rij maken in de tabel ?>
										<tr>
											<td><?php echo $i++ ?></td>
											<td><a href="team.php?teamid=<?php echo $team['team'] ?>"><?php echo $team['naam'] ?></td>
											<td><?php echo $team['W'] ?></td>
											<td><?php echo $team['P'] ?></td>
											<td><?php echo $team['Sv'] ?></td>
											<td><?php echo $team['St'] ?></td>
											<td><?php echo $team['S'] ?></td>
											<td><?php echo $team['strp'] ?></td>
										</tr>
									<?php }
								} else {
									echo '<div class="alert alert-warning" role="alert">'.
									'<i class="fa fa-exclamation-triangle"></i> Er zijn nog geen uitslagen voor deze klasse</div>';
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
 