<?php

  class KayttajaController extends BaseController {
    public static function index() {
      self::check_logged_in();
      self::check_yllapitaja();
      $kayttajat = Kayttaja::all();
      View::make('kayttaja/index.html', array('kayttajat' => $kayttajat));
    }

    public static function create() {
      self::check_logged_in();
      self::check_yllapitaja();
      View::make('kayttaja/edit.html', array('otsikko' => 'Luo uusi käyttäjä',
                                             'kohde' => 'new'));
    }

    public static function store() {
      self::check_logged_in();
      self::check_yllapitaja();

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

      if(Kayttaja::find_by_tunnus($kayttaja->tunnus) != NULL) {
        $errors[] = 'Tunnus ' . $kayttaja->tunnus . ' on jo käytössä!';
      }

      if(count($errors) == 0) {
        $kayttaja->save();
        Redirect::to('/user', array('success' => 'Käyttäjä ' . $kayttaja->tunnus . ' on lisätty järjestelmään!'));
      } else {
        View::make('kayttaja/edit.html', array('otsikko' => 'Luo uusi käyttäjä',
                                               'kohde' => 'new',
                                               'kayttaja' => $kayttaja,
                                               'virheet' => $errors));
      }
    }

    public static function show($id) {
      self::check_logged_in();

      $kayttaja = Kayttaja::find($id);
      $luvat = Elainkoelupa::find_by_kayttaja($kayttaja);
      $kokeet = Elainkoe::find_by_kayttaja($kayttaja);
      View::make('kayttaja/show.html', array('kayttaja' => $kayttaja,
                                             'luvat' => $luvat,
                                             'kokeet' => $kokeet));
    }

    public static function edit($id) {
      self::check_logged_in();
      self::check_yllapitaja();

      $kayttaja = Kayttaja::find($id);
      View::make('kayttaja/edit.html', array('kayttaja' => $kayttaja,
                                             'kohde' => 'edit',
                                             'otsikko' => 'Muokkaa käyttäjän ' . $kayttaja->tunnus . ' tietoja'));
    }

    public static function update($id) {
      self::check_logged_in();
      self::check_yllapitaja();

      $params = $_POST;

      if(array_key_exists('status', $params)) {
        $params['status'] = 'true';
      } else {
        $params['status'] = 'false';
      }

      $kayttaja = new Kayttaja(array(
        'id' => $params['id'],
        'tunnus' => $params['tunnus'],
        'salasana' => $params['salasana'],
        'nimi' => $params['nimi'],
        'email' => $params['email'],
        'oikeudet' => $params['oikeudet'],
        'status' => $params['status'],
        'lisayspvm' => date('Y-m-d'))); // Tätä ei oikeasti käytetä
      $errors = $kayttaja->errors();

      $tmp = Kayttaja::find_by_tunnus($kayttaja->tunnus);
      if($tmp != NULL && $kayttaja->id != $tmp->id) {
        $errors[] = 'Tunnus ' . $kayttaja->tunnus . ' on jo käytössä!';
      }

      if(count($errors) == 0) {
        $kayttaja->update();
        Redirect::to('/user', array('success' => 'Käyttäjää ' . $kayttaja->tunnus . ' muokattu!'));
      } else {
        View::make('kayttaja/edit.html', array('otsikko' => 'Muokkaa käyttäjän ' . $kayttaja->tunnus . ' tietoja',
                                               'kohde' => 'edit',
                                               'kayttaja' => $kayttaja,
                                               'virheet' => $errors));
      }
    }

    public static function toggle_status($id) {
      self::check_logged_in();
      self::check_yllapitaja();

      $kayttaja = Kayttaja::find($id);
      $kayttaja->toggle_status();

      Redirect::to('/user', array('success' => 'Kayttajan ' . $kayttaja->tunnus . ' status muutettu!'));
    }

    public static function destroy($id) {
      self::check_logged_in();
      self::check_yllapitaja();

      $kayttaja = Kayttaja::find($id);
      $kayttaja->destroy();

      Redirect::to('/user', array('success' => 'Kayttaja ' . $kayttaja->tunnus . ' on poistettu järjestelmästä!'));
    }

    public static function login() {
      View::make('/kayttaja/login.html');
    }

    public static function handle_login() {
      $params = $_POST;

      $kayttaja = Kayttaja::authenticate($params['tunnus'], $params['salasana']);

      if($kayttaja == NULL || $kayttaja->status == FALSE) {
        View::make('/kayttaja/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!'));
      } else {
        $_SESSION['kayttaja'] = $kayttaja->id;
        $_SESSION['oikeudet'] = $kayttaja->oikeudet;

        Redirect::to('/', array('success' => 'Tervetuloa takaisin ' . $kayttaja->nimi . '!'));
      }
    }

    public static function handle_logout() {
      unset($_SESSION['kayttaja']);
      unset($_SESSION['oikeudet']);

      Redirect::to('/login', array('success' => 'Olet kirjaunut ulos!'));
    }

    public static function home(){
      self::check_logged_in();
      View::make('home.html');
    }

  }
