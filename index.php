<?php

/**
 * Fake store API
 * Maja Thunberg
 */

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");

include('Products.php');
include('productData.php');

echo json_encode($names, JSON_UNESCAPED_UNICODE);