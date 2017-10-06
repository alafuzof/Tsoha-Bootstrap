<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function() {
    KayttajaController::login();
  });

  $routes->post('/login', function() {
    KayttajaController::handle_login();
  });

  $routes->get('/logout', function() {
    KayttajaController::handle_logout();
  });

  $routes->get('/user', function() {
    KayttajaController::index();
  });

  $routes->get('/user/new', function() {
    KayttajaController::create();
  });

  $routes->post('/user/new', function() {
    KayttajaController::store();
  });

  $routes->get('/user/:id/edit', function($id) {
    KayttajaController::edit($id);
  });

  $routes->post('/user/:id/edit', function($id) {
    KayttajaController::update($id);
  });

  $routes->get('/user/:id/delete', function($id) {
    KayttajaController::destroy($id);
  });

  $routes->get('/user/:id', function($id) {
    KayttajaController::show($id);
  });

  $routes->get('/licence', function() {
    ElainkoelupaController::index();
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
