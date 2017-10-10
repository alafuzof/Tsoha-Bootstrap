<?php

  class Elainkoe extends BaseModel {
    public $id, $suorituspvm, $laji, $ika, $lukumaara, $lisatiedot,
           $lupa_id, $lupa_tunnus, $kayttajat_id, $kayttajat_nimi;

    public function __construct($attributes) {
      parent::__construct($attributes);
      // FIXME: $this->validators = array
    }

    // FIXME: validointifunktiot

    public static function all() {
      $query = DB::connection()->prepare(
        'SELECT o.koe_id AS koe_id, o.kayttaja_id AS kayttaja_id, k.nimi AS kayttaja_nimi ' .
        ' FROM Osallistuminen AS o ' .
        ' LEFT JOIN Kayttaja AS k ' .
        ' ON o.kayttaja_id = k.id;');
      $query->execute();
      $rows = $query->fetchAll();
      $k_id = array();
      $k_nimi = array();

      foreach($rows as $row) {
        $koe_id = $row['koe_id'];
        if(array_key_exists($koe_id, $k_id)) {
          $k_id[$koe_id][] = $row['kayttaja_id'];
          $k_nimi[$koe_id][] = $row['kayttaja_nimi'];
        } else {
          $k_id[$koe_id] = array($row['kayttaja_id']);
          $k_nimi[$koe_id] = array($row['kayttaja_nimi']);
        }
      }

      $query = DB::connection()->prepare(
        'SELECT e.id AS id, e.suorituspvm AS suorituspvm, e.laji AS laji, e.ika AS ika, e.lukumaara AS lukumaara, e.lisatiedot AS lisatiedot, e.lupa_id AS lupa_id, l.tunnus AS lupa_tunnus '.
        ' FROM Elainkoe AS e ' .
        ' LEFT JOIN Elainkoelupa AS l ' .
        ' ON e.lupa_id = l.id;');
      $query->execute();
      $rows = $query->fetchAll();
      $kokeet = array();

      foreach($rows as $row) {
        if(!array_key_exists($row['id'], $k_id)) { // Tähän ei toivottavasti koskaan päädytä
          $k_id[$row['id']] = array();
          $k_nimi[$row['id']] = array();
        }
        $kokeet[] = new Elainkoe(array(
          'id' => $row['id'],
          'suorituspvm' => $row['suorituspvm'],
          'laji' => $row['laji'],
          'ika' => $row['ika'],
          'lukumaara' => $row['lukumaara'],
          'lisatiedot' => $row['lisatiedot'],
          'lupa_id' => $row['lupa_id'],
          'lupa_tunnus' => $row['lupa_tunnus'],
          'kayttajat_nimi' => $k_nimi[$row['id']],
          'kayttajat_id' => $k_id[$row['id']]
        ));
      }

      return $kokeet;
    }

    public static function find($id) {
      $query = DB::connection()->prepare(
        'SELECT e.id AS id, e.suorituspvm AS suorituspvm, e.laji AS laji, e.ika AS ika, e.lukumaara AS lukumaara, e.lisatiedot AS lisatiedot, e.lupa_id AS lupa_id, l.tunnus AS lupa_tunnus '.
        ' FROM Elainkoe AS e ' .
        ' LEFT JOIN Elainkoelupa AS l ' .
        ' ON e.lupa_id = l.id '.
        ' WHERE e.id = :id;');
      $query->execute(array('id' => $id));
      $row = $query->fetch();

      if($row) {
        $query = DB::connection()->prepare(
          'SELECT o.koe_id AS koe_id, o.kayttaja_id AS kayttaja_id, k.nimi AS kayttaja_nimi ' .
          ' FROM Osallistuminen AS o ' .
          ' LEFT JOIN Kayttaja AS k ' .
          ' ON o.kayttaja_id = k.id ' .
          ' WHERE o.koe_id = :id;');
        $query->execute(array('id' => $row['id']));
        $o_rows = $query->fetchAll();
        $k_id = array();
        $k_nimi = array();
        foreach($o_rows as $o_row) {
          $k_id[] = $o_row['kayttaja_id'];
          $k_nimi[] = $o_row['kayttaja_nimi'];
        }

        $koe = new Elainkoe(array(
          'id' => $row['id'],
          'suorituspvm' => $row['suorituspvm'],
          'laji' => $row['laji'],
          'ika' => $row['ika'],
          'lukumaara' => $row['lukumaara'],
          'lisatiedot' => $row['lisatiedot'],
          'lupa_id' => $row['lupa_id'],
          'lupa_tunnus' => $row['lupa_tunnus'],
          'kayttajat_nimi' => $k_nimi,
          'kayttajat_id' => $k_id));

        return $koe;
      }

      return NULL;
    }

    public static function find_by_kayttaja($kayttaja) {
      $query = DB::connection()->prepare(
        'SELECT o.koe_id AS koe_id, o.kayttaja_id AS kayttaja_id, k.nimi AS kayttaja_nimi ' .
        ' FROM Osallistuminen AS o ' .
        ' LEFT JOIN Kayttaja AS k ' .
        ' ON o.kayttaja_id = k.id;');
      $query->execute();
      $rows = $query->fetchAll();
      $k_id = array();
      $k_nimi = array();

      foreach($rows as $row) {
        $koe_id = $row['koe_id'];
        if(array_key_exists($koe_id, $k_id)) {
          $k_id[$koe_id][] = $row['kayttaja_id'];
          $k_nimi[$koe_id][] = $row['kayttaja_nimi'];
        } else {
          $k_id[$koe_id] = array($row['kayttaja_id']);
          $k_nimi[$koe_id] = array($row['kayttaja_nimi']);
        }
      }

      $query = DB::connection()->prepare(
        'SELECT e.id AS id, e.suorituspvm AS suorituspvm, e.laji AS laji, e.ika AS ika, e.lukumaara AS lukumaara, e.lisatiedot AS lisatiedot, e.lupa_id AS lupa_id, l.tunnus AS lupa_tunnus '.
        ' FROM Elainkoe AS e ' .
        ' LEFT JOIN Elainkoelupa AS l ' .
        ' ON e.lupa_id = l.id ' .
        ' WHERE e.id IN (SELECT koe_id FROM Osallistuminen WHERE kayttaja_id = :kayttaja_id);');
      //$tmp = '(' . implode(',', array_keys($k_id)) . ')';
      $query->execute(array('kayttaja_id' => $kayttaja->id));
      $rows = $query->fetchAll();
      $kokeet = array();

      foreach($rows as $row) {
        if(!array_key_exists($row['id'], $k_id)) { // Tähän ei toivottavasti koskaan päädytä
          $k_id[$row['id']] = array();
          $k_nimi[$row['id']] = array();
        }
        $kokeet[] = new Elainkoe(array(
          'id' => $row['id'],
          'suorituspvm' => $row['suorituspvm'],
          'laji' => $row['laji'],
          'ika' => $row['ika'],
          'lukumaara' => $row['lukumaara'],
          'lisatiedot' => $row['lisatiedot'],
          'lupa_id' => $row['lupa_id'],
          'lupa_tunnus' => $row['lupa_tunnus'],
          'kayttajat_nimi' => $k_nimi[$row['id']],
          'kayttajat_id' => $k_id[$row['id']]
        ));
      }

      return $kokeet;
    }

    // FIXME: public function save() {

    // FIXME: public function update() {

    // FIXME public function destroy() {
  }
