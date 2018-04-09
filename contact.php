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
			<?php
			// Externe scripts includen
			include_once('tools/formvalidationtools.php');

			// Controleer of form wordt opgevraagd of ingestuurd
		    if (isset($_POST['send'])) {
		    	// Form ingestuurd: Verwerken maar
				
			    // Als eerste stap controleren en valideren we alle data uit het form
			    if(!isset($_POST['first_name']) ||
			        !isset($_POST['last_name']) ||
			        !isset($_POST['email']) ||
			        !isset($_POST['telephone']) ||
			        !isset($_POST['comments']) ||
			        !isset($_POST['captcha_code'])) {
			        printErrorAndDie('Het lijkt er op dat het formulier dat u gebruikt niet klopt.');       
			    }
					 
			    $name_first = $_POST['first_name']; // required
			    $name_last = $_POST['last_name']; // required
			    $email = $_POST['email']; // required
			    $phone = $_POST['telephone']; // not required
			    $comments = $_POST['comments']; // required
			    $captchacode = $_POST['captcha_code']; // required
				
			    // error_message wordt gevuld als er foutberichten zijn
			    $error_message = "";
				$error_message .= validateCharacters($name_first, 'De voornaam is niet valide.');
				$error_message .= validateCharacters($name_last, 'De achternaam is niet valide.');
				$error_message .= validateLength($phone, 1, 'Het telefoonnummer is niet ingevuld.');
				$error_message .= validateEmail($email, 'Het email adres is niet valide');
				$error_message .= validateLength($comments, 10, 'Het bericht is te kort');
				$error_message .= validateCaptcha($captchacode, 'De Captcha code was niet correct.');

				// Er is iets mis als de lengte van error_message > 0
				if(strlen($error_message) > 0) {
				    printErrorAndDie($error_message);
				}

				function clean_string($string) {
					// Beveilig content tegen SMTP injection
					$bad = array("content-type","bcc:","to:","cc:","href");
					return str_replace($bad,"",$string);
				}
			     
			    $email_to = "daan.de.waard@hz.nl";
			    $email_subject = "website html form submissions";
								
				$email_message = "Form details below.\n\n";
				     
				$email_message .= "First Name: ".clean_string($name_first)."\n";
				$email_message .= "Last Name: ".clean_string($name_last)."\n";
				$email_message .= "Email: ".clean_string($email)."\n";
				$email_message .= "Telephone: ".clean_string($phone)."\n";
				$email_message .= "Comments: ".clean_string($comments)."\n";
				          
				// create email headers
				$headers = 'From: '.$email."\r\n".
				'Reply-To: '.$email."\r\n" .
				'X-Mailer: PHP/' . phpversion();
				@mail($email_to, $email_subject, $email_message, $headers); 
				
				echo '<p>Dank u voor het bericht. Wij nemen binnenkort contact met u op.</p>';
				
		    } else {
		    	// Het form laten zien...
		    	?>
		    	<form  class="form-horizontal" action="" method="POST" role="form">
		    		<div class="panel panel-default">
		    			<div class="panel-body">
				    		<legend>Contact</legend>
						    <p>Vul dit formulier in om een bericht te sturen:</p>
				    		<div class="form-group">
				    			<label class="col-sm-2 control-label" for="">Voornaam *</label>
				    			<div class="col-sm-10">
				    				<input type="text" name="first_name" class="form-control" placeholder="Voornaam">
				    			</div>
				    		</div>
				    		<div class="form-group">
				    			<label class="col-sm-2 control-label" for="">Achternaam *</label>
				    			<div class="col-sm-10">
				    				<input type="text" name="last_name" class="form-control" placeholder="Achternaam">
				    			</div>
				    		</div>
				    		<div class="form-group">
				    			<label class="col-sm-2 control-label" for="">Email adres *</label>
				    			<div class="col-sm-10">
				    				<input type="text" name="email" class="form-control" placeholder="Email adres">
				    			</div>
				    		</div>
				    		<div class="form-group">
				    			<label class="col-sm-2 control-label" for="">Telefoonnummer</label>
				    			<div class="col-sm-10">
				    				<input type="text" name="telephone" class="form-control" placeholder="Telefoonnummer">
				    			</div>
				    		</div>
				    		<div class="form-group">
				    			<label class="col-sm-2 control-label" for="">Bericht *</label>
				    			<div class="col-sm-10">
				    				<textarea  class="form-control" name="comments" maxlength="1000" rows="10"></textarea>
				    			</div>
				    		</div>
		    			</div>
		    			<div class="panel-footer">
				    		<button type="submit" class="btn btn-primary">Submit</button>
		    			</div>
		    		</div>
	    	</form>
<?php
		    } // sluit de if ?>
		</main>
		
		<!-- scripts laden we op het laatst -->
		<script src="lib/jquery/jquery.min.js"></script>
		<script src="js/validate.js"></script>
	</body>
</html>
