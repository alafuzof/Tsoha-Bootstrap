-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TYPE kayttajanoikeudet AS ENUM ('tutkija', 'lupavastaava', 'yllapitaja');
CREATE TYPE elainlaji AS ENUM ('rotta', 'hiiri');

CREATE TABLE Kayttaja (
  id        SERIAL PRIMARY KEY,
  tunnus    VARCHAR(20) NOT NULL,
  salasana  VARCHAR(20) NOT NULL,
  nimi      VARCHAR(100) NOT NULL,
  email     VARCHAR(100) NOT NULL,
  oikeudet  kayttajanoikeudet,
  status    BOOLEAN,
  lisayspvm DATE
);

CREATE TABLE Elainkoelupa (
  id           SERIAL PRIMARY KEY,
  tunnus       VARCHAR(20) NOT NULL,
  nimi         VARCHAR(100) NOT NULL,
  alkupvm      DATE,
  loppupvm     DATE,
  vastuuhlo_id INTEGER REFERENCES Kayttaja(id)
);

CREATE TABLE Elainkoe (
  id          SERIAL PRIMARY KEY,
  suorituspvm DATE,
  laji        elainlaji,
  ika         VARCHAR(20),
  lukumaara   INTEGER,
  lisatiedot  VARCHAR(500),
  lupa_id     INTEGER REFERENCES Elainkoelupa(id)
);

CREATE TABLE Koeosallistuminen (
  koe_id      INTEGER REFERENCES Elainkoe(id),
  kayttaja_id INTEGER REFERENCES Kayttaja(id),
  PRIMARY KEY(koe_id, kayttaja_id)
);
