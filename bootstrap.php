<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/config.php';

// Set Router
$klein = new \Klein\Klein();

// Call GiveWP API, All Members 
$api_url_members = "http://donations.newmayapur.com/give-api/subscriptions/?key=" . $key . "&token=" . $token . "&number=-1";
$json_data_m = file_get_contents($api_url_members);
$response_data_m = json_decode($json_data_m, true);

// Store in Session
$_SESSION['members'] = $response_data_m['subscriptions'];

