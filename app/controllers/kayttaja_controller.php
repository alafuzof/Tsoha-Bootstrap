<?php

  class KayttajaController extends BaseController {
    public static function index() {
      $kayttajat = Kayttaja::all();
      View::make('kayttaja/index.html', array('kayttajat' => $kayttajat));
    }

    public static function create() {
      View::make('kayttaja/edit.html', array('otsikko' => 'Luo uusi käyttäjä',
                                             'kohde' => 'new'));
    }

    public static function store() {
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
      $kayttaja = Kayttaja::find($id);
      View::make('kayttaja/edit.html', array('kayttaja' => $kayttaja,
                                             'kohde' => 'edit',
                                             'otsikko' => 'Muokkaa käyttäjän ' . $kayttaja->tunnus . ' tietoja'));
    }

    public static function update($id) {
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

  }
