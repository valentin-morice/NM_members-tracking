<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/config.php';

// Set Router
$klein = new \Klein\Klein();

// Call GiveWP API
$api_url = "http://donations.newmayapur.com/give-api/subscriptions/?key=" . $key . "&token=" . $token . "&number=-1";
$json_data = file_get_contents($api_url);
$response_data = json_decode($json_data, true);

// Store in Session
$_SESSION['members'] = $response_data['subscriptions'];

