👋

Aujourd'hui on va pouvoir attaquer le back... 😄


> ℹ️ Avant de commencer, n'oublie pas de récupérer les dernieres modification du Github 😉


---


Symfony intègre un système de connexion aux bases de données assez performant : Doctrine.

> **Définition Wikipédia 🤓**
>
> Un mapping objet-relationnel (en anglais object-relational mapping ou ORM) est un type de programme informatique qui se place en interface entre un programme applicatif et une base de données relationnelle pour simuler une base de données orientée objet. Ce programme définit des correspondances entre les schémas de la base de données et les classes du programme applicatif. On pourrait le désigner par là « comme une couche d'abstraction entre le monde objet et monde relationnel ». Du fait de sa fonction, on retrouve ce type de programme dans un grand nombre de frameworks sous la forme de composant ORM qui a été soit développé, soit intégré depuis une solution externe. 
> [Wikipédia](https://fr.wikipedia.org/wiki/Mapping_objet-relationnel)

La base de données est déjà configurée avec les identifiants suivants :

| type | value  
|:-    |:-
| database | innov
| user     | innov
| pwd      | t7bd9eBPmzf6UwT4SGnvrAFXDVcypQHR

## Configurer la base de données

Le fichier .env est un fichier de configuration qui permet de stocker des informations sensibles de l'application notamment les informations de connexion.

Tu trouveras ce fichier a la racine du projet 😋

Ce fichier ne doit **JAMAIS** être inclus dans le code source (c'est pour cela qu'il est ajouté dans le [.gitignore (tu peux te renseigner la dessus, c'est toujours bon à savoir)](https://git-scm.com/docs/gitignore).

Pour configurer la connexion à la base de données dans Symfony, il suffit d'ajouter la ligne suivante au fichier .env :

```
DATABASE_URL=mysql://username:password@host:port/dbname
```

Remplace username, password, host, port et dbname par les informations de connexion à la base de données.

__Exemple:__
```
DATABASE_URL=mysql://root:password@127.0.0.1:3306/ma_base_de_donnees?charset=utf8mb4
```

Une fois défini, le meilleur moyen de tester la base de données est d'exécuter  :
```
$ php bin/console doctrine:database:create
```

## Utiliser la base de données

### Créer la base de données

On l'a déjà  fait :
```
$ php bin/console doctrine:database:create
```

> Si tu veux supprimer la base de données, tu peux exécuter :
> ```
> $ php bin/console doctrine:database:drop
> ```

### Créer une table/une entité

Une entité (en symfony) est une classe PHP qui représente une table d'une base de données.
Tu peux regarder les entités qui existent déjà dans `src/Entity/`

Les psychopathes écrivent le code des entités, nous, on va se simplifier la vie :
```
$ php bin/console make:entity
```
Avec cette commande, tu peux rapidement créer une entité, ces champs et les relations qui vont avec.

### Les migrations

Une fois les entités créées, on veut les appliquer à la base de données et pour cela, on crée une migration :
```
$ php bin/console make:migration
```

Tu peux regarder le résultat de ton tour de magie dans `migrations/`
Oui, c'est bien du SQL qui est généré et qui va être exécuté :)

Enfin, si tu veux exécuter ta migration : 
```
$ php bin/console doctrine:migrations:migrate
```

## Prêt ?

### 1. Initie la base de données

Avec ce qui est vu précédemment :
- Réalise la configuration nécessaire et crée la base de données
- Crée une entité `Role` avec les champs suivants : 
    | nom | type
    |:-    |:-
    | account_id | relation avec `Account`
    | role       | string (par défaut  `default`)
- Mets à jour la base de données avec tes modifications


### 2. Gère l'authentification et la création de compte

Si tu ouvres la page [https://code.appfe.fr:8000/login](https://code.appfe.fr:8000/login) et que tu te connectes, tu devrais automatiquement arriver sur la page 
`/account` t'affichant le détail de ton compte (fourni par l'authentification Microsoft)

Le comportement attendu lors d'une connexion est : 
- Si le compte existe (valeur oid présente en base de données)
    - Enregistrer la connexion en base de données (Table / Entité `Login`)
    - Créer une session (avec les droits de l'utilisateur)
    
- Si l'utilisateur est inconnu au bataillon
    - Vérifier que le compte appartient bien à l'association*
    - Créer un compte à l'utilisateur (Table / Entité `Account`)
    - Donner à l'utilisateur le rôle 'default'  (Table / Entité `Role`)
    - Enregistrer la connexion en base de données (Table / Entité `Login`)
    - Créer une session (avec les droits de l'utilisateur)

*[Microsoft Entra | ID token claims reference](https://learn.microsoft.com/en-us/entra/identity-platform/id-token-claims-reference) - Id de l'association : 925cbcb1-acb5-4e6b-8b05-239caec02a3f


---


### Quelques exemples qui te seront utiles :

```
Enregistrer un 'produit' dans la base de données :

class ProductController extends AbstractController
{
    #[Route('/product', name: 'create_product')]
    public function createProduct(EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }
}
```
https://symfony.com/doc/current/doctrine.html#persisting-objects-to-the-database


```
Créer une fonction de recherche dans la base de données :

public function findOneByMSOID($value): ?Account
{
    return $this->createQueryBuilder('a')
        ->andWhere('a.ms_oid = :val')
        ->setParameter('val', $value)
        ->getQuery()
        ->getOneOrNullResult();
}

$this->accountRepository->findOneByMSOID( $value );
```
AccountRepository.php


---

### Besoin d'aide ?

Quelque chose ne fonctionne pas ? Cette commande pourrait t'aider :
```
php bin/console cache:clear
```
*Ce n'est pas magique, mais dès fois, ça aide bien* 😅

---

### Pour en lire un peu plus
>
> - https://git-scm.com/docs/gitignore
> - https://symfony.com/doc/current/doctrine.html
> - https://github.com/TheNetworg/oauth2-azure
> - https://learn.microsoft.com/en-us/entra/identity-platform/
> - https://learn.microsoft.com/en-us/entra/identity-platform/id-token-claims-reference
