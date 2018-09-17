<?php

global $test;

function checkCallback()
{
    if (empty($_GET['callback'])) {
        throwError('400', 'callback not provided or empty');
    }

}

function validateInputs(array $inputs)
{
    //check for other input parameters
    $valid = true;
    $missingInputs = array();
    $valid_inputs = array();
    foreach ($inputs as $input) {
        if (!isset($_GET[$input])) {
            $valid = false;
            array_push($missingInputs, $input);
        } else {
            $valid_inputs[$input] = $_GET[$input];
        }

    }
    if (!$valid) {
        throwError('400', 'arguments not provided [' . implode(', ', $missingInputs) . ']');
    }

    return $valid_inputs;
}

function sendResponse($httpResponseCode, $data)
{
    //http_response_code($httpResponseCode);

    $description = getHttpCodeDescription($httpResponseCode);

    $response = [
        'status' => $httpResponseCode,
        'description' => $description,
        'data' => $data,
    ];
    global $__ngn_isJSONP__;
    if ($__ngn_isJSONP__) {
        echo $_GET['callback'] . '(' . json_encode($response) . ')';
    } else {
        echo json_encode($response);
    }

    die();
}

function throwError($httpResponseCode, $message)
{
    http_response_code($httpResponseCode);

    $description = getHttpCodeDescription($httpResponseCode);

    $response = [
        'status' => $httpResponseCode,
        'description' => $description,
        'message' => $message,
    ];

    global $__ngn_isJSONP__;
    if (!empty($_GET['callback']) && $__ngn_isJSONP__) {
        echo $_GET['callback'] . '(' . json_encode($response) . ')';
    } else {
        echo json_encode($response);
    }

    die();
}

function getHttpCodeDescription($httpResponseCode)
{
    $description;
    switch ($httpResponseCode) {
        case 200:
            $description = "ok";
            break;
        case 400:
            $description = "bad request";
            break;
        case 401:
            $description = "unauthorized";
            break;
        case 404:
            $description = "not found";
            break;
        case 500:
            $description = "internal server error";
            break;

        default:
            $description = "missing code description for : " . $httpResponseCode;
            break;
    }
    return $description;
}
