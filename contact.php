<?php


header('Content-Type: application/json');


$path = realpath(dirname(__FILE__)).'/files/submissions.json';
if (!file_exists($path)) {
    file_put_contents($path, json_encode([]));
}

$data = json_decode(file_get_contents($path),true);
$formData = json_decode(file_get_contents('php://input'),true);
$formData['date'] = date('Y-m-d');
$data[] = $formData;
file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));

$response = ['status' => 'success', 'message' => 'Thank you for submitting the form!'];
echo json_encode($response);