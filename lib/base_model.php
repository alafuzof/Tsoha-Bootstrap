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

    public function validate_string_length($string, $min_length=null, $max_length=null, $target=null) {
      $errors = array();
      if($target == null) {
        $target = 'Merkkijono';
      }
      if($string == '' || $string == null) {
        $errors[] = $target . ' ei voi olla tyhjä';
      }
      if($min_length != null && strlen($string)<$min_length) {
        $errors[] = $target . ' on liian lyhyt (min. ' . $min_length . ' merkkiä)';
      }
      if($max_length != null && strlen($string)>$max_length) {
        $errors[] = $target . ' on liian pitkä (max. ' . $max_length . ' merkkiä)';
      }

      return $errors;
    }

    function validate_date($date, $format='Y-m-d', $id='Päivämäärä') {
      $errors = array();
      if($date != date($format, strtotime($date))) {
        $errors[] = $id . ' pitää antaa muodossa ' . $format;
      }

      return $errors;
    }

  }
