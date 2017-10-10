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
  }
