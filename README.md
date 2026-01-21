# Battle Arena (Symfony)

Petit projet Symfony avec :
- inscription + vérification d’email (obligatoire avant login)
- login/logout
- espace admin pour gérer/ajouter des matchs entre utilisateurs existants

---

## Prérequis

- PHP + Composer
- Symfony CLI
- Node.js + npm
- Une base de données
- Un serveur mail

---

## Installation

### 1) Installer les dépendances PHP
```bash
composer install
```

### 2) Installer les dépendances front
```bash
npm install
```

### 3) Créer le fichier .env.local
```bash
DATABASE_URL="mysql://USER:PASSWORD@127.0.0.1:3306/NOM_DB?serverVersion=8.0&charset=utf8mb4"
MAILER_DSN=smtp://USER:PASSWORD@HOST:PORT
MESSENGER_TRANSPORT_DSN=doctrine://default
```

### 4) Créer la base + appliquer les migrations
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 5) (Optionnel) Charger des fixtures
```bash
php bin/console doctrine:fixtures:load
```

### 6) Démarrer le serveur Symfony
```bash
symfony serve
```

### 7) lancer Messenger (obligatoire pour l’envoi des emails)
```bash
php bin/console messenger:consume async -vv
```