-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja (tunnus, salasana, nimi, email, oikeudet, status, lisayspvm) VALUES 
  ('Yrmi', 'salainen', 'Yrmi Ylläpitäjä', 'yrmi.yllapitaja@yliopisto.fi', 'yllapitaja', 'true', '2017-09-01'), 
  ('linda', 'salasana', 'Linda Lupavastaava', 'linda.lupavastaava@yliopisto.fi', 'lupavastaava', 'true', '2017-09-10'),
  ('bella', '12345', 'Bella Biologi', 'bella.biologi@yliopisto.fi', 'tutkija', 'true', '2017-09-15');
  
INSERT INTO Elainkoelupa (tunnus, nimi, alkupvm, loppupvm, vastuuhlo_id) VALUES
  ('ESAVI-12345', 'Rottien levitointitutkimus', '2017-06-01', '2019-06-01', (SELECT id FROM Kayttaja WHERE tunnus = 'linda'));
  
INSERT INTO Elainkoe (suorituspvm, laji, ika, lukumaara, lisatiedot, lupa_id) VALUES
  ('2017-09-15', 'rotta', 'Aikuinen', 3, 'Levitointi onnistunut!', (SELECT id FROM Elainkoelupa WHERE tunnus = 'ESAVI-12345'));
  
INSERT INTO Koeosallistuminen (koe_id, kayttaja_id) VALUES
  ((SELECT id FROM Elainkoe WHERE lisatiedot = 'Levitointi onnistunut!'), (SELECT id FROM Kayttaja WHERE tunnus = 'bella')),
  ((SELECT id FROM Elainkoe WHERE lisatiedot = 'Levitointi onnistunut!'), (SELECT id FROM Kayttaja WHERE tunnus = 'linda'));
  
  
