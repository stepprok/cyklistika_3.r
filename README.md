# 🚴‍♂️ Cyklistika 3.r – Správa a Přehled Závodu Paříž – Nice

Tato webová aplikace postavená na PHP frameworku **CodeIgniter** slouží k přehledné prezentaci a správě cyklistických závodů se zaměřením na závod **Paříž – Nice (ID 124)**. Umožňuje prohlížet jednotlivé ročníky, etapy, výsledky a spravovat data pomocí administračního rozhraní.

---

## 📋 Přehled funkcí a specifikace

Aplikace splňuje následující funkční požadavky a specifikace úkolů:

### 1. Ročníky závodu
* **UK-01 | Výpis ročníků:** Přehled všech ročníků závodu Paříž – Nice (ID 124) seřazených **od nejnovějšího po nejstarší**.
* **UK-02 | Datum konání:** Zobrazení rozmezí konání závodu pro každý ročník ve formátu `D.M.YYYY - D.M.YYYY`.
* **UK-03 | Celková délka:** Zobrazení celkové délky závodu v km, zaokrouhlené na celá čísla (`ROUND`).

### 2. Detail etapy & Výsledky
* **UK-04 | Výpis etap:** Seznam všech etap v rámci daného ročníku seřazený vzestupně podle pořadí etapy (`1..N`).
* **UK-05 | Údaje o etapě:** Zobrazení kompletních sloupců: datum etapy, délka etapy (km), převýšení (m) a typ etapy.
* **UK-06 | Vítěz etapy:** Zobrazení jména / názvu vítěze etapy v samostatném sloupci.
* **UK-07 | Odkaz na pořadí v etapě:** Dynamické URL odkazující na pořadí v etapě (vazba na tabulku `result` kde `type_result = 1`).
* **UK-08 | Odkaz na pořadí po etapě:** Dynamické URL odkazující na celkové pořadí po etapě (vazba na tabulku `result` kde `type_result = 4`).

### 3. Formulář a Správa (Administrace)
* **UK-09 | Přidání ročníku:** Samostatný formulář/list pro možnost přidávání nového ročníku závodu s poli:
  * Název (`real_name`)
  * ID závodu (`race_id`)
  * Logo závodu (`logo`)
* **UK-10 | Výběr závodu:** Výběr `race_id` pomocí dropdown filtru (omezeno pouze na mužské závody kategorie E přes číselník).

---

## 🛠 Požadavky na prostředí (Prerequisites)

* **PHP:** >= 7.4 (nebo podle konkrétní verze CodeIgniteru 3 / 4)
* **Databáze:** MySQL / MariaDB
* **Webový server:** Apache (s povoleným `mod_rewrite`) nebo Nginx
* **Composer** (pro správu závislostí)

---

## 🚀 Instalace a zprovoznění

1. **Klonování repozitáře:**
   ```bash
   git clone [https://github.com/stepprok/cyklistika_3.r.git](https://github.com/stepprok/cyklistika_3.r.git)
   cd cyklistika_3.r
Instalace závislostí:

composer install
Konfigurace databáze a aplikace:

Zkopírujte konfigurační soubor nebo nastavte přístup k databázi v application/config/database.php (CodeIgniter 3) nebo v souboru .env (CodeIgniter 4).

Nastavte přihlašovací údaje k MySQL databázi:

PHP
'hostname' => 'localhost',
'username' => 'vas_uzivatel',
'password' => 'vase_heslo',
'database' => 'databaze_cyklistika',
Import databáze:

Importujte přiložený SQL dump do vaší MySQL databáze.

Spuštění:

Pokud používáte vestavěný PHP server:

Bash
php -S localhost:8000 -t public
Nebo nastavte virtuální host v XAMPP / WAMP / Apache.

🗄 Databázová struktura (Klíčové tabulky)
race / rocnik: Uchovává ročníky, race_id, real_name, loga a termíny.

stage / etapa: Seznam etap, jejich typy, délky v km a převýšení v m.

result: Výsledková listina:

type_result = 1: Pořadí v etapě.

type_result = 4: Celkové pořadí po etapě.

👤 Autor
GitHub: @stepprok
