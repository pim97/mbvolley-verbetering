<?php
	
session_start();
?>
<?php
    // Nodig als de database wordt gebruikt in dit script
	require_once 'tools/db.php';
	$mysqli =  get_mysqli();

	// Speeltijden ophalen
    $tijden = Array();
    $sql = "SELECT * FROM ronde";
    $resTijden = $mysqli->query($sql);
    while($rowTijd = $resTijden->fetch_assoc()) {
        $tijden[$rowTijd['id']] = $rowTijd['tijd'];
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
			<div class="well"><h1>Wedstrijdschema</h1></div>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
				<?php 
					$sql = "SELECT * FROM speelweek";
					$resWeken = $mysqli->query($sql);
					if($resWeken->num_rows == 0) {
						echo '<div class="alert alert-warning" role="alert">'.
									'<i class="fa fa-exclamation-triangle"></i> Er zijn geen speelweken gevonden</div>';
					} else {
						$expanded = " in";
						while ($rowWeek = $resWeken->fetch_assoc()) { 
							$date = date("d F Y", strtotime($rowWeek['datum']));
							$panelID = 'heading'.$rowWeek['id'];
							$collapseID = 'collapse'.$rowWeek['id'];
							?>
							
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="<?php echo $panelID ?>">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $collapseID ?>" 
											aria-expanded="false" aria-controls="<?php echo $collapseID ?>">
											Speelweek <?php echo $rowWeek['id'].": ".$date ?>
										</a>
									</h4>
								</div>
								<div id="<?php echo $collapseID ?>" class="panel-collapse collapse<?php echo $expanded ?>" role="tabpanel" 
									aria-labelledby="<?php echo $panelID ?>">
									<div class="panel-body">
										<?php
                                            $speelweek = $rowWeek['id'];
											$sql = "SELECT wedstrijd.*, team.klasse FROM wedstrijd
                                                        LEFT JOIN team ON wedstrijd.team_a = team.id WHERE speelweek = $speelweek";
											$resWedstr = $mysqli->query($sql);
											if(!$resWedstr || $resWedstr->num_rows == 0) {
												echo '<div class="alert alert-info" role="alert">'.
															'<i class="fa fa-info-circle"></i> Er zijn geen wedstrijden gevonden</div>';
											} else {
										?>
										<table class="table table-condensed table-striped">
											<tr>
												<th class="col-sm-1">Wedstrijd</th>
												<th class="col-sm-1">Tijd</th>
												<th class="col-sm-1">Veld</th>
												<th class="col-sm-1">Klas</th>
												<th class="col-sm-3">Team A</th>
												<th class="col-sm-3">Team B</th>
												<th class="col-sm-2">Scheidsrechter/teller</th>
												<th class="col-sm-1">Klas</th>
												<th></th>
											</tr>
											<?php
												while($rowWedstr = $resWedstr->fetch_assoc()) {
													$team_a_id = $rowWedstr['team_a'];

													$sql_team_a = "SELECT naam FROM team WHERE id=$team_a_id";
													$resWedstr_team_a = $mysqli->query($sql_team_a);

													$team_b_id = $rowWedstr['team_b'];
													
													$sql_team_b = "SELECT naam FROM team WHERE id=$team_b_id";
													$resWedstr_team_b = $mysqli->query($sql_team_b);

													$team_scheids_id = $rowWedstr['scheids'];
													
													$sql_team_scheids = "SELECT naam FROM team WHERE id=$team_scheids_id";
													$resWedstr_scheids_b = $mysqli->query($sql_team_scheids);

													echo "<tr>";
													echo "<td>".$rowWedstr['id']."</td>";
													echo '<td>'.$tijden[$rowWedstr['ronde']]."</td>";
													echo "<td>".$rowWedstr['veld']."</td>";
													echo "<td>".$rowWedstr['klasse']."</td>";
													foreach($resWedstr_team_a as $ta) {
														echo "<td>".$ta['naam']."</td>";
													}
													foreach($resWedstr_team_b as $ta) {
														echo "<td>".$ta['naam']."</td>";
													}
													
													foreach($resWedstr_scheids_b as $ta) {
														echo "<td>".$ta['naam']."</td>";
													}
													echo "<td>".$rowWedstr['klasse']."</td>";

													echo "<td>";
													// Kijken of er nog geen uitslag is
													$wedstrijd_id = $rowWedstr['id'];
													$sql = "SELECT COUNT(*) AS uitslag FROM uitslag_set WHERE wedstrijd=$wedstrijd_id";
													$res = $mysqli->query($sql);
													$row = $res->fetch_assoc();
													if ($row['uitslag']==0) {
														echo '<a href="invullenuitslag.php?wedstrijdid='.$wedstrijd_id.'">Uitslag</a>';
													} 
													echo "</td>";
													echo "</tr>";
												}
											?>
										</table>
										<?php } // end if ?> 
									</div>
								</div>
							</div>

							<?php 
							$expanded = "";
						}
					}
				?>


		</main>
	</body>
</html>
 