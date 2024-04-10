# Álláskeresők Adatbázisa Webalkalmazás

Ez a projekt egy egyszerű álláskeresők adatbázisát kezeli. A webalkalmazás lehetővé teszi új álláskeresők hozzáadását, meglévő adatok szerkesztését és törlését. Az adatokat egy MySQL adatbázis tárolja.

Technológiai összetevők

* **HTML/CSS/JavaScript:** A felhasználói felület megjelenítéséhez és interakciójához.
* **PHP:** A szerveroldali logika és az adatbázis-műveletek kezeléséhez.
* **Bootstrap:** A felhasználói felület gyors és egyszerű formázásához.
* **MySQL adatbázis:** Az álláskeresők adatainak tárolására és kezelésére.

Telepítés

1. **Adatbázis létrehozása:** Importáljuk az emberek_adatbazis.sql fájlt az adatbázisunkba. Ez létrehozza az emberek táblát, ahol tároljuk az álláskeresők adatait.
2. **Webalkalmazás fájljainak elhelyezése:** Másoljuk a projekt fájljait egy olyan könyvtárba, amit a webszerverünk eléri.
3. **Beállítások ellenőrzése:** Nyissuk meg a config.php fájlt, és ellenőrizzük az adatbázis elérési adatait ($servername, $username, $password, $dbname).
4. **Webalkalmazás futtatása:** Nyissuk meg a webböngészőben az alkalmazásunkat a megfelelő URL-en.

Használat

* **Új álláskereső hozzáadása:** Töltsük ki a megfelelő mezőket az űrlapon, majd kattintsunk a "Hozzáadás" gombra.
* **Adatok szerkesztése:** Kattintsunk a "Szerkesztés" gombra a kívánt sorban, majd módosítsuk az adatokat a megjelenő modális ablakban, és kattintsunk a "Mentés" gombra.
* **Álláskereső törlése:** Kattintsunk a "Törlés" gombra a kívánt sorban.
