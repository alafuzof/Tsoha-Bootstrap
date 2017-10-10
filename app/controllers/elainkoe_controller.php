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
      //$kokeet = Elainkoe::find_by_lupa($lupa);
      View::make('elainkoe/show.html', array('koe' => $koe));
    }
  }
