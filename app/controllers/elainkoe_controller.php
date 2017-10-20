<?php

  class ElainkoeController extends BaseController {
    public static function index() {
      self::check_logged_in();

      $kokeet = Elainkoe::all();
      View::make('elainkoe/index.html', array('kokeet' => $kokeet));
    }

    public static function show($id) {
      self::check_logged_in();

      $koe = Elainkoe::find($id);
      View::make('elainkoe/show.html', array('koe' => $koe));
    }

    public static function create() {
      self::check_logged_in();

      $kayttajat = Kayttaja::all();
      $luvat = Elainkoelupa::all();
      View::make('elainkoe/edit.html', array('otsikko' => 'Lisää uusi koe',
                                             'kohde'   => 'new',
                                             'kayttajat' => $kayttajat,
                                             'luvat' => $luvat));
    }

    public static function store() {
      self::check_logged_in();

      $params = $_POST;
      $params['lukumaara'] = intval($params['lukumaara']);

      $koe = new Elainkoe(array(
        'suorituspvm' => $params['suorituspvm'],
        'laji' => $params['laji'],
        'ika' => $params['ika'],
        'lukumaara' => $params['lukumaara'],
        'lisatiedot' => $params['lisatiedot'],
        'lupa_id' => $params['lupa_id'],
        'kayttajat_id' => $params['kayttajat_id']));
      $errors = $koe->errors();

      // Tarkista että tutkija käyttäjä ei luo kokeita, joihin ei itse osallistu
      $logged_in = self::get_user_logged_in();
      if($logged_in->oikeudet == 'tutkija' && !in_array($logged_in->id, $params['kayttajat_id'])) {
        $errors[] = 'Sinun täytyy olla kokeeseen osallistuja';
      }

      if(count($errors) == 0) {
        $koe->save();
        Redirect::to('/experiment', array('success' => 'Koe on lisätty järjestelmään!'));
      } else {
        $kayttajat = Kayttaja::all();
        $luvat = Elainkoelupa::all();
        View::make('elainkoe/edit.html', array('otsikko' => 'Lisää uusi koe',
                                               'kohde'   => 'new',
                                               'kayttajat' => $kayttajat,
                                               'luvat' => $luvat,
                                               'koe' => $koe,
                                               'errors' => $errors));
      }
    }

    public static function edit($id) {
      self::check_logged_in();
      self::check_right_to_modify($id);

      $koe = Elainkoe::find($id);
      $kayttajat = Kayttaja::all();
      $luvat = Elainkoelupa::all();
      View::make('elainkoe/edit.html', array('otsikko' => 'Lisää uusi koe',
                                             'kohde'   => 'edit',
                                             'kayttajat' => $kayttajat,
                                             'luvat' => $luvat,
                                             'koe' => $koe));
    }

    public static function update($id) {
      self::check_logged_in();
      self::check_right_to_modify($id);

      $params = $_POST;
      $params['lukumaara'] = intval($params['lukumaara']);

      $koe = new Elainkoe(array(
        'id' => $params['id'],
        'suorituspvm' => $params['suorituspvm'],
        'laji' => $params['laji'],
        'ika' => $params['ika'],
        'lukumaara' => $params['lukumaara'],
        'lisatiedot' => $params['lisatiedot'],
        'lupa_id' => $params['lupa_id'],
        'kayttajat_id' => $params['kayttajat_id']));
      $errors = $koe->errors();

      // Tarkista että tutkija käyttäjä ei luo kokeita, joihin ei itse osallistu
      $logged_in = self::get_user_logged_in();
      if($logged_in->oikeudet == 'tutkija' && !in_array($logged_in->id, $params['kayttajat_id'])) {
        $errors[] = 'Sinun täytyy olla kokeeseen osallistuja';
      }

      if(count($errors) == 0) {
        $koe->update();
        Redirect::to('/experiment', array('success' => 'Koetta muokattu'));
      } else {
        $koe = Elainkoe::find($id);
        $kayttajat = Kayttaja::all();
        $luvat = Elainkoelupa::all();
        View::make('elainkoe/edit.html', array('otsikko' => 'Lisää uusi koe',
                                               'kohde'   => 'edit',
                                               'kayttajat' => $kayttajat,
                                               'luvat' => $luvat,
                                               'koe' => $koe,
                                               'errors' => $errors));
      }
    }

    public static function destroy($id) {
      self::check_logged_in();
      self::check_right_to_modify($id);

      $koe = Elainkoe::find($id);
      $koe->destroy();

      Redirect::to('/experiment', array('success' => 'Koe on poistettu järjestelmästä!'));
    }

    private static function check_right_to_modify($id) {
      $kayttaja = self::get_user_logged_in();
      $koe = Elainkoe::find($id);
      $lupa = Elainkoelupa::find($koe->lupa_id);
      if(!in_array($kayttaja->id, $koe->kayttajat_id) && $kayttaja->id != $lupa->vastuuhlo_id && $kayttaja->oikeudet != 'yllapitaja') {
        Redirect::to('/experiment', array('error' => 'Sinulla ei ole oikeutta muokata tai tätä koetta!'));
      }
    }
  }
