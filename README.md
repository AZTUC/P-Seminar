# Drohnensteuerung – Escape Room

Dieses Projekt ist Teil eines P-Seminars im Fach Mathematik und stellt ein digitales Escape-Room-Rätsel für Schüler:innen der 6. Jahrgangsstufe dar.  
Ziel ist es, eine Drohne durch ein Koordinatensystem zu steuern, Hindernissen auszuweichen und das Ziel zu erreichen.  
Bei Erfolg erhalten die Gruppen individuelle Hinweise zur Lösung des Falls.

## Projektüberblick

Die Drohne startet an einer festen Position (9,9) und muss durch eine Reihe von Befehlen gesteuert werden.  
Dabei dürfen keine Hindernisse berührt oder der Akku (maximale Distanz von 11m) überschritten werden.  
Die Gruppe gibt über ein Webformular die Bewegungen in 0.5 Metern und Richtungen ein. Das PHP-Skript prüft automatisch den Pfad und gibt entsprechende Rückmeldung.

## Dateien

- `LICENSE` - Standard GNU Lizenz
- `index.html` – Eingabeseite im Browser (Startseite für die Schüler)
- `drohne.php` – PHP-Auswertung der Bewegungen, Zielkontrolle, Hindernisprüfung, Rückmeldung
- `README.md` – Diese Anleitung

## Voraussetzungen

Zum nachträglichen Ausführen des Projekts wird ein lokaler Webserver benötigt:

- [XAMPP](https://www.apachefriends.org/index.html) (Windows/macOS/Linux)
- oder [MAMP](https://www.mamp.info/) (speziell für macOS)

Ein moderner Browser (Chrome, Firefox, Edge, Safari...) wird ebenfalls benötigt.

## Installation

```plaintext
1. Download oder Klonen des Projekts:

   git clone https://github.com/DEINNUTZERNAME/drohnen-escape.git

2. Ablage im Webserver-Verzeichnis, z. B.:

   Bei XAMPP: C:/xampp/htdocs/drohne
   Bei MAMP:  /Applications/MAMP/htdocs/drohne

3. Apache starten
   (über das jeweilige Kontrollfenster von XAMPP oder MAMP)

4. Aufruf im Browser:

   http://localhost/drohne/index.html
```

## Bedienung

1. Die Schüler:innen geben eine Schrittfolge ein: Streckenlänge (in Metern) und Richtung.
2. Zusätzlich wählen sie ihre Gruppennummer (1–7).
3. Das System prüft automatisch:
   - Berührung von Hindernissen (detailliert geprüft in Zwischenpunkten)
   - Akkureichweite (max. 11 m)
   - Zielgenauigkeit (Zielpunkt muss erreicht werden)
4. Wenn alle Bedingungen erfüllt sind, erscheint ein Gruppenhinweis.
5. Bei Fehlern wird die genaue Ursache angezeigt (z. B. Hindernisposition, Ziel nicht erreicht, Akku leer).

## Hinweise bearbeiten

Die Texte der Hinweise für jede Gruppe findest du im unteren Bereich von `drohne.php`:

```php
$groupHints = [
    "1" => "Herr Tröger hat ein Alibi, er ist nicht der Täter.",
    "2" => "Der Täter unterrichtet nicht Wirtschaft.",
    ...
];
```

Diese Einträge kannst du direkt anpassen oder erweitern.

## Fehlerbehandlung

Das Skript prüft automatisch auf:

- ungültige Richtungseingaben
- Ungleichheit von Richtungs- und Meterangaben
- Kollision mit Hindernissen
- zu lange Strecken
- Nichterreichen des Ziels

Alle Fehlermeldungen werden verständlich mit konkreten Koordinaten angezeigt.


## Lizenz

Siehe LICENSE

