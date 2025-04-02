Bonjour,

Pour le bon fonctionnement du site web, avant de lancer l'application il est important d'effectuer la commande "composer install".

Ensuite, il vous faudra modifier la ligne suivante dans le fichier.env comme ceci : "DATABASE_URL="mysql://root:cytech0001@127.0.0.1:3306/College?serverVersion=8.0.41-MariaDB&charset=utf8mb4""

Avec "cytech0001" qui est le mot de passe à modifier selon celui défini sur votre ordinateur.

Une fois ceci fait, vous devrez éxécuter la commande "php bin/console doctrine:database:create" pour pouvoir créer la base de données.

Il faudra également charger les données en éxécutant toutes les migrations "php bin/console doctrine:migrations:migrate" et ensuite "php bin/console doctrine:fixtures:load --append"

Une fois toutes les étapes ci-dessus terminées, vous pouvez lancer l'application en utilisant le serveur de développement Symfony : "symfony server:start -d". Si symfony n'est pas installé sur votre machine, alors vous pouvez lancer un serveur local via php à l'aide de la commande suivante : "php -S 127.0.0.1:8000 -t public".

Accédez à l'application via votre navigateur à l'adresse http://127.0.0.1:8000.

Une fois sur le site, vous pouvez soit vous créer un compte, soit vous connecter à un compte existant avec ces identifiants : email => secretariat@ecole.fr et mot de passe => admin123. Pour passer ce compte en mode administrateur, il vous faudra exécuter deux requêtes sql : bin/console doctrine:query:sql "update utilisateur set niveau=3 where email='secretariat@ecole.fr';" et bin/console doctrine:query:sql "update utilisateur set valide='Validé' where email='secretariat@ecole.fr';"

En ésperant que ce readme vous ait été utile.

Bonne journée.
