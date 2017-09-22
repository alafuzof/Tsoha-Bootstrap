<?php

  class KayttajaController extends BaseController {
    public static function index() {
      $kayttajat = Kayttaja::all();

      View::make('kayttaja/index.html', array('kayttajat' => $kayttajat));
    }

    public static function create() {
      View::make('kayttaja/new.html');
    }

    public static function store() {
      $params = $_POST;

      $kayttaja = new Kayttaja(array(
        'tunnus' => $params['tunnus'],
        'salasana' => $params['salasana'],
        'nimi' => $params['nimi'],
        'email' => $params['email'],
        'oikeudet' => $params['oikeudet'],
        'status' => $params['status']));

      $kayttaja->save();

      Redirect::to('/user', array('message' => 'Kayttaja ' . $kayttaja->tunnus . ' on lisätty järjestelmään!'));
    }
  }
