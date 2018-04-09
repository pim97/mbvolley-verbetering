<?php
	
session_start();
?>
<?php
// Nodig als de database wordt gebruikt in dit script
require_once 'tools/db.php';
$mysqli =  get_mysqli();

//Uitslag ophalen
$result = mysqli_query($mysqli, "SELECT * FROM uitslag_set"); 
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
			<div class="well"><h1>Uitslagen</h1></div>
			<?php
				echo "<table class='table table-striped'>
				<tr>
				<th>Wedstrijd</th>
				<th>Set</th>
				<th>Score Team A</th>
				<th>Score Team B</th>
				<th>Punten Team A</th>
				<th>Punten Team B</th>";

					 while($row = mysqli_fetch_array($result))
					{
						echo "<tr>";
						echo "<td>" . $row['wedstrijd'] . "</td>";
						echo "<td>" . $row['W_set'] . "</td>";
						echo "<td>" . $row['score_a'] . "</td>";
						echo "<td>" . $row['score_b'] . "</td>";
						echo "<td>" . $row['punten_a'] . "</td>";
						echo "<td>" . $row['punten_b'] . "</td>";
				
					   echo "</tr>";
					}
					echo "</table>";
					?>
		</main>
	</body>
</html>
 