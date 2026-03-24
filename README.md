1. Configuration du Back-End (Symfony)
- Lancé xamp

Commandes terminal :
- composer install

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

Lancement du serveur :
-symfony serve

2. Configuration du Front

Commandes terminal :
- cd hexavia-front
- npm install
- npm run dev

3. Importation des données (Base de données)

- Lancez XAMPP (Apache & MySQL)
- Allez sur phpMyAdmin
- Créez une nouvelle base de données (nommée sae401)
- Cliquez sur l'onglet Importer
- Choisissez le fichier situé dans : `/database/backup_db.sql`
