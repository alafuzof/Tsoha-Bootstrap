<?php

  class Kayttaja extends BaseModel {
    public $id, $tunnus, $salasana, $nimi, $email,
           $oikeudet, $status, $lisayspvm;

    public function __construct($attributes) {
      parent::__construct($attributes);
    }

    public static function all() {
      $query = DB::connection()->prepare('SELECT * FROM Kayttaja;');
      $query->execute();
      $rows = $query->fetchAll();
      $kayttajat = array();

      foreach($rows as $row){
        $kayttajat[] = new Kayttaja(array(
          'id' => $row['id'],
          'tunnus' => $row['tunnus'],
          'salasana' => $row['salasana'],
          'nimi' => $row['nimi'],
          'email' => $row['email'],
          'oikeudet' => $row['oikeudet'],
          'status' => $row['status'],
          'lisayspvm' => $row['lisayspvm']
        ));
      }

      return $kayttajat;
    }

    public static function find($id){
      $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1;');
      $query->execute(array('id' => $id));
      $row = $query->fetch();

      if($row){
        $kayttaja = new Kayttaja(array(
          'id' => $row['id'],
          'tunnus' => $row['tunnus'],
          'salasana' => $row['salasana'],
          'nimi' => $row['nimi'],
          'email' => $row['email'],
          'oikeudet' => $row['oikeudet'],
          'status' => $row['status'],
          'lisayspvm' => $row['lisayspvm']
        ));

        return $kayttaja;
      }

      return null;
    }

    public function save() {
      $query = DB::connection()->prepare(
        'INSERT INTO Kayttaja (tunnus, salasana, nimi, email, oikeudet, status, lisayspvm) VALUES ' .
        '(:tunnus, :salasana, :nimi, :email, :oikeudet, :status, :lisayspvm) RETURNING id;');
      $query->execute(array('tunnus' => $this->tunnus,
                            'salasana' => $this->salasana,
                            'nimi' => $this->nimi,
                            'email' => $this->email,
                            'oikeudet' => $this->oikeudet,
                            'status' => $this->status,
                            'lisayspvm' => date('Y-m-d')));
      $row = $query->fetch();
      $this->id = $row['id'];
    }

  }
