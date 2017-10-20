<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validators as $validator){
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
        $errors = array_merge($errors, $this->{$validator}());
      }

      return $errors;
    }

    public static function validate_integer_value($value, $min_value=NULL, $max_value=NULL, $target='Muuttuja') {
      $errors = array();
      if(!is_int($value)) {
        $errors[] = $target . ' täytyy olla kokonaisluku';
      }
      if($min_value != NULL && $value < $min_value) {
        $errors[] = $target . ' täytyy olla vähintään ' . $min_value;
      }
      if($max_value != NULL && $value > $max_value) {
        $errors[] = $target . ' täytyy olla korkeintaan ' . $max_value;
      }

      return $errors;
    }

    public static function validate_string_length($string, $min_length=NULL, $max_length=NULL, $target='Muuttuja') {
      $errors = array();
      if($min_length != NULL && strlen($string)<$min_length) {
        $errors[] = $target . ' on liian lyhyt (min. ' . $min_length . ' merkkiä)';
      }
      if($max_length != NULL && strlen($string)>$max_length) {
        $errors[] = $target . ' on liian pitkä (max. ' . $max_length . ' merkkiä)';
      }

      return $errors;
    }

    public static function validate_date($date, $format='Y-m-d', $id='Päivämäärä') {
      $errors = array();
      if($date != date($format, strtotime($date))) {
        $errors[] = $id . ' pitää antaa muodossa ' . $format;
      }

      return $errors;
    }

    public static function validate_in_set($value, $set, $id='Muuttujan') {
      $errors = array();
      if(!in_array($value, $set)) {
        $errors[] = $id . ' pitää olla joukossa [' . implode($set, ', ') . ']';
      }

      return $errors;
    }

  }
