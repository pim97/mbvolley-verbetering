<?php

require_once 'tools/db.php';

session_start();

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


//Geschreven door Pim
//Simpel wedstrijd algoritme

//Voor de invuldvelden
if (isset($_POST['select_team']) && isset($_POST['veld']) && isset($_POST['ronde'])) {
    $klasse = $_POST['select_team'];
    $veld = $_POST['veld'];
    $ronde = $_POST['ronde'];
    $mysqli =  get_mysqli();

    $query_team = "SELECT id,klasse FROM team";
    $teams_team = $mysqli->query($query_team);
    $teams_array = array();

    
    $teams_random = array();

    foreach($teams_team as $team) {
        if (isset($teams_array) && $teams_array === $team['klasse']) {
            continue;
        }
        array_push($teams_array,$team['klasse']);
    }

    $date = date('Y-m-d', strtotime(' + 7 days'));
    $tijden = array("19:15", "20:15", "21:15");
    $speelweek = 0;
    $tijden_index = 0;
    $wedstrijd = 0;
    $counter_speelweek = 0;
    $counter = 0;

    echo "<table border='1'>";

    $query = "SELECT id, naam, klasse FROM team WHERE klasse='$klasse'";
    $teams = $mysqli->query($query);
    $team_names = array();

    $query_num_rows = "SELECT wedstrijd FROM uitslag_set";
    $result_rows = $mysqli->query($query_num_rows);
    
    foreach($teams as $team) {
        array_push($team_names,$team['id']);
    }

    $team_size = mysqli_num_rows($teams);
    $start = mysqli_num_rows($result_rows);
        

    while ($team_size > 0) {
        $team = $team_names[$team_size - 1];

        foreach ($team_names as $team_data) {
            if ($team_data == $team) {
                continue; 
            }
            $scheids = rand(1,25);

            while ($scheids == $team || $scheids == $team_data) {
                if ($scheids > 1) {
                    $scheids--;
                } else {
                    $scheids++;
                }
            }

            $wedstrijd++;
            $counter_speelweek++;
            $spel = $speelweek + 1;
            
            //Meerdere keren de SQL uitvoeren
            $start_query_uitslag_set = $wedstrijd + $start;
            

            $sql_uitslag = "INSERT INTO uitslag_set(wedstrijd, W_set) VALUES ('$start_query_uitslag_set', '$veld')";
            $sql_wedstrijd = "INSERT INTO wedstrijd(speelweek, ronde, veld, team_a, team_b, scheids, wedstrijd) VALUES ('$spel', '$ronde', '$veld', '$team', '$team_data', '$scheids', '$start_query_uitslag_set')";

            $result_uit = mysqli_query($mysqli, $sql_uitslag);
            $veld++;
            $sql_uitslag = "INSERT INTO uitslag_set(wedstrijd, W_set) VALUES ('$start_query_uitslag_set', '$veld')";

            $result_uit = mysqli_query($mysqli, $sql_uitslag);
            $veld++;
            $sql_uitslag = "INSERT INTO uitslag_set(wedstrijd, W_set) VALUES ('$start_query_uitslag_set', '$veld')";
            

            $result_uit = mysqli_query($mysqli, $sql_uitslag);
            $veld++;
            $sql_uitslag = "INSERT INTO uitslag_set(wedstrijd, W_set) VALUES ('$start_query_uitslag_set', '$veld')";
            

            $result_uit = mysqli_query($mysqli, $sql_uitslag);
            $veld++;
            $sql_uitslag = "INSERT INTO uitslag_set(wedstrijd, W_set) VALUES ('$start_query_uitslag_set', '$veld')";

            if ($veld > 4) {
                $veld = 1;
            }

            $result2 = mysqli_query($mysqli, $sql_wedstrijd);

            //Eventuele sql fouten
            echo(mysqli_error($mysqli));

            if ($counter_speelweek >= 1) {
                $counter_speelweek = 0;
                $speelweek++;
                $date = date('Y-m-d', strtotime($date.' + 7 days'));
            }

            $tijden_index++;
            if ($tijden_index % 3 == 0) {
                $tijden_index = 0;
            }
            $counter++;

        }

        $team_size--;
    }
    $team_names = null;
    // }

    echo "</table>";

    $msg =  "Gelukt, alles staat nu in de database!";

    }

    ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>MBV Volley Account aanmaken</title>

        <link rel="stylesheet" type="text/css" href="./css/style_create_account.css">

		<?php include 'head.html' ?>		
	</head>
	<body>
		<?php include 'header.php' ?>
		<main class="container">	
            
        <div class="well flex">
         
         <!-- Invuld veld in HTML -->

    <?php
    if ($person_rank == $admin_rights ) {   
    ?>
    <h3>Deze data wordt automatisch in uw database gezet, u hoeft niets te doen</h3>
    <form method="post" action="">
        
        Genereer uw wedstrijdschema

        <table>

        <tr>
            <td>
                <label for="team">Welke team wilt u genereren?</label>

                <select name="select_team">
                    <option name="h1" value="h1">H1</option>
                    <option name="h2" value="h2">H2</option>
                    <option name="d1" value="d1">D1</option>
                    <option name="d2"  value="d2">D2</option>
                </select>

                <!-- <input placeholder="Team" type="text" name="klasse" id="" required></input> -->
            </td>
        </tr>

            
        <tr>
            <td>        
                <label for="veld">Welk veld wilt u gebruiken?</label>
                <input placeholder="Veld" type="text" name="veld" id="" required></input>
            </td>
        </tr>    

        <tr>
            <td>            
                <label for="ronde">Welke ronde wilt u gebruiken?</label>
                <input placeholder="Ronde" type="text" name="ronde" id="" required></input>
            </td>
        </tr>
        
        </table>    

        <input class="button_center btn btn-info" type='submit' name='gen' value='Genereer' required></input>
        
    </form>

    <?php
    if (isset($msg)) {
        echo $msg;
    }
    ?>

        </div>
    <?php
    } else {
        echo "U heeft geen admin rechten";
    }
    ?>
		</main>
	</body>
</html>
