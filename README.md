# Tietokantasovelluksen esittelysivu

## Yleisiä linkkejä:

* [Linkki sovellukseeni](https://alafuzof.users.cs.helsinki.fi/animal/)
* [Linkki dokumentaatiooni](https://github.com/alafuzof/elainkoekirjanpito/blob/master/doc/dokumentaatio.pdf)

## Suunnitellut sivut

Nämä ovat staattisia mallisivuja. Loppupalautuksessa ainastaan kirjautumissivu on näkyvillä, kunnes käyttäjä on kirjautunut. Sivut on esitetty sellaisen käyttäjän näkökulmasta, jolla on oikeus selata, lisätä, muokata tai poistaa mitä tahansa tietoja.

* [Kirjautuminen](https://alafuzof.users.cs.helsinki.fi/animal/login)
* [Etusivu](https://alafuzof.users.cs.helsinki.fi/animal/)
* [Tarkastele käyttäjiä](https://alafuzof.users.cs.helsinki.fi/animal/user)
* [Muokkaa käyttäjää](https://alafuzof.users.cs.helsinki.fi/animal/user/1/edit)
* [Tarkastele lisenssejä](https://alafuzof.users.cs.helsinki.fi/animal/licence)
* [Muokkaa lisenssiä](https://alafuzof.users.cs.helsinki.fi/animal/licence/1/edit)
* [Tarkastele kokeita](https://alafuzof.users.cs.helsinki.fi/animal/experiment)
* [Muokaa koetta](https://alafuzof.users.cs.helsinki.fi/animal/experiment/1/edit)

## Työn aihe

Bio- ja lääketieteeen tutkimustyössä tehdään kokeita, joihin käytetään koe-eläimiä. Eläinkokeiden eettisten haasteiden vuoksi niiden tekemistä säädellään ja valvotaan tiukasti. Yksi osa tätä valvontaa on eläinkoekirjanpito, jota jokaisen eläinkokeita tekevän tutkijan on ylläpidettävä: jokainen käytetty eläin ja vastaava eläinkoelupa täytyy kirjata tutkijakohtaisesti. Toteutettava sovellus on tarkoitettu yhden tutkimusryhmän koe-eläinkäytön kirjaamiseen. Järjestelmä pitää kirjaa koe-eläimiä käyttävistä tutkijoista, myönnetyistä koe-eläinluvista sekä lupien alla käytetyistä koe-eläimistä.

Sovelluksen käyttäjä (ensisijaisesti eläinkokeita tekevä tutkija) voi kirjata ja tarkastella tekemiään kokeita. Lisäksi osa käyttäjistä (eläinkoeluvan vastaavat) voivat luoda ja muokata eläinkoelupia sekä luoda lupakohtaisia raportteja eläinten käytöstä. Järjestelmän ylläpitäjä voi luoda uusia käyttäjiä sekä tarvittaessa muokata kaikkia lupia ja kirjattuja kokeita.   

Koe-eläinkirjausjärjestelmä toteutetaan web-sovelluksena. Sovellus toteutetaan PHP-kielellä Helsingin yliopiston tietojenkäsittelytieteen laitoksen users2017.cs.helsinki.fi -palvelimella Apache HTTP-palvelinohjelman ja PostgreSQL tietokannanhallintajärjestelmän avulla. Web-käyttöliittymään saatetaan toteuttaa pieniä käyttäjäystävällisiä lisätoimintoja Javascript-kielellä, mutta sovelluksen pääkäyttö ei tule vaatimaan Javascript-tukea.
