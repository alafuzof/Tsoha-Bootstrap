<?php

  class Kayttaja extends BaseModel {
    public $id, $tunnus, $salasana, $nimi, $email,
           $oikeudet, $status, $lisayspvm;

    public function __construct($attributes) {
      parent::__construct($attributes);
      $this->validators = array('validate_tunnus', 'validate_salasana', 'validate_nimi',
                                'validate_email', 'validate_oikeudet', 'validate_status',
                                'validate_lisayspvm');
    }

    public function validate_tunnus() {
      return $this->validate_string_length($this->tunnus, 3, 20, 'Tunnus');
    }

    public function validate_salasana() {
      return $this->validate_string_length($this->salasana, 4, 20, 'Salasana');
    }

    public function validate_nimi() {
      return $this->validate_string_length($this->nimi, 3, 100, 'Nimi');
    }

    public function validate_email() {
      $errors = $this->validate_string_length($this->email, 5, 100, 'Sähköposti');
      if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Sähköpostin on noudatettava RFC822:sta';
      }
      return $errors;
    }

    public function validate_oikeudet() {
      $errors = array();
      if(!in_array($this->oikeudet, array('tutkija', 'lupavastaava', 'yllapitaja'))) {
        $errors[] = 'Käyttäjän oikeudet on oltava joukossa [tutkija, lupavastaava, yllapitaja]';
      }
      return $errors;
    }

    public function validate_status() {
      $errors = array();
      if(filter_var($this->status, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) == null) {
        $errors[] = 'Statuksen on oltava boolean ' . $this->status;
      }

      return $errors;
    }

    public function validate_lisayspvm() {
      return $this->validate_date($this->lisayspvm);
    }

    public static function all() {
      $query = DB::connection()->prepare('SELECT * FROM Kayttaja;');
      $query->execute();
      $rows = $query->fetchAll();
      $kayttajat = array();

      foreach($rows as $row) {
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

      if($row) {
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

      return NULL;
    }

    public static function authenticate($tunnus, $salasana) {
      $query = DB::connection()->prepare(
        'SELECT * FROM Kayttaja WHERE tunnus = :tunnus AND salasana = :salasana LIMIT 1;');
      $query->execute(array('tunnus' => $tunnus,
                            'salasana' => $salasana));
      $row = $query->fetch();
      if($row) {
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
      } else {
        return NULL;
      }
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
                            'lisayspvm' => $this->lisayspvm));
      $row = $query->fetch();
      $this->id = $row['id'];
    }

    public function update() {
      $query = DB::connection()->prepare(
        'UPDATE Kayttaja SET ' .
        '  tunnus = :tunnus, salasana = :salasana, nimi = :nimi, ' .
        '  email = :email, oikeudet = :oikeudet, status = :status ' .
        '  WHERE id = :id;');
      $query->execute(array('tunnus' => $this->tunnus,
                            'salasana' => $this->salasana,
                            'nimi' => $this->nimi,
                            'email' => $this->email,
                            'oikeudet' => $this->oikeudet,
                            'status' => $this->status,
                            'id' => $this->id));
    }

    public function destroy() {
      $query = DB::connection()->prepare(
        'DELETE FROM Kayttaja WHERE id = :id;');
      $query->execute(array('id' => $this->id));
    }

  }
