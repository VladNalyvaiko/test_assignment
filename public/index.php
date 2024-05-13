<?php
/**
 *  Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/** 
 * Start session
 */
session_start();

use Core\Router;

Router::get('/', 'Home@index');
Router::get('/login', 'Login@index');
Router::post('/login', 'Login@create');
Router::get('/signup', 'Signup@index');
Router::post('/signup', 'Signup@create');
Router::get('/logout', 'Logout@destroy');
Router::get('/transportType', 'TransportType@index');
Router::delete('/transportType/delete', 'TransportType@delete');
Router::get('/transportType/create', 'TransportType@createPage');
Router::post('/transportType/create', 'TransportType@create');
Router::get('/transportType/update/([0-9]*)', 'TransportType@updatePage');
Router::post('/transportType/update', 'TransportType@update');
Router::get('/transportType/([0-9]*)', 'TransportType@show');


