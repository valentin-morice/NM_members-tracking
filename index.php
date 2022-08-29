<?php
session_start();

require 'bootstrap.php';

$klein->respond('GET', '/', function ($request, $response, $service) {
   $service->render('views/main.php');
});

$klein->respond('POST', '/members/card', function ($request, $response, $service) {
   $_SESSION['member_id'] = $request->paramsPost("data");
   $service->render('views/tcpdf.php');
});

$klein->respond('GET', '/members/[i:id]', function ($request, $response, $service) {
   $service->render('views/profile.php', array(
      'id' => $request->id, 
   ));
});

$klein->dispatch();