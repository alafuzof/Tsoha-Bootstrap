<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function() {
    HelloWorldController::login();
  });

  $routes->get('/user', function() {
    KayttajaController::index();
  });

  $routes->post('/user', function() {
    KayttajaController::store();
  });

  $routes->get('/user/new', function() {
    KayttajaController::create();
  });

  $routes->get('/user/1/edit', function() {
    HelloWorldController::user_edit();
  });

  $routes->get('/licence', function() {
    HelloWorldController::licence_list();
  });

  $routes->get('/licence/1/edit', function() {
    HelloWorldController::licence_edit();
  });

  $routes->get('/experiment', function() {
    HelloWorldController::experiment_list();
  });

  $routes->get('/experiment/1/edit', function() {
    HelloWorldController::experiment_edit();
  });
