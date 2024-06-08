<?php

require __DIR__ . '/../vendor/autoload.php';

// Load the environment variables from the .env file
(Dotenv\Dotenv::createImmutable(__DIR__ . '/../'))->load();

// Create the application
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Handle the request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
