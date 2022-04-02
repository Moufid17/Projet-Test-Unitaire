# Groupe 5
LUSCAP Sonny, MOUTAROU Mouhammed Moufid Afolabi, Mustakim KHAN

Classe 4IW

Lien GitHub : https://github.com/Sonny00/Projet-Test-Unitaire

### Getting started

```bash
docker-compose build --pull --no-cache
docker-compose up -d
```

```
# URL
http://127.0.0.1

# Env DB
DATABASE_URL="postgresql://postgres:password@db:5432/db?serverVersion=13&charset=utf8"
```

### Exécuter tous les tests avec le docker-compose
```docker-compose exec php bin/phpunit --testdox tests```

### Exécuter les tests un par un le docker-compose (ex: Todolist)
```docker-compose exec php bin/phpunit --testdox tests/ToDoListTest.php```