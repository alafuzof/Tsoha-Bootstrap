<?php

  class Elainkoelupa extends BaseModel {
    public $id, $tunnus, $nimi, $vastuuhlo_id, $vastuuhlo_nimi, $alkupvm, $loppupvm;

    public function __construct($attributes) {
      parent::__construct($attributes);
      $this->validators = array('validate_tunnus', 'validate_nimi', 'validate_vastuuhlo_id',
                                'validate_alkupvm', 'validate_loppupvm', 'validate_aikaero');
    }

    public function validate_tunnus() {
      return $this->validate_string_length($this->tunnus, 3, 20, 'Tunnus');
    }

    public function validate_nimi() {
      return $this->validate_string_length($this->nimi, 3, 100, 'Nimi');
    }

    public function validate_vastuuhlo_id() {
      $errors = array();
      $kayttaja = Kayttaja::find($this->vastuuhlo_id);
      if($kayttaja == NULL) {
        $errors[] = 'Annettua käyttäjää ei löydy järjestelmästä';
      } elseif($kayttaja->oikeudet == 'tutkija') {
        $errors[] = 'Vain ylläpitäjät tai lupavaastaavat voivat olla vastuuhenkilöitä';
      }
      return $errors;
    }

    public function validate_alkupvm() {
      return $this->validate_date($this->alkupvm, 'Y-m-d', 'Alkupäivämäärä');
    }

    public function validate_loppupvm() {
      return $this->validate_date($this->loppupvm, 'Y-m-d', 'Loppupäivämäärä');
    }

    public function validate_aikaero() {
      $errors = array();
      if($this->alkupvm > $this->loppupvm) {
        $errors[] = 'Alkupäivämäärän on oltava ennen loppupäivämäärää';
      }

      return $errors;
    }

    public static function all() {
      $query = DB::connection()->prepare(
        'SELECT l.id AS id, l.tunnus AS tunnus, l.nimi AS nimi, ' .
        '       l.alkupvm AS alkupvm, l.loppupvm AS loppupvm, ' .
        '       l.vastuuhlo_id AS vastuuhlo_id, k.nimi AS vastuuhlo_nimi ' .
        'FROM Elainkoelupa AS l ' .
        'LEFT JOIN Kayttaja AS k ' .
        'ON l.vastuuhlo_id = k.id;');
      $query->execute();
      $rows = $query->fetchAll();
      $luvat = array();

      foreach($rows as $row) {
        $luvat[] = new Elainkoelupa(array(
          'id' => $row['id'],
          'tunnus' => $row['tunnus'],
          'nimi' => $row['nimi'],
          'alkupvm' => $row['alkupvm'],
          'loppupvm' => $row['loppupvm'],
          'vastuuhlo_id' => $row['vastuuhlo_id'],
          'vastuuhlo_nimi' => $row['vastuuhlo_nimi']
        ));
      }

      return $luvat;
    }

    public static function find($id) {
      $query = DB::connection()->prepare(
        'SELECT l.id AS id, l.tunnus AS tunnus, l.nimi AS nimi, ' .
        '       l.alkupvm AS alkupvm, l.loppupvm AS loppupvm, ' .
        '       l.vastuuhlo_id AS vastuuhlo_id, k.nimi AS vastuuhlo_nimi ' .
        'FROM Elainkoelupa AS l ' .
        'LEFT JOIN Kayttaja AS k ' .
        'ON l.vastuuhlo_id = k.id ' .
        'WHERE l.id = :id;');
      $query->execute(array('id' => $id));
      $row = $query->fetch();

      if($row) {
        $lupa = new Elainkoelupa(array(
          'id' => $row['id'],
          'tunnus' => $row['tunnus'],
          'nimi' => $row['nimi'],
          'alkupvm' => $row['alkupvm'],
          'loppupvm' => $row['loppupvm'],
          'vastuuhlo_id' => $row['vastuuhlo_id'],
          'vastuuhlo_nimi' => $row['vastuuhlo_nimi']
        ));

        return $lupa;
      }

      return NULL;
    }

    public static function find_by_kayttaja($kayttaja) {
      $query = DB::connection()->prepare(
        'SELECT l.id AS id, l.tunnus AS tunnus, l.nimi AS nimi, ' .
        '       l.alkupvm AS alkupvm, l.loppupvm AS loppupvm, ' .
        '       l.vastuuhlo_id AS vastuuhlo_id, k.nimi AS vastuuhlo_nimi ' .
        'FROM Elainkoelupa AS l ' .
        'LEFT JOIN Kayttaja AS k ' .
        'ON l.vastuuhlo_id = k.id ' .
        'WHERE k.id = :kayttaja_id;');
      $query->execute(array('kayttaja_id' => $kayttaja->id));

      $rows = $query->fetchAll();
      $luvat = array();

      foreach($rows as $row) {
        $luvat[] = new Elainkoelupa(array(
          'id' => $row['id'],
          'tunnus' => $row['tunnus'],
          'nimi' => $row['nimi'],
          'alkupvm' => $row['alkupvm'],
          'loppupvm' => $row['loppupvm'],
          'vastuuhlo_id' => $row['vastuuhlo_id'],
          'vastuuhlo_nimi' => $row['vastuuhlo_nimi']
        ));
      }

      return $luvat;
    }

    public static function find_by_tunnus($tunnus) {
      $query = DB::connection()->prepare(
        'SELECT l.id AS id, l.tunnus AS tunnus, l.nimi AS nimi, ' .
        '       l.alkupvm AS alkupvm, l.loppupvm AS loppupvm, ' .
        '       l.vastuuhlo_id AS vastuuhlo_id, k.nimi AS vastuuhlo_nimi ' .
        'FROM Elainkoelupa AS l ' .
        'LEFT JOIN Kayttaja AS k ' .
        'ON l.vastuuhlo_id = k.id ' .
        'WHERE l.tunnus = :tunnus;');
      $query->execute(array('tunnus' => $tunnus));
      $row = $query->fetch();

      if($row) {
        $lupa = new Elainkoelupa(array(
          'id' => $row['id'],
          'tunnus' => $row['tunnus'],
          'nimi' => $row['nimi'],
          'alkupvm' => $row['alkupvm'],
          'loppupvm' => $row['loppupvm'],
          'vastuuhlo_id' => $row['vastuuhlo_id'],
          'vastuuhlo_nimi' => $row['vastuuhlo_nimi']
        ));

        return $lupa;
      }

      return NULL;
    }

    public function save() {
      $query = DB::connection()->prepare(
        'INSERT INTO Elainkoelupa (tunnus, nimi, alkupvm, loppupvm, vastuuhlo_id) VALUES ' .
        '(:tunnus, :nimi, :alkupvm, :loppupvm, :vastuuhlo_id) RETURNING id;');
      $query->execute(array('tunnus' => $this->tunnus,
                            'nimi' => $this->nimi,
                            'alkupvm' => $this->alkupvm,
                            'loppupvm' => $this->loppupvm,
                            'vastuuhlo_id' => $this->vastuuhlo_id));
      $row = $query->fetch();
      $this->id = $row['id'];
    }

    public function update() {
      $query = DB::connection()->prepare(
        'UPDATE Kayttaja SET ' .
        '  tunnus = :tunnus, nimi = :nimi, alkupvm = :alkupvm ' .
        '  loppupvm = :loppupvm, vastuuhlo_id = :vastuuhlo_id ' .
        '  WHERE id = :id;');
      $query->execute(array('tunnus' => $this->tunnus,
                            'nimi' => $this->nimi,
                            'alkupvm' => $this->alkupvm,
                            'loppupvm' => $this->loppupvm,
                            'vastuuhlo_id' => $this->vastuuhlo_id,
                            'id' => $this->id));
    }

    public function destroy() {
      // FIXME poista kokeet

      $query = DB::connection()->prepare(
        'DELETE FROM Elainkoelupa WHERE id = :id;');
      $query->execute(array('id' => $this->id));
    }
  }
