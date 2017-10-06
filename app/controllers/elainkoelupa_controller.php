<?php

  class ElainkoelupaController extends BaseController {
    public static function index() {
      $luvat = Elainkoelupa::all();
      View::make('elainkoelupa/index.html', array('luvat' => $luvat));
    }
  }
