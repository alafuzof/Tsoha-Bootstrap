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

    public static function check_logged_in(){
      // Toteuta kirjautumisen tarkistus tähän.
      // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

    public static function enforce_login() {
      if(!isset($_SESSION['kayttaja'])) {
        Redirect::to('/login');
      }
    }

  }
