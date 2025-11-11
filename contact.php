<?php
function returnException(Exception $exception): void {
    $response = [
        'status' => 'error',
        'message' => 'An Error Occured',
    ];
    header('Content-type: application/json; charset=utf-8');
    http_response_code($exception->getCode());
    echo json_encode($response);
}

function returnResponse(): void {
    $response = [
        'status' => 'success',
        'message' => 'Thank you for submitting the form!'
    ];
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($response);
}

error_reporting(0);
set_exception_handler('returnException');
if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'dev') {
    error_reporting(E_ALL);
    set_exception_handler(null);
}

if (securityValidation() === false) {
    throw new \Exception( "Bad Request", 400);
}

$path = realpath(dirname(__FILE__)) . '/files/submissions.json';
if (!file_exists($path)) {
    file_put_contents($path, json_encode([]));
}
$data = json_decode(file_get_contents($path), true);
if (!isset($data) || !is_array($data)) {
    throw new \Exception("Broken file", 500);
}

$formData = json_decode(file_get_contents('php://input'), true);
if (!isset($formData) || $formData === false) {
    throw new \Exception("Bad Request", 400);
}

validateFormData($formData);

$formData['date'] = date('Y-m-d');
$data[] = $formData;

if (file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT)) === false) {
    throw new Exception("Failed to write data", 500);
};

returnResponse();



function validateFormData(array &$formData): void
{
    $dangerousAsciiCodes = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 127];
    $dangerousChars = array_map( function ($charNo) { return chr($charNo);}, $dangerousAsciiCodes);

    $formData = array_intersect_key($formData, array_flip(['name', 'email', 'message']));

    $formData['name'] = filter_var(trim($formData['name']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $formData['email'] = filter_var(trim($formData['email']), FILTER_VALIDATE_EMAIL);
    $formData['message'] = str_replace($dangerousChars, '', strip_tags(trim($formData['message'])));


}

function securityValidation(): bool
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return false;
    }
    if ($_SERVER['HTTP_ORIGIN'] !== 'https://localhost') {
        return false;
    }
    if ($_SERVER['CONTENT_TYPE'] !== 'application/json; charset=utf-8') {
        return false;
    }

    return true;
}