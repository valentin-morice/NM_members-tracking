<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/config.php';

// Set Router
$klein = new \Klein\Klein();

// Call GiveWP API, All Members 
$api_url_members = "http://donations.newmayapur.com/give-api/subscriptions/?key=" . $key . "&token=" . $token . "&number=-1";
$json_data_m = file_get_contents($api_url_members);
$response_data_m = json_decode($json_data_m, true);

// Call GiveWP API, Donations From Last Month
$startdate = date('Ymd', strtotime("-1 months"));
$api_url_donations = "http://donations.newmayapur.com/give-api/donations/?key=" . $key . "&token=" . $token . "&startdate=" . $startdate;
$json_data_d = file_get_contents($api_url_donations);
$response_data_d = json_decode($json_data_d, true);

// Store in Session
$_SESSION['members'] = $response_data_m['subscriptions'];
$_SESSION['donations'] = $response_data_d['donations'];

