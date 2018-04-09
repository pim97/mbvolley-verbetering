<?php
	
session_start();
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
			<div class="well"><h1>Over de gebruikte techniek</h1></div>
			<p>Deze site gebruik een paar hippe technieken, waar ik wat over wil vertellen
				<ul class="fa-ul">
					<li><i class="fa fa-li fa-external-link"></i><a href="http://getbootstrap.com/" target="_blank">Bootstrap 3.3.1</a></li>
					<li><i class="fa fa-li fa-external-link"></i><a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">Font Awesome 4.2.0</a></li>
				</ul>
			</p>
			<p>Alle libraries worden niet met de site meegeleverd, maar worden extern geladen vanaf een Content Delivery Network (CDN).</p>
			<h2>Bootstrap</h2>
			<p>Dit is een library die het eenvoudig maakt om jouw site een gelikt uiterlijk te geven. Sites gemaakt met Bootstrap
				zijn heel herkenbaar. Één van de belangrijkste voordelen van Bootstrap is dat, als je de library goed weet toe te passen, de
				site <i>responsive</i> wordt, wat betekent dat hij zichzelf zo kan omvormen dat hij op smartphones en tablets goed is te lezen.
				De site bevat, naast de <i>Getting started</i> een aantal belangrijke pagina's:
				<ul class="fa-ul">
					<li><i class="fa fa-li fa-anchor"></i>Components: een overzicht, met codevoorbeelden van alle componenten (navbars, panels, tables, etc.)</li>
					<li><i class="fa fa-li fa-anchor"></i>CSS: een overzicht</li>
					<li><i class="fa fa-li fa-anchor"></i>Javascript: een overzicht van de mogelijkheden</li>
				</ul>
			</p>
			<p>De codevoorbeelden zijn knip en plak klaar voor je. Wat ik vaak doe is een codevoorbeeld overnemen in mijn pagina, en test ik 
				hem om de uitwerking te zien. Vervolgens ga ik hem aanpassen zodat het precies de juiste inhoud gaat weergeven of precies het
				goede gaat doen.
			</p>
			<p>Een goed voorbeeld is de homepagina, waarin ik alleen de inhoud heb gevat in een <code>&lt;div&gt;</code> element met als klasse
				Jumbotron:</p>
			<pre>
	&lt;div class="jumbotron"&gt;	
		&lt;h1&gt;Welkom&lt;/h1&gt;
		&lt;p&gt;Lorem ipsum ...
		&lt;/p&gt;
	&lt;/div&gt;	
			</pre>
			<h2>Font-awesome</h2>
			<p>Font awesome is niets anders dan een verzameling icoontjes, zoals <i class="fa fa-beer"></i> 
				(code: <code>&lt;i class="fa fa-beer"&gt;&lt;/i&gt;</code>, die je eenvoudig in je site kunt opnemen.
				Bovendien, biedt het ook wat extra's, wat je meestal terugvind als CSS klassen waarvan de naam begint met 'fa''. Deze
				icons zijn prima te combineren met Bootstrap
			</p>
			<p>Interessante pagina's van de site zijn hiervan:
				<ul class="fa-ul">
					<li><i class="fa fa-li fa-anchor"></i>Examples: een overzicht van de mogelijkheden van font-awesome</li>
					<li><i class="fa fa-li fa-anchor"></i>Icons: een overzicht, per categorie van alle 479 icons</li>
				</ul>	
			</p>
			<p>Deze library gebruik ik meestal door, wanneer ik een icon nodig denk te hebben, te zoeken in de icons pagina. Als ik er één
				gevonden heb, klik ik daarop, en verschijnt er een pagina waar kant-en-klare code staat die je kunt kopiëren en plakken
				in je site.
			</p>
			<br/>
			<br/>				
		</main>
	</body>
</html>
