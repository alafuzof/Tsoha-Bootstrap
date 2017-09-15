<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  //View::make('home.html');
      View::make('suunnitelmat/index.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
    }

    public static function login(){
      View::make('suunnitelmat/login.html');
    }

    public static function user_list(){
      View::make('suunnitelmat/user_list.html');
    }

    public static function user_edit(){
      View::make('suunnitelmat/user_edit.html');
    }

    public static function licence_list(){
      View::make('suunnitelmat/licence_list.html');
    }

    public static function licence_edit(){
      View::make('suunnitelmat/licence_edit.html');
    }

    public static function experiment_list(){
      View::make('suunnitelmat/experiment_list.html');
    }

    public static function experiment_edit(){
      View::make('suunnitelmat/experiment_edit.html');
    }
  }
