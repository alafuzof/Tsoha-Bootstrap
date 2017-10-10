-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TYPE kayttajanoikeudet AS ENUM ('tutkija', 'lupavastaava', 'yllapitaja');
CREATE TYPE elainlaji AS ENUM ('rotta', 'hiiri');

CREATE TABLE Kayttaja (
  id        SERIAL PRIMARY KEY,
  tunnus    VARCHAR(20) NOT NULL UNIQUE,
  salasana  VARCHAR(20) NOT NULL,
  nimi      VARCHAR(100) NOT NULL,
  email     VARCHAR(100) NOT NULL,
  oikeudet  kayttajanoikeudet,
  status    BOOLEAN,
  lisayspvm DATE
);

CREATE TABLE Elainkoelupa (
  id           SERIAL PRIMARY KEY,
  tunnus       VARCHAR(20) NOT NULL UNIQUE,
  nimi         VARCHAR(100) NOT NULL,
  alkupvm      DATE,
  loppupvm     DATE,
  vastuuhlo_id INTEGER REFERENCES Kayttaja(id) ON DELETE CASCADE
);

CREATE TABLE Elainkoe (
  id          SERIAL PRIMARY KEY,
  suorituspvm DATE,
  laji        elainlaji,
  ika         VARCHAR(20),
  lukumaara   INTEGER,
  lisatiedot  VARCHAR(500),
  lupa_id     INTEGER REFERENCES Elainkoelupa(id) ON DELETE CASCADE
);

CREATE TABLE Osallistuminen (
  koe_id      INTEGER REFERENCES Elainkoe(id) ON DELETE CASCADE,
  kayttaja_id INTEGER REFERENCES Kayttaja(id) ON DELETE CASCADE,
  PRIMARY KEY(koe_id, kayttaja_id)
);
