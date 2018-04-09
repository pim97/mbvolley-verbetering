<!DOCTYPE html>
<html lang="en">
	<head>
		<title>MBVolley - Home</title>
		<!-- In te laden libraries -->
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/ rel="stylesheet" >
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<!-- deze style is nodig vanwege de fixed-top navbar -->
<style type="text/css">body { padding-top: 70px; }</style>        
		
	</head>
<body>
		
<header>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<i class="fa fa-bars fa-inverse"></i>
				</button>
				<a class="navbar-brand" href="index.php">MBV<i class="fa fa-futbol-o"></i>lley</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
				                    <li class=""><a href="about.php">Over ons</a></li>
                    <li class=""><a href="indeling_competitie.php">Indeling competitie</a></li>
                    <li class=""><a href="wedstrijdschema.php">Wedstrijdschema</a></li>
                    <li class=""><a href="uitslagen.php">Uitslagen</a></li>
                    <li class=""><a href="standen.php">Standen</a></li>
                    <li class=""><a href="contact.php">Contact</a></li>
                </ul>				<ul class="nav navbar-nav navbar-right">
										<li class="menu_item"><a href="login.php?action=login">Log in</a></li>
								</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</header>
    <main class="container">
        <div class = "panel panel-default"> 
            <div class="panel-heading">

        
                <h1> Voeg hier een nieuw team toe. </h1>
                <form action="" method= "POST">
                <table>
                <tr>
                <td><input type="text" class="form-control" name="teamname" placeholder= "Naam Team" > </input></td>
                <td>
                <select class="form-control" name="klasse">
                <option value="blanco">---</option>
                <option value="H1">HEREN 1</option>
                <option value="H2">HEREN 2</option>
                <option value="D1">DAMES 1</option>
                <option value="D2">DAMES 2</option>
                </select>
                </td>       
                </tr>
                </table>
                <button type="submit" class="btn btn-primary" style="margin-left: 70% ">Voeg toe </button>
                </form>

                <?php 
                    require_once './tools/db.php';
                    $mysqli =  get_mysqli();


                        if(isset ($_POST['teamname'])){
                             if (!empty($_POST['teamname']) || !empty($_POST['klasse']) ){ 
                                $teamname = $_POST ['teamname'];
                                $klasse = $_POST['klasse'];
                                if ($teamname == "") {
                                    echo "<h3>" . "Error!" . " Geef een teamnaam op" . "</h3>";
                                    }
                                else if ($klasse == "blanco") {
                                    echo "<h3>" . "Error!" . " Geef een klasse op" . "</h3>";
                                    }
                                else {
                                    $sql = "INSERT INTO team (id, klasse, naam) VALUES (NULL, '{$klasse}', '{$teamname}')";
                                    if ($mysqli->query($sql) === TRUE) {
                                        $msgconfirm = "<h3>" . "Het is gelukt om $teamname  toe te voegen aan $klasse " . "</h3>" ;
                                        $linkmsg = "<form action= 'indeling_competitie.php'> <input class='btn btn-primary' type='submit' value='Ga naar de indeling competitie pagina' />" . "</form>";
                                        echo $msgconfirm;
                                        echo $linkmsg;
                                        }        
                                    }
                                }
                            }
                 ?>
            </div>
        </div> 
    </main>
</body>
</html>