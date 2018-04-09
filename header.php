<?php

	
    // Trucje om de huidige pagina te bepalen
    // Met de huidige pagina bedoel ik de naam van het (php) bestand dat op dit moment wordt 'uitgevoerd'
    // de functie basename haalt de naam van het bestand uit een pad met eventuele subfolders
	$page = basename($_SERVER["PHP_SELF"]);

	// Definieer het menu in een array (elk menu item is ook weer een array)
    $menu_items = array(
		
		array(
			"Name"=>"Indeling competitie",
			"URL"=>"indeling_competitie.php"
		),
		array(
			"Name"=>"Wedstrijdschema",
			"URL"=>"wedstrijdschema.php"
		),
		array(
			"Name"=>"Uitslagen",
			"URL"=>"uitslagen.php"
		),
		array(
			"Name"=>"Standen",
			"URL"=>"standen.php"
		),
		array(
			"Name"=>"Maak account",
			"URL"=>"create.php"
		),	
		array(
			"Name"=>"Genereer",
			"URL"=>"wedstrijden_generen.php"
		),	
	);

	
	


?>

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
				<?php
					// Render het menu uit de $menu_items array met een for-each loop
					foreach ($menu_items as $menu_item) {
						// Bepaal de (CSS) class van dit item
						$class = "";
						if ($menu_item["URL"]===$page) 
							$class ="active";
						echo '                    ';    // wat spaties voor de netheid
						echo '<li class="'.$class.'">'; // li element
						echo '<a href="'.$menu_item['URL'].'">'.$menu_item['Name'].'</a>'; // a-element
						echo"</li>\n";
					}
					echo"                </ul>";	
				?>
				<ul class="nav navbar-nav navbar-right">
					<?php  
					if (isset($_SESSION['logged_in'])) {
						$username = 'onbekend';
						if(isset($_SESSION['login_naam'])) {
							$username = $_SESSION['login_naam'];
						} ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<i class="fa fa-user"></i>&nbsp;<?php echo $username ?>&nbsp;<i class="fa fa-caret-down"></i>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li class="menu_item"><a href="create.php?action=logoff"><i class="fa fa-power-off"></i> Afmelden</a></li>
								<?php
								 echo '<li class="menu_item"><a href="lid.php?lidid='. $_SESSION['id'] . '"><i class="fa fa-user"></i> Profiel</a></li>'; 
								 ?>
							</ul>
						</li>
				<?php } // if isset($_SESSION['loggedin']
				else { ?>
					<li class="menu_item"><a href="create.php">Login</a></li>
				<?php } // else ?>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</header>
