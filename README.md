# Vyžaduje PHP 8.1

## Instalace

- spustit `composer install`
- vytvořit **.env** soubor z **.env.example** souboru a nastavit přístupy k databázi
- spustit `php artisan migrate`
- spustit `php artisan server`

## Zpracování csv
- nahrát csv soubor do složky **/storage/app**
- zpracování je možné provést pomocí příkazu `php artisan cronJobs:process {filename}`
  - místo **{filename}** vložit jen název souboru
