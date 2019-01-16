<?php
// Include the bundled autoload from the Twilio PHP Helper Library
require __DIR__ . '/twilio-php-master/Twilio/autoload.php';
use Twilio\Rest\Client;
// Your Account SID and Auth Token from twilio.com/console

// if($_POST['tel']){


    $nbrPhone = '+212658744775 ';       
    $six_digit_random_number = mt_rand(10000, 99999);

	// Your Account SID and Auth Token from twilio.com/console
	$account_sid = 'AC4a98ee0b371694bfcde05ea7470bebd7';
	$auth_token = 'f040e986a25d9ec78f1bd791dcfe265e';
	// In production, these should be environment variables. E.g.:
	// $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]
	// A Twilio number you own with SMS capabilities
	$twilio_number = "+12244343641";
	$client = new Client($account_sid, $auth_token);
	$client->messages->create(
	    // Where to send a text message (your cell phone?)
        $nbrPhone,
	    array(
	        'from' => $twilio_number,
            'body' => 'Your code verification  '.$six_digit_random_number
	    )
	);

echo  $six_digit_random_number;
// }



