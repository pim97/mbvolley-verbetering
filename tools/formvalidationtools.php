<?php
/**
 * Dit script is verantwoordelijk voor het leveren van functionaliteit voor het
 * valideren van allerlei (user)input. Hiermee kunnen opgestuurde forms gemakkelijk
 * worden gecontroleerd.
 * 
 * Alle functies leveren een foutbericht-tekst als de opgegeven tekst niet valideert.
 * Als de tekst wel valideert, retourneert de functie een lege String.
 */

 	/**
	 * Valideert een tekst op lengte.
	 * @param $text de te valideren tekst
	 * @param $minSize de minimaal vereiste lengte van de tekst
	 * @param $errorMsg het foutbericht dat geretourneerd wordt
	 * 
	 * @return het foutbericht als de lengte van de tekst kleiner is dan het minimum. 
	 * 			Anders een lege string.
	 */
    function validateLength($text, $minSize, $errorMsg) {
    	$result = "";
    	if(strlen($text) < $minSize) {
    		$result = $errorMsg . "<br/>";
    	}
		return $result;
    }

	/**
	 * Valideert een tekst op aanwezigheid van letters (a-z).
	 * @param $text de te valideren tekst
	 * @param $errorMsg het foutbericht dat geretourneerd wordt
	 * 
	 * @return het foutbericht als de tekst geen letters bevat. 
	 * 			Anders een lege string.
	 */
    function validateCharacters($text, $errorMsg) {
		$regex_pattern = "/^[A-Za-z .'-]+$/";
		return validateRegex($regex_pattern, $text, $errorMsg);
    }

	/**
	 * Valideert een tekst op aanwezigheid van letters (a-z).
	 * @param $text de te valideren tekst
	 * @param $errorMsg het foutbericht dat geretourneerd wordt
	 * 
	 * @return het foutbericht als de tekst geen letters bevat. 
	 * 			Anders een lege string.
	 */
    function validateEmail($text, $errorMsg) {
		$regex_pattern = "/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/";
		return validateRegex($regex_pattern, $text, $errorMsg);
    }

	/**
	 * Valideert een tekst met behulp van een reguliere expressie (regex)
	 * @param $regex_pattern het regex patroon waaraan de tekst moet voldoen
	 * @param $text de te valideren tekst
	 * @param $errorMsg het foutbericht dat geretourneerd wordt
	 * 
	 * @return het foutbericht als de tekst niet voldoet aan het regex patroon. 
	 * 			Anders een lege string.
	 */
    function validateRegex($regex_pattern, $text, $errorMsg) {
    	$result = "";
		$string_exp = "/^[A-Za-z .'-]+$/";
    	if(!preg_match($regex_pattern, $text)) {
    		$result = $errorMsg . "<br/>";
    	}
		return $result;
    }


	function validateCaptcha($captchacode, $errorMsg) {
    	$result = "";
		include_once 'lib/securimage/securimage.php';
		$securimage = new Securimage();
		if ($securimage->check($captchacode) == false) {
			// the code was incorrect
			$result = $errorMsg . "<br />";
		}
		return $result;
		
	}
	
	/**
	 * Print een foutbericht en stopt het script.
	 * @param $error het foutbericht wat in de melding moet worden opgenomen.
	 */
    function printErrorAndDie($error) {
        // print een standaard boodschap
        echo '<div class="error">';
        echo "Het spijt ons, maar niet alles in het formulier is goed ingevuld. ";
        echo "Het gaat om de volgende fouten:<br /><br />";
        echo $error."<br /><br />";
        echo "U kunt <a href='javascript:history.go(-1)'>teruggaan</a> om uw formulier te verbeteren.<br /><br />";
        die();
    }
						


?>