# WhatsApp Chat Parser

Ein reines JavaScript Tool zum Parsen von WhatsApp Chat-Exports aus Google Drive. Läuft komplett im Browser - kein Server nötig!

## Verwendung

### Option 1: Datei-Upload (empfohlen, funktioniert immer)

1. Öffne `index.html` im Browser (doppelklick oder `file://` URL)
2. Laden Sie die ZIP-Datei von Google Drive herunter
3. Verwenden Sie die "Datei hochladen" Option
4. Klicken Sie auf "Chat export parsen"

### Option 2: Google Drive Link (benötigt PHP)

1. Stellen Sie sicher, dass PHP auf Ihrem Server verfügbar ist
2. Laden Sie `proxy.php` auf den Server hoch
3. Öffnen Sie `index.html` über den Server (nicht als `file://`)
4. Fügen Sie den Google Drive Link ein
5. Klicken Sie auf "Chat export parsen"

**Hinweis:** Die Google Drive Link-Funktion funktioniert nur mit dem PHP-Proxy (`proxy.php`), da Google Drive CORS-Beschränkungen hat.

## Installation (für PHP-Proxy)

1. Stellen Sie sicher, dass PHP installiert ist
2. Kopieren Sie `proxy.php` auf Ihren Webserver
3. Stellen Sie sicher, dass PHP cURL aktiviert ist

## Unterstützte Formate

- **Text Format** (.txt): `[DD.MM.YYYY, HH:MM:SS] Sender: Message`
- **HTML Format** (.html): WhatsApp HTML Export
- **JSON Format** (.json): WhatsApp JSON Export

## Ausgabe

Das Tool zeigt:
- **Statistiken**: Anzahl Nachrichten, Sender, Zeitraum
- **Nachrichten**: Die ersten 100 Nachrichten mit Sender, Zeitstempel und Inhalt

## Keine Installation nötig (für Datei-Upload)!

- Kein Python
- Kein Server (für Datei-Upload)
- Keine Abhängigkeiten
- Funktioniert offline (nach erstem Laden)

Einfach die HTML-Datei öffnen und loslegen!
