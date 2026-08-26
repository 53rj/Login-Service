# Login Service

Ein einfacher, modular aufgebauter Login-Service mit PHP und MySQL, der langfristig als wiederverwendbarer Baustein für zukünftige Projekte dienen soll.

## Ziel

Der Login-Service soll grundlegende Funktionen zur Benutzerverwaltung unabhängig vom eigentlichen Projekt bereitstellen.
<img width="418" height="427" alt="grafik" src="https://github.com/user-attachments/assets/36a421d6-7a83-4c83-89b7-ee6dae3c2853" />

Aktuell liegt der Fokus auf:

* Registrierung neuer Benutzer
* Login über Username und Passwort
* Speicherung der Benutzer in einer MySQL-Datenbank
* Sicheres Speichern von Passwörtern mit `password_hash()`
* Überprüfung von Passwörtern mit `password_verify()`
* Session-basierte Authentifizierung
* Trennung zwischen Frontend, Authentifizierungslogik und Datenbankzugriff

## Technologien

* HTML
* CSS
* PHP
* MySQL / MariaDB
* PDO
* PHP Sessions

## Projektstruktur

```text
login/
├── frontend/
│   ├── index.html
│   ├── dashboard.php
│   └── style.css
│
└── backend/
    ├── auth.php
    ├── db.php
    ├── login_failed.php
    ├── login.php
    ├── logout.php
    └── reg_new_user.php  
```

Die Struktur kann sich während der weiteren Entwicklung noch ändern.

## Datenbank

Beispiel für die aktuelle `users`-Tabelle:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
```

Passwörter werden nicht im Klartext gespeichert.

Beim Registrieren:

```php
$passwordHash = password_hash($password, PASSWORD_DEFAULT);
```

Beim Login:

```php
password_verify($password, $user['password']);
```

## Datenbankverbindung

Die Verbindung zur Datenbank wird zentral über `backend/db.php` hergestellt.

Beispiel:

```php
$pdo = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $dbUser,
    $dbPassword
);
```

Für MySQL muss die PHP-Erweiterung `pdo_mysql` aktiviert sein.

## Geplante Erweiterungen

Der Service soll zukünftig unter anderem erweitert werden um:

* [ ] Validierung von Registrierungsdaten
* [ ] Passwort-Richtlinien
* [ ] Passwort bestätigen bei Registrierung
* [ ] E-Mail-Adressen für Benutzer
* [ ] Passwort vergessen / Passwort zurücksetzen
* [ ] E-Mail-Verifizierung
* [ ] Rollen und Berechtigungen
* [ ] Verbesserte Session-Verwaltung
* [ ] Schutz vor Session Fixation
* [ ] CSRF-Schutz
* [ ] Rate Limiting für Login-Versuche
* [ ] Account-Sperre nach mehreren Fehlversuchen
* [ ] Remember-Me-Funktion
* [ ] Benutzerverwaltung
* [ ] Konfiguration über `.env`
* [ ] Trennung von Konfiguration und Quellcode
* [ ] Wiederverwendbare Auth-Middleware
* [ ] API-Unterstützung
* [ ] Einheitliche Fehlerbehandlung

## Langfristiges Ziel

Der Login-Service soll möglichst unabhängig von einem konkreten Projekt funktionieren.

Neue Anwendungen sollen die Authentifizierung später mit möglichst wenig zusätzlichem Code übernehmen können.

Beispielsweise:

```php
require '../backend/auth.php';
```

auf einer geschützten Seite, um sicherzustellen, dass nur angemeldete Benutzer Zugriff erhalten.

Langfristig soll daraus ein kleiner wiederverwendbarer Authentication-Baustein entstehen, der sich unkompliziert in zukünftige PHP-Projekte integrieren lässt.

## Status

**Work in Progress**

Der Service befindet sich aktuell in der Entwicklung und ist noch nicht für den produktiven Einsatz vorgesehen.
