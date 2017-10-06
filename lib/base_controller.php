<?php

  class BaseController{

    public static function get_user_logged_in(){
      // Toteuta kirjautuneen käyttäjän haku tähän
      if(isset($_SESSION['kayttaja'])) {
        $id = $_SESSION['kayttaja'];
        $kayttaja = Kayttaja::find($id);

        return $kayttaja;
      }
      return null;
    }

    public static function check_logged_in() {
      if(!isset($_SESSION['kayttaja'])) {
        Redirect::to('/login', array('error' => 'Kirjaudu sisään käyttääksesi sovellusta'));
      }
    }

    public static function check_yllapitaja() {
      if($_SESSION['oikeudet'] != 'yllapitaja') {
        Redirect::to('/', array('error' => 'Vain ylläpitäjät käyttää tuota sivua!'));
      }
    }

    public static function check_lupavastaava() {
      if($_SESSION['oikeudet'] == 'tutkija') {
        Redirect::to('/', array('error' => 'Vain lupavastaavat ja ylläpitäjät voivat käyttää tuota sivua!'));
      }
    }

  }
