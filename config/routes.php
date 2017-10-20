<?php

  // Oletusreitit
  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });


  // Käyttäjäsivut
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

  $routes->get('/user/:id', function($id) {
    KayttajaController::show($id);
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

  $routes->get('/user/:id/toggle', function($id) {
    KayttajaController::toggle_status($id);
  });


  // Lupasivut
  $routes->get('/licence', function() {
    ElainkoelupaController::index();
  });

  $routes->get('/licence/new', function() {
    ElainkoelupaController::create();
  });
  $routes->post('/licence/new', function() {
    ElainkoelupaController::store();
  });

  $routes->get('/licence/:id', function($id) {
    ElainkoelupaController::show($id);
  });

  $routes->get('/licence/:id/edit', function($id) {
    ElainkoelupaController::edit($id);
  });
  $routes->post('/licence/:id/edit', function($id) {
    ElainkoelupaController::update($id);
  });

  $routes->get('/licence/:id/delete', function($id) {
    ElainkoelupaController::destroy($id);
  });



  // Koesivut
  $routes->get('/experiment', function() {
    ElainkoeController::index();
  });

  $routes->get('/experiment/new', function() {
    ElainkoeController::create();
  });
  $routes->post('/experiment/new', function() {
    ElainkoeController::store();
  });

  $routes->get('/experiment/:id', function($id) {
    ElainkoeController::show($id);
  });

  $routes->get('/experiment/:id/edit', function($id) {
    ElainkoeController::edit($id);
  });
  $routes->post('/experiment/:id/edit', function($id) {
    ElainkoeController::update($id);
  });

  $routes->get('/experiment/:id/delete', function($id) {
    ElainkoeController::destroy($id);
  });
