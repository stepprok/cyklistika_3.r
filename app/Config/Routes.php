<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('zavod/(:num)', 'Home::detail/$1');
$routes->get('result/stage/(:num)/(:num)', 'Home::stageResult/$1/$2');
$routes->get('race-year/create', 'Home::createRaceYear');
$routes->post('race-year/store', 'Home::storeRaceYear');
