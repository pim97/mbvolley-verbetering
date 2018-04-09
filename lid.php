<?php


session_start();


// Nodig als de database wordt gebruikt in dit script
require_once 'tools/db.php';
$mysqli =  get_mysqli();


// Check of gebruiker admin rights heeft
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
// Haal het lid ID uit het HTTP request
$lid_id = 0;
if(isset($_GET['lidid'])) {
    $lid_id = $_GET['lidid'];
}

// Heef edit mogelijkheden als admin rights
$edit = 0;
if(isset($_GET['edit'])) {
    if ($person_rank == $admin_rights ) {
        $edit = $_GET['edit'];
    }
}

// Geef admin mogelijkheid om lid te verifiëren
if(isset($_GET['verify'])) {
    if ($person_rank == $admin_rights) {
        $query = "UPDATE lid SET verificatie='1' WHERE id=$lid_id";
        mysqli_query($mysqli, $query);

        $msg =  "Het persoon is nu een geverifiëerde gebruiker";
    }
}

// Als naam is ingevuld haal ingevulde data op & store in variable
if(isset($_POST['naam'])){
    if ($person_rank == $admin_rights || $_SESSION['id'] == $lid_id) {
        $naam = $_POST['naam'];
        $leeftijd = $_POST['leeftijd'];
        $woonplaats = $_POST['woonplaats'];
        $registratiedatum = $_POST['registratiedatum'];
        $mailadres = $_POST['mailadres'];
        $team_id = $_POST['teamid'];

        // SQL query om informatie van lid te updaten naar ingevulde data
        $query = "UPDATE lid SET naam='$naam',leeftijd='$leeftijd', woonplaats='$woonplaats', registratiedatum='$registratiedatum', mailadres='$mailadres', team_id='$team_id' WHERE id=$lid_id";
        mysqli_query($mysqli, $query);
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

    <?php
    //Als edit ingeschakeld
    if(isset($_GET['edit'])){

        ?>
        <div role="tabpanel">
            <!-- Navigatie -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#spelers" aria-controls="spelers" role="tab" data-toggle="tab">Profiel</a></li>

                <!-- Nog niet werkende navigatie tabs

                <li role="presentation"><a href="#wedstrijden" aria-controls="wedstrijden" role="tab" data-toggle="tab">Wedstrijden</a></li>
                <li role="presentation"><a href="#uitslagen" aria-controls="uitslagen" role="tab" data-toggle="tab">Uitslagen</a></li>
                <li role="presentation"><a href="#statistieken" aria-controls="statistieken" role="tab" data-toggle="tab">Statistieken</a></li>
                -->
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="spelers">
                    <?php // Ophalen van lid data uit database & displayen

                    // SQL query voor ophalen lid data uit database
                    $sql = "SELECT * FROM lid WHERE id=".$lid_id;
                    $lid_info = $mysqli->query($sql);


                    // Create inputvelden met data van lid
                    echo '<table class="table table-striped">';
                    foreach($lid_info as $lid) {
                    ?>
                    <form name="form" action="lid.php?lidid=<?php echo $lid_id?>" method="post">

                        <tr>
                            <td class="col-sm-1">
                                <i class="fa fa-user fa-3x"></i>
                            </td>
                            <td class="col-sm-11">

                                <input name="naam" type="text" class="form-control" value="<?php echo $lid['naam'] ?>" placeholder="Naam" aria-describedby="basic-addon1">

                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-1">
                                <i class="fa fa-certificate fa-3x"></i>
                            </td>
                            <td class="col-sm-11">

                                <input name="leeftijd" type="text" class="form-control" value="Leeftijd:<?php echo $lid['leeftijd'] ?>" placeholder="Leeftijd" aria-describedby="basic-addon1">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-1">
                                <i class="fa fa-home fa-3x"></i>
                            </td>
                            <td class="col-sm-11">

                                <input name="woonplaats" type="text" class="form-control" value="<?php echo $lid['woonplaats'] ?>" placeholder="Woonplaats" aria-describedby="basic-addon1">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-1">
                                <i class="fa fa-calendar fa-3x"></i>
                            </td>
                            <td class="col-sm-11">

                                <input name="registratiedatum" type="date" class="form-control" value="<?php echo $lid['registratiedatum'] ?>" placeholder="Registratiedatum" aria-describedby="basic-addon1">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-1">
                                <i class="fa fa-envelope fa-3x"></i>
                            </td>
                            <td class="col-sm-11">

                                <input name="mailadres" type="text" class="form-control" value="<?php echo $lid['mailadres'] ?>" placeholder="e-mailadres" aria-describedby="basic-addon1">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-1">
                                <i class="fa fa-users fa-3x"></i>
                            </td>
                            <td class="col-sm-11">

                                <input name="teamid" type="text" class="form-control" value="<?php echo $lid['team_id'] ?>" placeholder="teamid" aria-describedby="basic-addon1">
                            </td>
                        </tr>

                        <?php }

                        echo "</table>";

                        ?>
                        <!-- Button om ingevulde data te updaten in database -->
                        <button type="submit" class="btn btn-info">Opslaan</button>

                    </form>

                </div>

            </div>
        </div>
        <?php

        // Als edit niet ingeschakeld
    }else{
    ?>
    <div role="tabpanel">
        <!-- Navigatie -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#spelers" aria-controls="spelers" role="tab" data-toggle="tab">Profiel</a></li>

            <!-- Nog niet werkende navigatie tabs

            <li role="presentation"><a href="#wedstrijden" aria-controls="wedstrijden" role="tab" data-toggle="tab">Wedstrijden</a></li>
            <li role="presentation"><a href="#uitslagen" aria-controls="uitslagen" role="tab" data-toggle="tab">Uitslagen</a></li>
            <li role="presentation"><a href="#statistieken" aria-controls="statistieken" role="tab" data-toggle="tab">Statistieken</a></li>
            -->
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="spelers">
                <?php // Ophalen van lid data uit database & displayen

                // query voor ophalen lid info uit database
                $sql = "SELECT * FROM lid WHERE id=".$lid_id;
                $lid_info = $mysqli->query($sql);

                // Create table met informatie lid met een relevante icon
                echo '<table class="table table-striped">';
                foreach($lid_info as $lid) {

                    ?>
                    <tr>
                        <td class="col-sm-1">
                            <i class="fa fa-user fa-3x"></i>
                        </td>
                        <td class="col-sm-11">
                            <strong><?php echo 'Naam: ' . $lid['naam'] . '' ?></a></strong><br/>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-sm-1">
                            <i class="fa fa-certificate fa-3x"></i>
                        </td>
                        <td class="col-sm-11">
                            <strong><?php echo 'Leeftijd: ' .$lid['leeftijd'] . '' ?></a></strong><br/>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-sm-1">
                            <i class="fa fa-home fa-3x"></i>
                        </td>
                        <td class="col-sm-11">
                            <strong><?php echo 'Woonplaats: '. $lid['woonplaats'] . '' ?></a></strong><br/>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-sm-1">
                            <i class="fa fa-calendar fa-3x"></i>
                        </td>
                        <td class="col-sm-11">
                            <strong><?php echo 'Registratiedatum: '.$lid['registratiedatum']. '' ?></a></strong><br/>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-sm-1">
                            <i class="fa fa-envelope fa-3x"></i>
                        </td>
                        <td class="col-sm-11">
                            <strong><?php echo 'Email: '. $lid['mailadres']. '' ?></a></strong><br/>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-sm-1">
                            <i class="fa fa-users fa-3x"></i>
                        </td>
                        <td class="col-sm-11">

                            <!-- Display id & naam van team van lid -->
                            <strong><?php
                                $sql = "SELECT * FROM team WHERE id=". $lid['team_id'];
                                $result = $mysqli->query($sql);
                                if($result->num_rows >0) {
                                    $row = $result->fetch_assoc();
                                    $teamnaam = $row['naam'];
                                    echo 'Team '. $lid['team_id'] . ': <a href="team.php?teamid='. $lid['team_id'] . '">'. $teamnaam .'</a>';
                                }
                                ?></a></strong><br/>
                        </td>
                    </tr>
                <?php }
                echo "</table>";
                ?>
            </div>
            <?php

            // Display informatie verificatie mogelijkheden
            if (isset($_SESSION['id'])) {
                $rights_other_person = "SELECT `verificatie` FROM lid WHERE id=$lid_id";
                $query_other_person =  $mysqli->query($rights_other_person);

                // Als admin geef mogelijkheid lid te verifiëren
                if ($person_rank == 3) {
                    foreach ($query_other_person as $query_rights) {

                        if ($query_rights['verificatie'] == 0) {
                            echo "Deze gebruiker is nog niet geverifiëerd door een administrator en heeft beperkte rechten";

                            echo '<a href="lid.php?lidid=' . $lid_id . '&verify=true">
							<br/>
							<button type="submit" class="btn btn-info">Verifieer gebruiker</button>
	
						</a>';
                        }
                    }
                    // Create verifieer button
                    $_SESSION['admin'] = true;
                    echo '<a href="lid.php?lidid=' . $lid_id . '&edit=true">
						
					<button type="submit" class="btn btn-info">Update gegevens</button>
					
					</a>';

                    // Als ingelogd lid op eigen lid pagina geef edit mogelijkheden
                } else if ($_SESSION['id'] == $lid_id)

                {
                    echo '<a href="lid.php?lidid=' . $lid_id . '&edit=true">
					
					<button type="submit" class="btn btn-info">Update gegevens</button>
				
					</a>';
                }
                // Display verificatie info
                if (isset($msg)) {
                    echo "<br/><br/>".$msg;
                }
            }?>

        </div>
        <?php
        }
        ?>
</main>
</body>
</html>