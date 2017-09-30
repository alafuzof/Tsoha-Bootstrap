<?php

  class KayttajaController extends BaseController {
    public static function index() {
      BaseController::enforce_login();
      $kayttajat = Kayttaja::all();
      View::make('kayttaja/index.html', array('kayttajat' => $kayttajat));
    }

    public static function create() {
      BaseController::enforce_login();
      View::make('kayttaja/edit.html', array('otsikko' => 'Luo uusi käyttäjä',
                                             'kohde' => 'new'));
    }

    public static function store() {
      BaseController::enforce_login();

      $params = $_POST;

      $status = TRUE; //array_key_exists('status', $params); FIXME

      $kayttaja = new Kayttaja(array(
        'tunnus' => $params['tunnus'],
        'salasana' => $params['salasana'],
        'nimi' => $params['nimi'],
        'email' => $params['email'],
        'oikeudet' => $params['oikeudet'],
        'status' => $status,
        'lisayspvm' => date('Y-m-d')));
      $errors = $kayttaja->errors();

      if(count($errors) == 0) {
        $kayttaja->save();
        Redirect::to('/user', array('message' => 'Käyttäjä ' . $kayttaja->tunnus . ' on lisätty järjestelmään!'));
      } else {
        View::make('kayttaja/edit.html', array('otsikko' => 'Luo uusi käyttäjä',
                                               'kohde' => 'new',
                                               'kayttaja' => $kayttaja,
                                               'virheet' => $errors));
      }
    }

    public static function edit($id) {
      BaseController::enforce_login();

      $kayttaja = Kayttaja::find($id);
      View::make('kayttaja/edit.html', array('kayttaja' => $kayttaja,
                                             'kohde' => 'edit',
                                             'otsikko' => 'Muokkaa käyttäjän ' . $kayttaja->tunnus . ' tietoja'));
    }

    public static function update($id) {
      BaseController::enforce_login();

      $params = $_POST;

      $status = TRUE;//array_key_exists('status', $params); FIXME

      $kayttaja = new Kayttaja(array(
        'id' => $params['id'],
        'tunnus' => $params['tunnus'],
        'salasana' => $params['salasana'],
        'nimi' => $params['nimi'],
        'email' => $params['email'],
        'oikeudet' => $params['oikeudet'],
        'status' => $status,
        'lisayspvm' => date('Y-m-d'))); // Tätä ei oikeasti käytetä
      $errors = $kayttaja->errors();

      if(count($errors) == 0) {
        $kayttaja->update();
        Redirect::to('/user', array('message' => 'Käyttäjää ' . $kayttaja->tunnus . ' muokattu!'));
      } else {
        View::make('kayttaja/edit.html', array('otsikko' => 'Muokkaa käyttäjän ' . $kayttaja->tunnus . ' tietoja',
                                               'kohde' => 'edit',
                                               'kayttaja' => $kayttaja,
                                               'virheet' => $errors));
      }
    }

    public static function destroy($id) {
      BaseController::enforce_login();

      $kayttaja = Kayttaja::find($id);
      $kayttaja->destroy();

      Redirect::to('/user', array('message' => 'Kayttaja ' . $kayttaja->tunnus . ' on poistettu järjestelmästä!'));
    }

    public static function login() {
      View::make('/kayttaja/login.html');
    }

    public static function handle_login() {
      $params = $_POST;

      $kayttaja = Kayttaja::authenticate($params['tunnus'], $params['salasana']);

      if(!$kayttaja) {
        View::make('/kayttaja/login.html', array('virhe' => 'Väärä käyttäjätunnus tai salasana!'));
      } else {
        $_SESSION['kayttaja'] = $kayttaja->id;

        Redirect::to('/', array('viesti' => 'Tervetuloa takaisin ' . $kayttaja->nimi . '!'));
      }
    }

    public static function handle_logout() {
      unset($_SESSION['kayttaja']);

      Redirect::to('/', array('viesti' => 'Olet kirjaunut ulos!'));
    }

  }
