# Tietokantasovelluksen esittelysivu

## Yleisesti

Sovelluksen käyttö edellyttää kirjautumista. Voit kokeilla seuraavia tunnus/salasana-pareja nähdäksesi sovelluksen eri käyttäjien näkökulmasta:

* tutkija / tutkija
* lupavastaava / lupavastaava
* ylläpitäjä / ylläpitäjä

## Yleisiä linkkejä:

* [Linkki sovellukseeni](https://alafuzof.users.cs.helsinki.fi/animal/)
* [Linkki dokumentaatiooni](https://github.com/alafuzof/elainkoekirjanpito/blob/master/doc/dokumentaatio.pdf)

## Toteutetut sivut

Käyttäjäsivujen selailu on nyt esillä vain kirjautuneille käyttäjille. Voit kirjautua test/test (tunnus/salasana) testataksesi toiminnallisuutta.

* [Kirjautuminen](https://alafuzof.users.cs.helsinki.fi/animal/login)
* [Etusivu](https://alafuzof.users.cs.helsinki.fi/animal/)
* [Tarkastele/muokkaa/lisää/poista käyttäjiä](https://alafuzof.users.cs.helsinki.fi/animal/user)
* [Tarkastele/muokkaa/lisää/poista lisenssejä](https://alafuzof.users.cs.helsinki.fi/animal/licence)
* [Tarkastele/muokkaa/lisää/poista kokeita](https://alafuzof.users.cs.helsinki.fi/animal/experiment)


## Työn aihe

Bio- ja lääketieteeen tutkimustyössä tehdään kokeita, joihin käytetään koe-eläimiä. Eläinkokeiden eettisten haasteiden vuoksi niiden tekemistä säädellään ja valvotaan tiukasti. Yksi osa tätä valvontaa on eläinkoekirjanpito, jota jokaisen eläinkokeita tekevän tutkijan on ylläpidettävä: jokainen käytetty eläin ja vastaava eläinkoelupa täytyy kirjata tutkijakohtaisesti. Toteutettava sovellus on tarkoitettu yhden tutkimusryhmän koe-eläinkäytön kirjaamiseen. Järjestelmä pitää kirjaa koe-eläimiä käyttävistä tutkijoista, myönnetyistä koe-eläinluvista sekä lupien alla käytetyistä koe-eläimistä.

Sovelluksen käyttäjä (ensisijaisesti eläinkokeita tekevä tutkija) voi kirjata ja tarkastella tekemiään kokeita. Lisäksi osa käyttäjistä (eläinkoeluvan vastaavat) voivat luoda ja muokata eläinkoelupia sekä luoda lupakohtaisia raportteja eläinten käytöstä. Järjestelmän ylläpitäjä voi luoda uusia käyttäjiä sekä tarvittaessa muokata kaikkia lupia ja kirjattuja kokeita.   

Koe-eläinkirjausjärjestelmä toteutetaan web-sovelluksena. Sovellus toteutetaan PHP-kielellä Helsingin yliopiston tietojenkäsittelytieteen laitoksen users2017.cs.helsinki.fi -palvelimella Apache HTTP-palvelinohjelman ja PostgreSQL tietokannanhallintajärjestelmän avulla. Web-käyttöliittymään saatetaan toteuttaa pieniä käyttäjäystävällisiä lisätoimintoja Javascript-kielellä, mutta sovelluksen pääkäyttö ei tule vaatimaan Javascript-tukea.
