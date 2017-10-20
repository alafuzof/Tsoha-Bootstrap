-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja (tunnus, salasana, nimi, email, oikeudet, status, lisayspvm) VALUES
  ('ylläpitäjä', 'ylläpitäjä', 'Ylläpitäjä', 'yllapitaja@yliopisto.fi', 'yllapitaja', 'true', '2017-09-01'),
  ('lupavastaava', 'lupavastaava', 'Lupavastaava', 'lupavastaava@yliopisto.fi', 'lupavastaava', 'true', '2017-09-01'),
  ('lupavastaava2', 'lupavastaava2', 'Toinen lupavastaava', 'lupavastaava2@yliopisto.fi', 'lupavastaava', 'true', '2017-09-01'),
  ('tutkija', 'tutkija', 'Tutkija', 'tutkija@yliopisto.fi', 'tutkija', 'true', '2017-09-01'),
  ('tutkija2', 'tutkija2', 'Toinen tutkija', 'tutkija2@yliopisto.fi', 'tutkija', 'true', '2017-09-01'),
  ('test', 'test', 'Test', 'test@yliopisto.fi', 'yllapitaja', 'true', '2017-09-01');

INSERT INTO Elainkoelupa (tunnus, nimi, alkupvm, loppupvm, vastuuhlo_id) VALUES
  ('ESAVI-12345', 'Rottien levitointitutkimus', '2017-06-01', '2019-06-01', (SELECT id FROM Kayttaja WHERE tunnus = 'lupavastaava')),
  ('ESAVI-54321', 'Rottien näkymättömyystutkimus', '2017-08-01', '2022-06-01', (SELECT id FROM Kayttaja WHERE tunnus = 'lupavastaava2'));

INSERT INTO Elainkoe (suorituspvm, laji, ika, lukumaara, lisatiedot, lupa_id) VALUES
  ('2017-09-15', 'rotta', 'Aikuinen', 3, 'Levitointi onnistunut!', (SELECT id FROM Elainkoelupa WHERE tunnus = 'ESAVI-12345')),
  ('2017-09-16', 'rotta', 'P6', 1, 'Rotta lensi ulos ikkunasta!', (SELECT id FROM Elainkoelupa WHERE tunnus = 'ESAVI-12345')),
  ('2017-09-15', 'rotta', 'P12', 5, 'Mihin ne katosivat!?', (SELECT id FROM Elainkoelupa WHERE tunnus = 'ESAVI-54321'));

INSERT INTO Osallistuminen (koe_id, kayttaja_id) VALUES
  ((SELECT id FROM Elainkoe WHERE lisatiedot = 'Levitointi onnistunut!'), (SELECT id FROM Kayttaja WHERE tunnus = 'tutkija')),
  ((SELECT id FROM Elainkoe WHERE lisatiedot = 'Levitointi onnistunut!'), (SELECT id FROM Kayttaja WHERE tunnus = 'lupavastaava')),
  ((SELECT id FROM Elainkoe WHERE lisatiedot = 'Rotta lensi ulos ikkunasta!'), (SELECT id FROM Kayttaja WHERE tunnus = 'tutkija2')),
  ((SELECT id FROM Elainkoe WHERE lisatiedot = 'Mihin ne katosivat!?'), (SELECT id FROM Kayttaja WHERE tunnus = 'tutkija')),
  ((SELECT id FROM Elainkoe WHERE lisatiedot = 'Mihin ne katosivat!?'), (SELECT id FROM Kayttaja WHERE tunnus = 'tutkija2')),
  ((SELECT id FROM Elainkoe WHERE lisatiedot = 'Mihin ne katosivat!?'), (SELECT id FROM Kayttaja WHERE tunnus = 'ylläpitäjä'));
