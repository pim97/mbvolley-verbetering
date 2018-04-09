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
	<?php
if (isset($_GET["wedstrijdid"])) {
	$id = $_GET["wedstrijdid"];


$query = "SELECT * FROM wedstrijd WHERE id= $id";
$result = mysqli_query($mysqli, $query);

if($result->num_rows > 0) {
	$data = $result->fetch_assoc();
}

}
// Speelweek - Datum
$speelweek = $data['speelweek'];
$query_datum = "SELECT * FROM speelweek WHERE id= $speelweek";
$result_datum = mysqli_query($mysqli, $query_datum);

if($result_datum->num_rows > 0) {
	$datum = $result_datum->fetch_assoc();
}
// Ronde - Tijd
$ronde = $data['ronde'];
$query_tijd = "SELECT * FROM ronde WHERE id= $ronde";
$result_tijd = mysqli_query($mysqli, $query_tijd);

if($result_tijd->num_rows > 0) {
	$tijd = $result_tijd->fetch_assoc();
}

// Team - Klasse
$team_klasse = $data['team_a'];
$query_klasse = "SELECT klasse FROM team WHERE id= $team_klasse";
$result_klasse = mysqli_query($mysqli, $query_klasse);

if($result_klasse->num_rows > 0) {
	$klasse = $result_klasse->fetch_assoc();
} 

// Team - Scheids
$scheids = $data['scheids'];
$query_scheids = "SELECT naam FROM team WHERE id= $scheids";
$result_scheids = mysqli_query($mysqli, $query_scheids);

if($result_scheids->num_rows > 0) {
	$team_scheids = $result_scheids->fetch_assoc();
}

// Team - Team A
$teama = $data['team_a'];
$query_teama = "SELECT naam FROM team WHERE id= $teama";
$result_teama = mysqli_query($mysqli, $query_teama);

if($result_teama->num_rows > 0) {
	$team_a = $result_teama->fetch_assoc();
}

// Team - Team B
$teamb = $data['team_b'];
$query_teamb = "SELECT naam FROM team WHERE id= $teamb";
$result_teamb = mysqli_query($mysqli, $query_teamb);

if($result_teamb->num_rows > 0) {
	$team_b = $result_teamb->fetch_assoc();
}

// TEST

if(isset($_POST['add_S1Sa'])){
	$S1Sa = $_POST['add_S1Sa'];
	$S1Sb = $_POST['add_S1Sb'];
	$S1Pa = $_POST['add_Pa_S1'];
	$S1Pb = $_POST['add_Pb_S1'];
	
	$S2Sa = $_POST['add_S2Sa'];
	$S2Sb = $_POST['add_S2Sb'];
	$S2Pa = $_POST['add_Pa_S2'];
	$S2Pb = $_POST['add_Pb_S2'];
	
	$S3Sa = $_POST['add_S3Sa'];
	$S3Sb = $_POST['add_S3Sb'];
	$S3Pa = $_POST['add_Pa_S3'];
	$S3Pb = $_POST['add_Pb_S3'];
	
	$S4Sa = $_POST['add_S4Sa'];
	$S4Sb = $_POST['add_S4Sb'];
	$S4Pa = $_POST['add_Pa_S4'];
	$S4Pb = $_POST['add_Pb_S4'];

	$Wed_id = $id;
}

?>

		<?php include 'header.php' ?>
		<main class="container">	
			<div class="well"><h1>Invullen uitslag</h1></div>
			<form method="POST">
				<div class="panel panel-default">
					<div class="panel-heading">
							<div class="row">
							
								<div class="col-xs-4"><strong>DATUM:</strong> <?php echo $datum['datum'] ?></div>
								<div class="col-xs-4"><strong>TIJD:</strong> <?php echo $tijd['tijd'] ?></div>
								<div class="col-xs-2"><strong>VELD:</strong> <?php echo $data['veld'] ?></div>
								<div class="col-xs-2"><strong>KLASSE:</strong> <?php echo $klasse['klasse'] ?></div>
							</div>
							<br/>
							<div class="row">
								<div class="col-xs-12"><strong>SCHEIDSRECHTER:</strong> <?php echo $team_scheids['naam'] ?></div>
							</div>
							<br/>
							<div class="row">
								<div class="col-xs-6"><strong>TEAM A:</strong> <?php echo $team_a['naam'] ?></div>
								<div class="col-xs-6"><strong>TEAM B:</strong> <?php echo $team_b['naam'] ?></div>
							</div>
					</div>
					<div class="panel-body">
						<input type="hidden" name="wedstrijdid" value="<?php echo $wedstrijddata['id'] ?>" />
						<table class="table table-striped">
							<thead>
								<tr>
									<th rowspan="2">SET</th>
									<th colspan="2">SCORE</th>
									<th colspan="2">PUNTEN</th>
								</tr>
								<tr>
									<th>TEAM A</th>
									<th>TEAM B</th>
									<th>TEAM A</th>
									<th>TEAM B</th>
								</tr>
							</thead>
							<tbody>
							<h3>*Let op: Alle velden dienen ingevuld te worden!*</h3>
							</form>
							<form name="Uitslag_Form" action="" method="post">
								<tr>
									<th><strong>Set 1</strong></th>
									<th><input type="text" class="form-control" name="add_S1Sa"	placeholder="Score Team A*" value="<?php if(isset($S1Sa)) {echo $S1Sa;}?>"></th>
									<th><input type="text" class="form-control" name="add_S1Sb" placeholder="Score Team B*" value="<?php if(isset($S1Sb)) {echo $S1Sb;}?>"></th>
									<th><select name="add_Pa_S1" class="form-control">
											<option <?php echo (isset($_POST['add_Pa_S1']) && $_POST['add_Pa_S1'] == '0') ? 'selected="selected"' : ''; ?> value="0">0</option>
											<option <?php echo (isset($_POST['add_Pa_S1']) && $_POST['add_Pa_S1'] == '2') ? 'selected="selected"' : ''; ?> value="2">2</option></select></th>
									<th><select name="add_Pb_S1" class="form-control">
											<option <?php echo (isset($_POST['add_Pb_S1']) && $_POST['add_Pb_S1'] == '0') ? 'selected="selected"' : ''; ?> value="0">0</option>
											<option <?php echo (isset($_POST['add_Pb_S1']) && $_POST['add_Pb_S1'] == '2') ? 'selected="selected"' : ''; ?> value="2">2</option></select></th>
						</tr>
								<tr>
									<th><strong>Set 2</strong></th>
									<th><input type="text" class="form-control" name="add_S2Sa" placeholder="Score Team A*" value="<?php if(isset($S2Sa)) {echo $S2Sa;}?>"></th>
									<th><input type="text" class="form-control" name="add_S2Sb" placeholder="Score Team B*" value="<?php if(isset($S2Sb)) {echo $S2Sb;}?>"></th>
									<th><select name="add_Pa_S2" class="form-control">
											<option <?php echo (isset($_POST['add_Pa_S2']) && $_POST['add_Pa_S2'] == '0') ? 'selected="selected"' : ''; ?> value="0">0</option>
											<option <?php echo (isset($_POST['add_Pa_S2']) && $_POST['add_Pa_S2'] == '2') ? 'selected="selected"' : ''; ?> value="2">2</option></select></th>
									<th><select name="add_Pb_S2" class="form-control">
											<option <?php echo (isset($_POST['add_Pb_S2']) && $_POST['add_Pb_S2'] == '0') ? 'selected="selected"' : ''; ?> value="0">0</option>
											<option <?php echo (isset($_POST['add_Pb_S2']) && $_POST['add_Pb_S2'] == '2') ? 'selected="selected"' : ''; ?> value="2">2</option></select></th>
				</tr>
								<tr>
									<th><strong>Set 3</strong></th>
									<th><input type="text" class="form-control" name="add_S3Sa" placeholder="Score Team A*" value="<?php if(isset($S3Sa)) {echo $S3Sa;}?>"></th>
									<th><input type="text" class="form-control" name="add_S3Sb" placeholder="Score Team B*" value="<?php if(isset($S3Sb)) {echo $S3Sb;}?>"></th>
									<th><select name="add_Pa_S3" class="form-control">
											<option <?php echo (isset($_POST['add_Pa_S3']) && $_POST['add_Pa_S3'] == '0') ? 'selected="selected"' : ''; ?> value="0">0</option>
											<option <?php echo (isset($_POST['add_Pa_S3']) && $_POST['add_Pa_S3'] == '2') ? 'selected="selected"' : ''; ?> value="2">2</option></select></th>
									<th><select name="add_Pb_S3" class="form-control">
											<option <?php echo (isset($_POST['add_Pb_S3']) && $_POST['add_Pb_S3'] == '0') ? 'selected="selected"' : ''; ?> value="0">0</option>
											<option <?php echo (isset($_POST['add_Pb_S3']) && $_POST['add_Pb_S3'] == '2') ? 'selected="selected"' : ''; ?> value="2">2</option></select></th>
						</tr>
								<tr>
									<th><strong>Set 4</strong></th>
									<th><input type="text" class="form-control" name="add_S4Sa" placeholder="Score Team A*" value="<?php if(isset($S4Sa)) {echo $S4Sa;}?>"></th>
									<th><input type="text" class="form-control" name="add_S4Sb" placeholder="Score Team B*" value="<?php if(isset($S4Sb)) {echo $S4Sb;}?>"></th>
									<th><select name="add_Pa_S4" class="form-control">
											<option <?php echo (isset($_POST['add_Pa_S4']) && $_POST['add_Pa_S4'] == '0') ? 'selected="selected"' : ''; ?> value="0">0</option>
											<option <?php echo (isset($_POST['add_Pa_S4']) && $_POST['add_Pa_S4'] == '2') ? 'selected="selected"' : ''; ?> value="2">2</option></select></th>
									<th><select name="add_Pb_S4" class="form-control">
											<option <?php echo (isset($_POST['add_Pb_S4']) && $_POST['add_Pb_S4'] == '0') ? 'selected="selected"' : ''; ?> value="0">0</option>
											<option <?php echo (isset($_POST['add_Pb_S4']) && $_POST['add_Pb_S4'] == '2') ? 'selected="selected"' : ''; ?> value="2">2</option></select></th>
						</tr>
							</tbody>
						</table>
						
					</div>
					<div class="panel-footer">

					<?php // Als admin rechten geef opslaan optie
							if ($person_rank == 3)
							{ ?>
								<button type="submit" name="Submit" class="btn btn-primary">Opslaan</button><?php
							}
							?>
					
					<a href=./uitslagen.php><button type="button" class="btn btn-primary">Ga naar de Uitslag pagina >>></button></a>
					
						<?php 
					if(isset($_POST['Submit'])){
								$S1Sa = $_POST['add_S1Sa'];
								$S1Sb = $_POST['add_S1Sb'];
								$S1Pa = $_POST['add_Pa_S1'];
								$S1Pb = $_POST['add_Pb_S1'];
								
								$S2Sa = $_POST['add_S2Sa'];
								$S2Sb = $_POST['add_S2Sb'];
								$S2Pa = $_POST['add_Pa_S2'];
								$S2Pb = $_POST['add_Pb_S2'];
								
								$S3Sa = $_POST['add_S3Sa'];
								$S3Sb = $_POST['add_S3Sb'];
								$S3Pa = $_POST['add_Pa_S3'];
								$S3Pb = $_POST['add_Pb_S3'];
								
								$S4Sa = $_POST['add_S4Sa'];
								$S4Sb = $_POST['add_S4Sb'];
								$S4Pa = $_POST['add_Pa_S4'];
								$S4Pb = $_POST['add_Pb_S4'];

								$Wed_id = $id;
								
								
								// All values of 1 row must be filled in.
								$sql_submit = "INSERT INTO uitslag_set (wedstrijd, W_set, score_a, score_b, punten_a, punten_b) VALUES
								($Wed_id, 1, $S1Sa, $S1Sb, $S1Pa, $S1Pb),
								($Wed_id, 2, $S2Sa, $S2Sb, $S2Pa, $S2Pb),
								($Wed_id, 3, $S3Sa, $S3Sb, $S3Pa, $S3Pb), 
								($Wed_id, 4, $S4Sa, $S4Sb, $S4Pa, $S4Pb)
								";
								mysqli_query($mysqli, $sql_submit);
								echo "<strong>De uitslag is toegevoegd</strong>";
								}

					if(isset($_POST['Update'])){
						// echo("You updated the database!");
						//and then execute a sql query here

						$sql_update = "INSERT INTO uitslag_set (wedstrijd, W_set, score_a, score_b, punten_a, punten_b) VALUES
							 ($Wed_id, 1, $S1Sa, $S1Sb, $S1Pa, $S1Pb),
							 ($Wed_id, 2, $S2Sa, $S2Sb, $S2Pa, $S2Pb),
							 ($Wed_id, 3, $S3Sa, $S3Sb, $S3Pa, $S3Pb), 
							 ($Wed_id, 4, $S4Sa, $S4Sb, $S4Pa, $S4Pb)
							 ON DUPLICATE KEY UPDATE wedstrijd=VALUES(wedstrijd),
							 score_a=VALUES(score_a),
							 score_b=VALUES(score_b),
							 punten_a=VALUES(punten_a),
							 punten_b=VALUES(punten_b)";

								mysqli_query($mysqli, $sql_update);
								echo "<strong>De uitslag is upgedate in de Database</strong>";
							

						// $sql_update = "UPDATE uitslag_set SET score_a = '$S1Sa, $' WHERE $Wed_id";
						}

						mysqli_close ($mysqli)
						
						?>
						
					</div>
				</div>
			</form>
		</main>
	</body>
</html>
 