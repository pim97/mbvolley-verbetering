/**
 * JQuery javascript hier.
 * 
 * Hoe interpreteer je dit? Hier zorgt JQuery voor dat de gegeven function wordt uitgevoerd als de pagina is
 * geladen en klaar is voor gebruik (en javascript). $(document).ready(...). is eigenlijk zelf een function 
 * die hier aangeroepen wordt. Als parameter krijgt hij de daarin gedefinieerde functie mee (tot en met regel 84).
 * Het enige dat $(document).ready doet is ervoor zorgen dat de meegegeven functie aangeroepen wordt als dit event
 * plaatsvindt.  
 */
$(document).ready(function() {
	/*
	 * Hier weer een JQuery function die aangeroepen wordt: $("#contactform").submit(...). Die zorgt ervoor dat
	 * de als parameter meegegeven function uitgevoerd wordt als de gebruiker op de submit-knop van het formulier
	 * met ID=contactform klikt.
	 * Wanneer in het formulier op de 'submit' button wordt gedrukt zal het formulier worden gevalideerd.
	 * Bij deze validatie worden de onderstaande functies aangeroepen. Bekijk voor de werking van de functie
	 * het commentaar bij de functie zelf.
	 */
	$("#contactform").submit(function() {
		// noError krijgt de waarde true of false. Het wordt false als er ergens een validatie niet goed gaat, en blijft dan false
		var noError = validateLength($("#contactform #first_name"), 1);
		noError = noError & validateLength($("#contactform #last_name") , 1);
		noError = noError & validateLength($("#contactform #comments") , 1);
		noError = noError & validateEmail($("#contactform #email"));
		if(noError) {
			// true returnen:validatie is goed, en het formulier kan worden verstuurd naar de server
			return true;
		} else {
			return false;
		}
	});
	
	/*
	 * Het 'blur' event ontstaat wanneer een form element de focus 'verliest'. Dit houdt in dat de gebruiker
	 * een ander element op het scherm heeft geselecteerd.  
	 */
	$("#contactform #first_name").blur(function() { return validateLength($(this), 1);});
	$("#contactform #last_name" ).blur(function() { return validateLength($(this), 1);});
	$("#contactform #comments"  ).blur(function() { return validateLength($(this), 1);});
	$("#contactform #email"     ).blur(function() { return validateEmailAlsoWithAJAX($(this)    );});
	
	
	/*
	 * Wanneer in het formulier op de 'submit' button wordt gedrukt zal het formulier worden gevalideerd.
	 * Bij deze validatie worden de onderstaande functies aangeroepen. Bekijk voor de werking van de functie
	 * het commentaar bij de functie zelf.
	 */
	$("#registerform").submit(function() {
		// noError krijgt de waarde true of false. Het wordt false als er ergens een validatie niet goed gaat, en blijft dan false
		var noError = validateUsernameSynchronously($("#registerform #username"));
		noError = noError & validateLength($("#registerform #name_first")     , 1);
		noError = noError & validateLength($("#registerform #name_last")      , 1);
		noError = noError & validateLength($("#registerform #address_street") , 1);
		noError = noError & validateLength($("#registerform #address_city")   , 1);
		noError = noError & validateLength($("#registerform #address_zipcode"), 1);
		noError = noError & validateLength($("#registerform #address_country"), 1);
		noError = noError & validateLength($("#registerform #phone")          , 1);
		noError = noError & validateEmail($("#registerform #email")              );
		noError = noError & validateLength($("#registerform #password")       , 4);
		if(noError) {
			// true returnen:validatie is goed, en het formulier kan worden verstuurd naar de server
			return true;
		} else {
			return false;
		}
	});
	
	/*
	 * Het 'blur' event ontstaat wanneer een form element de focus 'verliest'. Dit houdt in dat de gebruiker
	 * een ander element op het scherm heeft geselecteerd.  
	 */
	$("#registerform #username"       ).blur(function() { return validateUsernameASynchronously($(this) );});
	$("#registerform #name_first"     ).blur(function() { return validateLength($(this), 1);});
	$("#registerform #name_last"      ).blur(function() { return validateLength($(this), 1);});
	$("#registerform #address_street" ).blur(function() { return validateLength($(this), 1);});
	$("#registerform #address_city"   ).blur(function() { return validateLength($(this), 1);});
	$("#registerform #address_zipcode").blur(function() { return validateLength($(this), 1);});
	$("#registerform #address_country").blur(function() { return validateLength($(this), 1);});
	$("#registerform #phone"          ).blur(function() { return validateLength($(this), 1);});
	$("#registerform #email"          ).blur(function() { return validateEmail($(this)    );});
	$("#registerform #password"       ).blur(function() { return validateLength($(this), 4);});

	
}); //Einde aanroep $(document).ready function... hier pas

// ========================= Hieronder de (standaard) validatie functies =========================

function validateUsernameSynchronously(field) {
	var lengthResult = validateLength(field, 3);
	
	if(lengthResult==false) {
		return false;
	}
	
	/*
	 * Haal het element op waarin het resultaat van de evaluatie komt te staan. Dit gaat ervan uit dat 
	 * het ID van dat element gelijk is aan het ID van het formulierveld (input, textarea, etc.) waarachter
	 * de tekst 'ValResult' is gezet. 
	 * 
	 * Een input met ID #test gebruikt dus een element met ID #testValResult om het resultaat weer te geven.
	 */
	var fieldID = field.attr('id');
	var fieldInfo = $("#" + fieldID + 'ValResult');
	
	// Alle opmaak weghalen
	field.removeAttr('class');
	fieldInfo.removeAttr('class');
	
	// strUrl is whatever URL you need to call
	var url = "checkusername.php?username=" + field.val();

	/*
	 * Let op! dit is niet asynchroon, maar synchroon.
	 * Dus niet AJAX, maar SJAX.
	 * Dit moet omdat we hier op het resultaat moeten wachten
	 * van het php script, omdat we het versturen van het formulier
	 * wellicht tegen moeten houden.
	 */
	var result = $.ajax({
		type: "GET",
		url: url,
		cache: false,
		async: false
    }).responseText;
	
	if (result==='true') {
		field.addClass("error");
		fieldInfo.text("Gebruikersnaam bestaat al");
		fieldInfo.addClass("error");
		return false;
	} else {
		field.addClass("success");
		fieldInfo.text("Correct");
		fieldInfo.addClass("success");
		return true;
	}
}

function validateUsernameASynchronously(field) {
	var lengthResult = validateLength(field, 3);
	
	if(lengthResult==false) {
		return false;
	}
	
	/*
	 * Haal het element op waarin het resultaat van de evaluatie komt te staan. Dit gaat ervan uit dat 
	 * het ID van dat element gelijk is aan het ID van het formulierveld (input, textarea, etc.) waarachter
	 * de tekst 'ValResult' is gezet. 
	 * 
	 * Een input met ID #test gebruikt dus een element met ID #testValResult om het resultaat weer te geven.
	 */
	var fieldID = field.attr('id');
	var fieldInfo = $("#" + fieldID + 'ValResult');
	
	// Alle opmaak weghalen
	field.removeAttr('class');
	fieldInfo.removeAttr('class');
	
	/*
	 * De JQuery AJAX aanroep naar het php script dat de username 
	 * controleert. In regel 167 begint de callback functie die wordt 
	 * uitgevoerd als een antwoord succesvol is ontvangen.
	 */
	 username = field.val();
	$.ajax({
		type    : "GET",
		url     : "checkusername.php?username=" + username,
		success : function(result) {
			          console.log(result);
  		          }
    });
	
}

function validateEmailAlsoWithAJAX(field) {
	var lengthResult = validateEmail(field);
	
	if(lengthResult==false) {
		return false;
	}
	
	/*
	 * Haal het element op waarin het resultaat van de evaluatie komt te staan. Dit gaat ervan uit dat 
	 * het ID van dat element gelijk is aan het ID van het formulierveld (input, textarea, etc.) waarachter
	 * de tekst 'ValResult' is gezet. 
	 * 
	 * Een input met ID #test gebruikt dus een element met ID #testValResult om het resultaat weer te geven.
	 */
	var fieldID = field.attr('id');
	var fieldInfo = $("#" + fieldID + 'ValResult');
	
	// Alle opmaak weghalen
	field.removeAttr('class');
	fieldInfo.removeAttr('class');
	
	/*
	 * De JQuery AJAX aanroep naar het php script dat de email 
	 * controleert. In regel 216 begint de callback functie die wordt 
	 * uitgevoerd als een antwoord succesvol is ontvangen.
	 */
	var result = $.ajax({
		type : "GET",
		url : "checkemail.php?email=" + field.val(),
		success : function(result) {
			if (result==='true') {
				field.addClass("error");
				fieldInfo.text("Email bestaat al");
				fieldInfo.addClass("error");
				return false;
			} else {
				field.addClass("success");
				fieldInfo.text("Correct");
				fieldInfo.addClass("success");
				return true;
			}
  		},
		cache : false
    }).responseText;
	
}

/**
 * Functie 'validateLength, controleert of de opgegeven waarde voldoet aan de opgegeven lengte.
 * @param field De naam van het input veld
 * @param fieldInfo De naam van de info <span>
 * @param length De minimale lengte waar de waarde aan moet voldoen
 */
function validateLength(field, length) {
	/*
	 * Haal het element op waarin het resultaat van de evaluatie komt te staan. Dit gaat ervan uit dat 
	 * het ID van dat element gelijk is aan het ID van het formulierveld (input, textarea, etc.) waarachter
	 * de tekst 'ValResult' is gezet. 
	 * 
	 * Een input met ID #test gebruikt dus een element met ID #testValResult om het resultaat weer te geven.
	 */
	var fieldID = field.attr('id');
	var fieldInfo = $("#" + fieldID + 'ValResult');
	
	// Alle opmaak weghalen
	field.removeAttr('class');
	fieldInfo.removeAttr('class');
	
	// Check of lengte kleiner is dan opgegeven lengte
	var tooSmall = field.val().length < length;
	if(tooSmall) {
		field.addClass("error");
		fieldInfo.text("Geen/te korte invoer (minimaal " + length + " tekens)");
		fieldInfo.addClass("error");
		return false;
    } else {
		field.addClass("success");
		fieldInfo.text("Correct");
		fieldInfo.addClass("success");
		return true;
    }
}

/**
 * Functie 'validateEmail, controleert of de opgegeven waarde voldoet aan de reguliere expressie
 * voor email.
 * @param field De naam van het input veld
 */
function validateEmail(field) {
	/*
	 * Haal het element op waarin het resultaat van de evaluatie komt te staan. Dit gaat ervan uit dat 
	 * het ID van dat element gelijk is aan het ID van het formulierveld (input, textarea, etc.) waarachter
	 * de tekst 'ValResult' is gezet. 
	 * 
	 * Een input met ID #test gebruikt dus een element met ID #testValResult om het resultaat weer te geven.
	 */
	var fieldID = field.attr('id');
	var fieldInfo = $("#" + fieldID + 'ValResult');
	
	field.removeAttr('class');
	fieldInfo.removeAttr('class');
	
	// Check de positie van @ en de laatste .
	var x = field.val();
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    // Check of @ en . voorkomen en dat de @ voor de . staat
    if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) {
		field.addClass("error");
		fieldInfo.text("Geen/ongeldig e-mailadres ingevoerd");
		fieldInfo.addClass("error");
		return false;
    } else {
		field.addClass("success");
		fieldInfo.text("Gevalideerd e-mailadres");
		fieldInfo.addClass("success");
		return true;
    }
}

