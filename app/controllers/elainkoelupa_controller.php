<?php

  class ElainkoelupaController extends BaseController {
    public static function index() {
      self::check_logged_in();

      $luvat = Elainkoelupa::all();
      View::make('elainkoelupa/index.html', array('luvat' => $luvat));
    }

    public static function show($id) {
      self::check_logged_in();

      $lupa = Elainkoelupa::find($id);
      $kokeet = Elainkoe::find_by_lupa($lupa);
      View::make('elainkoelupa/show.html', array('lupa' => $lupa,
                                                 'kokeet' => $kokeet));
    }

    public static function create() {
      self::check_logged_in();
      self::check_lupavastaava();
      $lupavastaavat = array_merge(Kayttaja::find_by_oikeudet('lupavastaava'),
                                   Kayttaja::find_by_oikeudet('yllapitaja'));
      View::make('elainkoelupa/edit.html', array('otsikko' => 'Luo uusi eläinkoelupa',
                                                 'kohde' => 'new',
                                                 'lupavastaavat' => $lupavastaavat));
    }

    public static function store() {
      self::check_logged_in();
      self::check_lupavastaava();

      $params = $_POST;

      $params['vastuuhlo_nimi'] = Kayttaja::find($params['vastuuhlo_id'])->nimi;

      $lupa = new Elainkoelupa(array(
        'tunnus'         => $params['tunnus'],
        'nimi'           => $params['nimi'],
        'vastuuhlo_id'   => $params['vastuuhlo_id'],
        'vastuuhlo_nimi' => $params['vastuuhlo_nimi'],
        'alkupvm'        => $params['alkupvm'],
        'loppupvm'       => $params['loppupvm']));
      $errors = $lupa->errors();
      if(Elainkoelupa::find_by_tunnus($lupa->tunnus) != NULL) {
        $errors[] = 'Tunnus ' . $lupa->tunnus . ' on jo käytössä!';
      }

      if(count($errors) == 0) {
        $lupa->save();
        Redirect::to('/licence', array('success' => 'Lupa ' . $lupa->tunnus . ' on lisätty järjestelmään!'));
      } else {
        $lupavastaavat = array_merge(Kayttaja::find_by_oikeudet('lupavastaava'),
                                     Kayttaja::find_by_oikeudet('yllapitaja'));
        View::make('elainkoelupa/edit.html', array('otsikko' => 'Luo uusi eläinkoelupa',
                                                   'kohde' => 'new',
                                                   'lupavastaavat' => $lupavastaavat,
                                                   'lupa' => $lupa,
                                                   'errors' => $errors));
      }
    }

    public static function edit($id) {
      self::check_logged_in();
      self::check_right_to_modify($id);

      $lupa = Elainkoelupa::find($id);
      $lupavastaavat = array_merge(Kayttaja::find_by_oikeudet('lupavastaava'),
                                   Kayttaja::find_by_oikeudet('yllapitaja'));
      View::make('elainkoelupa/edit.html', array('otsikko' => 'Muokkaa luvan ' . $lupa->tunnus . ' tietoja',
                                                 'kohde' => 'edit',
                                                 'lupavastaavat' => $lupavastaavat,
                                                 'lupa' => $lupa));
    }

    public static function update($id) {
      self::check_logged_in();
      self::check_right_to_modify($id);

      $params = $_POST;

      $params['vastuuhlo_nimi'] = Kayttaja::find($params['vastuuhlo_id'])->nimi;

      $lupa = new Elainkoelupa(array(
        'id'             => $params['id'],
        'tunnus'         => $params['tunnus'],
        'nimi'           => $params['nimi'],
        'vastuuhlo_id'   => $params['vastuuhlo_id'],
        'vastuuhlo_nimi' => $params['vastuuhlo_nimi'],
        'alkupvm'        => $params['alkupvm'],
        'loppupvm'       => $params['loppupvm']));

      $errors = $lupa->errors();
      $tmp = Elainkoelupa::find_by_tunnus($lupa->tunnus);
      if($tmp != NULL && $lupa->id != $tmp->id) {
        $errors[] = 'Tunnus ' . $lupa->tunnus . ' on jo käytössä!';
      }

      if(count($errors) == 0) {
        $lupa->update();
        Redirect::to('/licence', array('success' => 'Lupaa ' . $lupa->tunnus . ' muokattu!'));
      } else {
        $lupavastaavat = array_merge(Kayttaja::find_by_oikeudet('lupavastaava'),
                                     Kayttaja::find_by_oikeudet('yllapitaja'));
        View::make('elainkoelupa/edit.html', array('otsikko' => 'Muokkaa luvan ' . $lupa->tunnus . ' tietoja',
                                                   'kohde' => 'edit',
                                                   'lupavastaavat' => $lupavastaavat,
                                                   'lupa' => $lupa,
                                                   'errors' => $errors));
      }
    }

    public static function destroy($id) {
      self::check_logged_in();
      self::check_right_to_modify($id);

      $lupa = Elainkoelupa::find($id);
      $lupa->destroy();

      Redirect::to('/licence', array('success' => 'Lupa ' . $lupa->tunnus . ' on poistettu järjestelmästä!'));
    }

    private static function check_right_to_modify($id) {
      $kayttaja = self::get_user_logged_in();
      $lupa = Elainkoelupa::find($id);
      if($kayttaja->id != $lupa->vastuuhlo_id && $kayttaja->oikeudet != 'yllapitaja') {
        Redirect::to('/licence', array('error' => 'Sinulla ei ole oikeutta muokata tai poistaa lupaa ' . $lupa->tunnus . '!'));
      }
    }
  }
