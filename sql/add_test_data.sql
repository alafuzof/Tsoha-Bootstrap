-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja (tunnus, salasana, nimi, email, oikeudet, status, lisayspvm) VALUES
  ('ylläpitaja', 'ylläpitaja', 'Ylläpitäjä', 'yllapitaja@yliopisto.fi', 'yllapitaja', 'true', '2017-09-01'),
  ('lupavastaava', 'lupavastaava', 'Lupavastaava', 'lupavastaava@yliopisto.fi', 'lupavastaava', 'true', '2017-09-01'),
  ('tutkija', 'tutkija', 'Tutkija', 'tutkija@yliopisto.fi', 'tutkija', 'true', '2017-09-01'),
  ('test', 'test', 'Test', 'test@yliopisto.fi', 'yllapitaja', 'true', '2017-09-01');

INSERT INTO Elainkoelupa (tunnus, nimi, alkupvm, loppupvm, vastuuhlo_id) VALUES
  ('ESAVI-12345', 'Rottien levitointitutkimus', '2017-06-01', '2019-06-01', (SELECT id FROM Kayttaja WHERE tunnus = 'linda'));

INSERT INTO Elainkoe (suorituspvm, laji, ika, lukumaara, lisatiedot, lupa_id) VALUES
  ('2017-09-15', 'rotta', 'Aikuinen', 3, 'Levitointi onnistunut!', (SELECT id FROM Elainkoelupa WHERE tunnus = 'ESAVI-12345'));

INSERT INTO Osallistuminen (koe_id, kayttaja_id) VALUES
  ((SELECT id FROM Elainkoe WHERE lisatiedot = 'Levitointi onnistunut!'), (SELECT id FROM Kayttaja WHERE tunnus = 'tutkija')),
  ((SELECT id FROM Elainkoe WHERE lisatiedot = 'Levitointi onnistunut!'), (SELECT id FROM Kayttaja WHERE tunnus = 'lupavastaava'));
