<?php

// all requests are redirected to this file.
// use your .htaccess file to set this up.

error_reporting(-1);
require_once __DIR__ . '/vendor/autoload.php';

$klein = new Klein\Klein;

// First, let's setup the layout our site will use. By passing 
// an anonymous function in Klein will respond to all methods/URI's.
$klein->respond(function ($request, $response, $service) {
    $service->layout('layouts/default.php');
});

// Home page view
$klein->respond('/', function ($request, $response, $service) {
    // add some data to the view.
    $service->pageTitle = 'Página Principal';

    // This is the function that renders the view inside the layout.
    $service->render('views/home.php');
});

// Home page view
$klein->respond('/login', function ($request, $response, $service) {
    $service->pageTitle = 'Log in';
    $service->render('views/login.php');
});

$klein->respond('/registrarse', function ($request, $response, $service) {
    $service->pageTitle = 'Registro';
    $service->render('views/registro.php');
});

$klein->respond('/objetivos', function ($request, $response, $service) {
    $service->pageTitle = 'Objetivos';
    $service->render('views/objetivos.php');
});

$klein->respond('/e_r', function ($request, $response, $service) {
    $service->pageTitle = 'Entidad Relación';
    $service->render('views/e_r.php');
});

$klein->respond('/arquitectura', function ($request, $response, $service) {
    $service->pageTitle = 'Arquitectura';
    $service->render('views/arquitectura.php');
});

$klein->respond('/esquemas', function ($request, $response, $service) {
    $service->pageTitle = 'Esquemas';
    $service->render('views/esquemas.php');
});

$klein->respond('/arduino', function ($request, $response, $service) {
    $service->pageTitle = 'Arduino';
    $service->render('views/arduino.php');
});

$klein->respond('/ethernet', function ($request, $response, $service) {
    $service->pageTitle = 'Ethernet';
    $service->render('views/ethernet.php');
});

$klein->respond('/sensores', function ($request, $response, $service) {
    $service->pageTitle = 'Sensores';
    $service->render('views/sensores.php');
});

$klein->respond('/tablas_registros', function ($request, $response, $service) {
    $service->pageTitle = 'Tablas Registros';
    $service->render('views/tablas_registros.php');
});

$klein->respond('/graficas', function ($request, $response, $service) {
    $service->pageTitle = 'Gráficas';
    $service->render('views/graficas.php');
});

$klein->dispatch();