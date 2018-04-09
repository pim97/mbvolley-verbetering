<?php

    //Starten van de sessie
    session_start();

    //Als de ip in de sessie verandert, dan sluit hij de sessie af. Tegen sessie hijacking
    if (isset($_SESSION['ip'])) {
        if ($_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
            session_destroy();

            header('Location: create.php');
            exit;
        }
    }

    //Na een bepaalde tijd de sessie login_attempt weggooien en de sessie beëindigen
    if (isset($_SESSION['login_attempt']) && (time() - $_SESSION['login_attempt'] > 1800)) {
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
    }
    
    //Database connection initialize
    include './tools/db.php'; 

    //Wanneer je ingelogd bent, laat de naam zien van het ingelogde persoon
    if (isset($_SESSION['login_naam'])) {
        $msg3 =  "Je bent nog ingelogd als " . $_SESSION['login_naam'];
    }

    //Een unieke server salt die je gebruikt ana het einde van de password, waardoor het moeilijker te unhashen is
    $unique_server_salt = "Z2cLZ2tdXbIz4cG2qUWE7dHfpaZih6LYnmxIovys0YIWHmOKLbxicId5VzJd5dv8E9huxbUa6lW6MACLBfab30JHgRK5Fl3eZ9Z1CgrBBTuEsrbCM62zx1u1xhKJ7wBxcSJVYC9k4dazCsxub1P3iMgcDkLsKpoZt8EF0GlMWfWgW0FQYAWQdb0X9EJqv3MoU1ubePZnwQ5d0l4wWJSP7c3GwGnVwlFhSlIscgIl4FZkKdOlrgcmnbFvPuKYv1ol";    

    //Kijkt of alles geset is
    if (isset($_POST['personen_naam']) && isset($_POST['team_naam']) && isset($_POST['leeftijd']) && isset($_POST['woonplaats']) && isset($_POST['mailadres']) && isset($_POST['wachtwoord'])) {
        
        //Verschillende details die zijn ingevuld in het formulier
        $naam = $_POST['personen_naam'];
        $team = intval($_POST['team_naam']);
        $leeftijd = $_POST['leeftijd'];
        $woonplaats = $_POST['woonplaats'];

        //Real escape string tegen mysql injesctions
        $mailadres = mysqli_real_escape_string($mysqli,$_POST['mailadres']);
        $password = mysqli_real_escape_string($mysqli, $_POST['wachtwoord']);
        $password_blank = mysqli_real_escape_string($mysqli, $_POST['wachtwoord']);
        $password_repeat = mysqli_real_escape_string($mysqli, $_POST['wachtwoord_herhaal']);

        //Elk wachtwoord in de database krijgt een unieke salt
        $allowed_characters_salting = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
        $characters_length = 63;
        $salt_length = 128;
        $salt= "";
       
        //Aan de $salt wordt telkens een nieuwe letter random toegevoegd
        for($i=0; $i < $salt_length; $i++)
        {
            $salt .= $allowed_characters_salting[mt_rand(0 , $characters_length)];
        }

        //Wachrwoord krijgt een salt en een server salt voor extra beveiliging
        $password = $salt . $password . $unique_server_salt;

        //Wachtwoord wordt gehashed
        $hashed_password = password_hash(hash('sha512', $password, false), PASSWORD_BCRYPT);

        //Maakt een query en verbindt deze met de database
        $query_count = "SELECT `mailadres` FROM lid WHERE mailadres = '$mailadres'";
        $result_count = mysqli_query($mysqli, $query_count);

        //Checkt of verschillende vereisten er wel zijn bij het inloggen
        if ($leeftijd > 0 || $team > 0) {
            if ($password_blank === $password_repeat) {
                if (mysqli_num_rows($result_count) <= 0) {

                    //Verbinding met de database
                    $query = "INSERT INTO `lid`( `naam`, `leeftijd`, `team_id`, `woonplaats`, `mailadres`, `registratiedatum`, `password`, `salt`) VALUES ('$naam', $leeftijd , $team, '$woonplaats', '$mailadres', now(), '$hashed_password', '$salt')";
                    $result = $mysqli->query($query);
                    
                    $query2 = "SELECT * FROM lid WHERE mailadres='$mailadres'";
                    $result2 = $mysqli->query($query2);
                    
                    //Stopt data in de database en zet een variabele $ld_id
                    while ($row = mysqli_fetch_assoc($result2)){
                        
                        $ld_id = $row['id'];
                        $query3 = "INSERT INTO `team_has_lid`( `team`, `lid`) VALUES ($team, $ld_id)";
                        $mysqli->query($query3);

                    }
                   
                    //Checked of de e-mail adres klopt
                    if (filter_var($mailadres, FILTER_VALIDATE_EMAIL)) {

                        //Checked of het account inderdaad aangemaakt is
                        if ($result) {
                            $msg = "Uw account is gemaakt, u moet nu wachten tot een admin uw account verifieert";
                        } else {   
                            $msg = "Iets kon niet worden geplaatst in onze database, check alsjeblieft nog eens uw ingevulde gegevens";
                        }
                    } else {
                        $msg = "Uw ingevoerde e-mail is niet correct";
                    }
                } else {
                    $msg = "U heeft al een account op dit email adres";
                }
            } else {
                $msg = "Uw eerste ingevulde wachtwoord " . $password_blank . " komt niet overeen met uw herhaalde wachtwoord " . $password_repeat;
            }
        } else {
            $msg = "U kunt geen negatieve getallen invoeren";
        }
        

    //Checked of bepaalde velden inderdaad zijn ingevuld
    } else if (isset($_POST['login']) && isset($_POST['pass'])) {
        
        $query = "SELECT `password`, `mailadres`, `salt`, `id` FROM `lid`";
        $result = mysqli_query($mysqli, $query);
        $max_attempts = 5;

        //Je mag maar een aantal keer proberen voordat je eruit wordt gezet voor 30 minuten
        if (!isset($_SESSION['login_attempt_counter'])) {
            $_SESSION['login_attempt_counter'] = 1;
        }
         
        //Je mag maar een aantal keer proberen voordat je eruit wordt gezet voor 30 minuten
        if (isset($_SESSION['login_attempt_counter']) && $_SESSION['login_attempt_counter'] <= $max_attempts) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

                    $naam = $_POST['login'];
                
                    //Eerst weer alles valideren
                    if (filter_var($naam, FILTER_VALIDATE_EMAIL)) {
                        if (strlen($naam) > 0 && strlen($password) > 0) {

                            //Checked of wachtwoord overeenkomt
                            if ($row['mailadres'] == $naam) {
                                $salt = $row['salt'];
                                $password = $salt . mysqli_real_escape_string($mysqli, $_POST['pass']) . $unique_server_salt;
                                $verify = password_verify(hash('sha512', $password, false), $row['password']);

                                //Checked of wachtwoord overeenkomt
                                if ($verify) {
                                    $id = $row['id'];
                                    
                                    $_SESSION['login_naam'] = $naam;
                                    $_SESSION['logged_in'] = true;
                                    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
                                    $_SESSION['id'] = $id;

                                    $msg2 = "Welkom " . $_SESSION['login_naam'] . ", Je bent nu ingelogd!";

                                    //Stuurt persoon door naar create.php
                                    header('Location: ./create.php');
                                } else {
                                    $msg2 = "Je gebruikersnaam of wachtwoord is incorrect";
                                }
                            } else {
                                $msg2 = "Je gebruikersnaam of wachtwoord is incorrect";
                            }
                        } else {
                            $msg2 = "Je moet wel iets intypen bij naam en password";
                        }
                    } else {
                        $msg2 = "Uw ingevoerde e-mail is niet correct";
                    }
                } 
            } else {
                $msg2 = "Je wachtwoord of je gebruikersnaam is incorrect";
            }
        } else {
            $msg2 = "Je hebt te vaak fout ingelogd, je mag de komende 30 minuten niet meer inloggen";
        }

    //Logt het persoon uit
    } else if (isset($_POST['uitloggen'])) {
        session_destroy();

        header('Location: ./create.php');
    }

?>


<!-- HTML voor de velden -->


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
            <div class="centered_bs">

            <?php

            if (isset($msg3)) {
                echo "<p style='text-align:center;'>" . $msg3 . "</p>";
            }

            if (!isset($_SESSION['login_naam'])) {
            ?>
        
            <form class="login_form" method="post" action="create.php"> 
                
            <h2>
                <span class="glyphicon glyphicon-lock"/>
                </span>
                Login met uw naam en wachtwoord
            </h2>
                    
            <fieldset>

            
                
            <table class="table">
                <tr>
                    <p>Om op deze website in te loggen, dient u hieronder uw e-mail adres en wachtwoord te plaatsen</p>
                </tr>

                <tr>
                    <td class="one">
                        <!-- <span class="fa fa-home"/></span> -->
                        <label for="inlog">E-mail</label>
                        
                        <td>
                            <input placeholder="Uw e-mail"type="email" name="login" id="" required></input>
                        </td>

                    </td>

                </tr>

                <tr>
                    <td class="one">
                        <!-- <span class="fa fa-home"/></span> -->
                        <label for="pass">Wachtwoord</label>
                        
                        <td>
                        <input placeholder="Uw wachtwoord" type="password" name="pass" id="" required></input>
                    </td>
                    </td>

                </tr>
                
                </table>


                
            </fieldset>
                    
            <input class="button_center btn btn-info" type='submit' name='Submit' value='Inloggen' required></input>
                  

                    
            <?php
            } else {
            ?>  
                    
            <br/>
            <form class="log_out" method="post" action="create.php">
                <input class="button_center btn btn-info" type='submit' name='uitloggen' value='Uitloggen' required></input>
            </form>
            

            <?php
            }
                    
            if (isset($msg2)) {
                if (isset($_SESSION['login_attempt_counter'])) {
                    $_SESSION['login_attempt_counter']++;
                }           
                echo "<br/>".$msg2;

                if ($_SESSION['login_attempt_counter'] <= $max_attempts) {
                    echo "<br/>Je hebt " . ($max_attempts - $_SESSION['login_attempt_counter']) . " logins over, hierna moet je 30 minuten wachten";
                }
            }
            ?>
            </fieldset> 

        </form>
       
       <br>

       
       </div>
    </div>

    <?php

    if (!isset($_SESSION['login_naam'])) {
    ?>

    <div class="well flex">
        <div class="centered_bs">
            <form class="register_form" method="post" action="create.php">
                <fieldset>
                    <table class="table">
                        <tr>
                            <h2><span class="glyphicon glyphicon-bookmark"/></span> Uw account aanmaken</h4>
                        </tr>

                        <tr>
                            <td class="one">
                                <!-- <span class="fa fa-home"/></span> -->
                                <label for="name">Uw volledige naam</label>
                                
                                <td>
                                    <input placeholder="Uw naam" type="text" name="personen_naam" id="" required></input>
                                </td>

                            </td>

                        </tr>


                        <tr>Om uw account aan te maken, mag u hieronder uw gegevens invullen. Deze gegevens worden verwerkt in onze database.</tr>
                        <br><br>

                        <tr>
                            <td>
                                <!-- <span class="fa fa-laptop"></span> -->
                                <label for="name">Uw mailadres</label>
                                
                                <td>
                                    <input placeholder="Uw e-mail" type="email" name="mailadres" id="" required></input>
                                </td>

                            </td>

                        </tr>

                        <tr>
                            <td class="one">
                                <!-- <span class="fa fa-tag"/></span> -->
                                <label for="name">Uw wachtwoord</label>
                                
                                <td>
                                    <input placeholder="Uw wachtwoord" type="password" name="wachtwoord" id="" required></input>
                                </td>

                            </td>

                        </tr>

                        <tr>
                            <td class="one">
                                <!-- <span class="fa fa-tag"/></span> -->
                                <label for="name">Herhaal uw wachtwoord</label>
                                
                                <td>
                                    <input placeholder="Herhaal uw wachtwoord" type="password" name="wachtwoord_herhaal" id="" required></input>
                                </td>

                            </td>

                        </tr>


                        <tr>
                            <td>
                                <!-- <span class="fa fa-users"></span> -->
                                <label for="name">Uw team</label>

                                <td>
                                    <input placeholder="Uw team nummer" type="number" name="team_naam" id="" required></input>
                                </td>
                            </td>

                        </tr>

                        <tr>
                            <td>
                                <!-- <span class="fa fa-gear"></span> -->
                                <label for="name">Uw leeftijd</label>

                                <td>
                                    <input placeholder="Uw leeftijd" type="number" name="leeftijd" id="" required ></input>
                                </td>
                            </td>

                        </tr>

                        <tr>
                            <td>
                                <!-- <span class="fa fa-info-circle"></span> -->
                                <label for="name">Uw woonplaats</label>
                                
                                <td>
                                    <input placeholder="Uw woonplaats" type="text" name="woonplaats" id="" required></input>
                                </td>

                            </td>

                        </tr>

                    
                    </table>
                
                    <input class="button_center btn btn-info" type='submit' name='Submit' value='Account aanmaken' required />
                 
                    <br>

                    <?php
                        if (isset($msg)) {
                            echo $msg;
                        }
                    ?>
                </fieldset>

                
            </form>
            
            </div>
        </div>

        <?php
        }
        ?>

		</main>
	</body>
</html>
