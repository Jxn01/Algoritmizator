# Algoritmizátor
[![Algoritmizator Test Pipeline](https://github.com/Jxn01/algoritmizator/actions/workflows/test.yml/badge.svg)](https://github.com/Jxn01/algoritmizator/actions/workflows/test.yml)

Ez a projekt egy webes alkalmazás, amelynek célja, hogy a felhasználók játékos módon tanulhassák meg az algoritmusokat.

## A projekt célja

Az alkalmazás célja, hogy a felhasználók számára élvezetes és interaktív módon tanítsa meg az algoritmusokat. A felhasználók különböző szintű feladatokat oldhatnak meg, amelyek segítenek nekik megérteni és elsajátítani az algoritmusok működését. Minél több feladatot oldanak meg, annál több pontot és szintet érnek el.

## Felhasználói élmény

### Az alkalmazás működése

A felhasználók regisztrálhatnak és bejelentkezhetnek az alkalmazásba. A bejelentkezés után a felhasználók elérhetik a feladatokat, amelyeket megoldhatnak. Minden feladat megoldása után a felhasználók pontokat kapnak, amelyek segítenek nekik a szintlépésben. A szintlépés lehetővé teszi a felhasználók számára, hogy újabb és nehezebb feladatokat oldjanak meg.

### Szintlépési rendszer

A szintlépési rendszer a felhasználók előrehaladását követi. Minél több pontot szereznek a felhasználók, annál magasabb szintre léphetnek. A szintlépés motiválja a felhasználókat, hogy folytassák a tanulást és a fejlődést.

### Hitelesítési és közösségi rendszer

Az alkalmazásban a felhasználók regisztrálhatnak és bejelentkezhetnek. A bejelentkezett felhasználók hozzáférhetnek a profiljukhoz, ahol nyomon követhetik a haladásukat, megtekinthetik a barátaikat és a baráti kéréseiket. A közösségi funkciók lehetővé teszik a felhasználók számára, hogy kapcsolatba lépjenek más felhasználókkal, megosszák a haladásukat és segítséget kérjenek.

## Fejlesztői információk

### Technológiai stack

- Laravel: A backend szerver és az API kiszolgálására használt keretrendszer.
- React: A frontend felhasználói felület készítésére használt könyvtár.
- TailwindCSS: A felhasználói felület stílusának kialakítására használt CSS keretrendszer.
- CodeMirror: A kódszerkesztő funkciók biztosítására használt könyvtár.
- InertiaJS: A Laravel és React közötti sima integráció biztosítására használt könyvtár.
- MySQL: Az adatok tárolására használt adatbázis rendszer.
- Laravel Eloquent ORM: Az adatbázis műveletek egyszerűsítésére használt ORM.

### Tesztelés és monitoring

- PHPUnit: A backend kód tesztelésére használt keretrendszer.
- Laravel Telescope: A backend teljesítményének és állapotának monitorozására használt eszköz.

### Fejlesztői környezet

A fejlesztői környezet beállításához szükséges a következő lépések végrehajtása:

1. Klónozd le a projektet a GitHub repository-ból.
2. Telepítsd a Composer és a NodeJS csomagokat a következő paranccsal:

```bash
composer install
npm install
```

3. Hozz létre egy `.env` fájlt a `.env.example` fájl alapján:

```bash
cp .env.example .env
```

4. Generálj egy alkalmazás kulcsot a következő paranccsal:

```bash
php artisan key:generate
```

5. Állítsd be az adatbázis kapcsolatot és az email szerver konfigurációját a `.env` fájlban:

```bash
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=
```

6. Migráld az adatbázis táblákat a következő paranccsal:

```bash
php artisan migrate
```

7. Állíts be egy cron job-ot a Laravel Task Scheduler futtatásához a következő paranccsal:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

8Indítsd el a Laravel szerver a következő paranccsal:

```bash
php artisan serve
```

9. Indítsd el a React alkalmazást a következő paranccsal:

```bash
npm run dev
```

10. Nyisd meg a böngészőt a `http://localhost:8000` címen.

### Tesztelés

1. A teszt adatbázis beállításához állítsd be a következőket a phpunit.xml fájlban:

```xml
<php>
    <env name="DB_CONNECTION" value="mysql"/>
    <env name="DB_DATABASE" value="algoritmizator_test"/>
    <env name="DB_HOST" value="127.0.0.1"/>
    <env name="DB_PORT" value="3306"/>
    <env name="DB_USERNAME" value=""/>
    <env name="DB_PASSWORD" value=""/>
</php>
```

2. A backend kód teszteléséhez használd a PHPUnit keretrendszert a következő paranccsal:

```bash
php artisan test
```

A Laravel Telescope alkalmazás segítségével monitorozhatod a backend teljesítményét és állapotát a `http://localhost:8000/telescope` címen.

### Üzembehelyezés

Az alkalmazás üzembehelyezéséhez szükséges a következő lépések végrehajtása:

1. Állítsd be az `.env` fájlban az adatbázis kapcsolatot, az email szerver konfigurációját és a környezeti változókat:

```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://example.com

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=
```

2. Állítsd be a Laravel cache és konfigurációs fájlokat a következő paranccsal:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Buildeld le a React alkalmazást a következő paranccsal:

```bash
npm run build
```

4. Állítsd be a React alkalmazást a következő paranccsal:

```bash
npm run prod
```

5. Állítsd be a Laravel szerver konfigurációját a következő paranccsal:

```bash
php artisan serve --host=
```

6. Állítsd be a webkiszolgálót a következőképpen: [Apache](https://httpd.apache.org/), [Nginx](https://www.nginx.com/), [Caddy](https://caddyserver.com/).

Megjegyzések:

- Az alkalmazás üzembehelyezése előtt győződj meg róla, hogy az adatbázis, a webkiszolgáló és az email kiszolgáló megfelelően konfigurálva van.
- Az alkalmazás üzembehelyezése előtt győződj meg róla, hogy a Laravel cache és konfigurációs fájlok frissítve vannak.
- Az alkalmazás frontend része azzal a feltételezéssel lett megírva, hogy a backend és a frontend azonos szerveren futnak, sőt, az index.php fájl az /algoritmizator mappában található. Ez könnyen megvalósítható egy mappahivatkozás létrehozásával.

## Kapcsolat

Ha bármilyen kérdésed vagy észrevételed van az alkalmazással kapcsolatban, kérlek vedd fel a kapcsolatot velem az alábbi email címen:

- Email (inf.elte): [pst8ra@inf.elte.hu](mailto:pst8ra@inf.elte.hu)
- Email (személyes): [jxn.personal@gmail.com](mailto:jxn.personal@gmail.com)
- GitHub: [Jxn01](https://www.github.com/Jxn01)
- LinkedIn: [Jxn01](https://www.linkedin.com/in/jxn01)
