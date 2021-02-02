<?php
$recaptcha_secret = 'CLAVE_SECRETA'; 
$recaptcha_response = $_POST['recaptcha_response']; 
$url = 'https://www.google.com/recaptcha/api/siteverify'; 

$data = array( 'secret' => $recaptcha_secret, 'response' => $recaptcha_response, 'remoteip' => $_SERVER['REMOTE_ADDR'] ); 
$curlConfig = array( CURLOPT_URL => $url, CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_POSTFIELDS => $data ); 
$ch = curl_init(); 
curl_setopt_array($ch, $curlConfig); 
$response = curl_exec($ch); 
curl_close($ch);

//https://www.esthersola.com/google-recaptcha-v3-y-php-opciones-y-problemas/

$jsonResponse = json_decode($response);
if ($jsonResponse->success === true) { 

	$name = strip_tags(htmlspecialchars($_POST['name']));
	$email = strip_tags(htmlspecialchars($_POST['email']));
	$phone = strip_tags(htmlspecialchars($_POST['phone']));
	$message = strip_tags(htmlspecialchars($_POST['message']));

	// Create the email and send the message
	$to = "contacto@metalurgicamilloch.com"; 
	$subject = "Página Web Metalurgica Milloch:  $name";
	$body = "Recibiste un mensaje de la página web.\n\n"."Los detalles son:\n\nNombre: $name\n\nEmail: $email\n\nTelefono: $phone\n\nMensaje:\n$message";
	$header = "From: noreply@metalurgicamilloch.com\n"; 
	$header .= "Reply-To: $email";	

	if(!mail($to, $subject, $body, $header)){
		http_response_code(500);
	}

} else {
	http_response_code(500);
}
?>

