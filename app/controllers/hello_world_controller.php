<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  //View::make('home.html');
      self::check_logged_in();
      View::make('home.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      $user = new Kayttaja(array('tunnus' => '',
                             'salasana' => '1234567891011121314151617181920',
                             'nimi' => null,
                             'email' => 'abcdef',
                             'oikeudet' => 'mitä sattuu',
                             'status' => 'vihreä',
                             'lisayspvm' => 'joulupäivä'));
      $errors = $user->errors();
      Kint::dump($errors);

      $user = new Kayttaja(array('tunnus' => 'rane',
                             'salasana' => '1234567891011',
                             'nimi' => 'Rane',
                             'email' => 'a@b.com',
                             'oikeudet' => 'tutkija',
                             'status' => '1',
                             'lisayspvm' => '2017-09-09'));
      $errors = $user->errors();
      Kint::dump($errors);

      //View::make('helloworld.html');
      $yllapitaja = Kayttaja::find(1);
      $kayttajat = Kayttaja::all();

      $lupa = Elainkoelupa::find(1);
      $luvat = Elainkoelupa::all();

      $koe = Elainkoe::find(1);
      $kokeet = Elainkoe::all();

      // Kint-luokan dump-metodi tulostaa muuttujan arvon
      Kint::dump($yllapitaja);
      Kint::dump($kayttajat);

      Kint::dump($lupa);
      Kint::dump($luvat);

      Kint::dump($koe);
      Kint::dump($kokeet);

    }

    public static function login(){
      View::make('suunnitelmat/login.html');
    }

    public static function user_list(){
      View::make('suunnitelmat/user_list.html');
    }

    public static function user_edit(){
      View::make('suunnitelmat/user_edit.html');
    }

    public static function licence_list(){
      View::make('suunnitelmat/licence_list.html');
    }

    public static function licence_edit(){
      View::make('suunnitelmat/licence_edit.html');
    }

    public static function experiment_list(){
      View::make('suunnitelmat/experiment_list.html');
    }

    public static function experiment_edit(){
      View::make('suunnitelmat/experiment_edit.html');
    }
  }
