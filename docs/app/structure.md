- **app/**: Contient le code source de l'application Laravel.

  - **Console**: Commandes Artisan personnalisées.

  - **Exceptions/**: Classes d'exceptions personnalisées.
    - **Handler.php**: Gère les exceptions et les redirige vers les classes d'exceptions personnalisées appropriées.

  - **Http/**: Le cœur de l'application, contient les contrôleurs, les middlewares, les FormRequest, etc..
  
    - **Controllers/**: Ce répertoire contient les contrôleurs de l'application. Les contrôleurs agissent comme des intermédiaires entre les routes de l'application et la logique métier. Ils traitent les requêtes entrantes, interagissent avec les requests et les services appropriés, puis renvoient les réponses aux clients. Les contrôleurs sont chargés de gérer la logique d'application spécifique à chaque route, telles que l'`authentification`, la `validation des données`, `l'accès aux ressources` et la `génération de réponses` appropriées.
  
      - **API/**: Ce répertoire spécifique contient les contrôleurs destinés à gérer les requêtes API de l'application. Ces contrôleurs sont responsables de la logique métier liée aux endpoints de l'API, tels que la récupération, la création, la mise à jour et la suppression de ressources via des API. Ils peuvent également être chargés de valider les données d'entrée, d'authentifier les utilisateurs et de contrôler les autorisations d'accès aux ressources. En résumé, les contrôleurs API servent de pont entre les requêtes HTTP entrantes et la logique métier de l'application pour fournir des réponses appropriées aux clients de l'`API`.

        - **RESTful/**: Ce répertoire est spécifiquement dédié à la mise en œuvre des contrôleurs API suivant le style architectural `RESTful`. Les contrôleurs RESTful sont conçus pour répondre aux normes et conventions de conception REST, offrant des opérations CRUD (`Create`, `Read`, `Update`, `Delete`) sur les ressources de l'application via des `endpoints HTTP` correspondants (`GET`, `POST`, `PUT`, `PATCH`, `DELETE`). Chaque contrôleur dans ce répertoire est généralement associé à une ressource spécifique de l'application et est responsable de manipuler les requêtes et les réponses pour cette ressource particulière. Ils fournissent une interface uniforme et prévisible pour interagir avec les données de l'application via l'`API`, simplifiant ainsi le développement et l'intégration des clients.

          - **V1/**: Ce répertoire contient les contrôleurs API qui implémentent les versions de l'API de niveau 1 (`V1`). Les contrôleurs situés ici fournissent des fonctionnalités conformes aux spécifications de la version 1 de l'`API RESTful` de l'application. Chaque contrôleur est conçu pour gérer les requêtes et les réponses liées à une ressource spécifique de l'application selon les principes de l'architecture REST. La structuration par version permet de gérer les changements et les évolutions de l'API de manière organisée, garantissant une cohérence et une compatibilité avec les clients existants tout en permettant le développement de nouvelles fonctionnalités.

            - **Auths/**: Ce répertoire contient les contrôleurs API liés à l'authentification. Chaque contrôleur est dédié à une fonctionnalité spécifique liée à l'authentification dans le contexte de l'API RESTful de niveau 1 (V1) de l'application.

              - **AuthController.php**: Fournit des fonctionnalités essentielles pour la gestion de l'authentification des utilisateurs, notamment la récupération des informations utilisateur, la déconnexion des utilisateurs et la destruction des sessions authentifiées.

              - **LoginController.php**: Fournit la fonctionnalité de connexion des utilisateurs et l'émission de jetons dans l'API, garantissant une authentification sécurisée et un contrôle d'accès.

              - **ChangePasswordController.php**: Ce contrôleur gère les demandes de modification de mot de passe des utilisateurs.

            - **Finances/**: Les contrôleurs du module Finances de l'application sont chargés de gérer toutes les fonctionnalités liées à la gestion financière de l'entreprise. Chaque contrôleur est dédié à une tâche spécifique, depuis la gestion des catégories de comptes jusqu'à la gestion des projets de production. Ensemble, ces contrôleurs fournissent une interface pour interagir avec les données financières, en permettant la création, la modification, et la suppression de divers éléments tels que les comptes, les périodes d'exercice, les devises, etc. De plus, ils facilitent le suivi des transactions financières, l'enregistrement des journaux comptables, et la gestion des immobilisations de l'entreprise. En résumé, les contrôleurs du module Finances jouent un rôle crucial dans la gestion efficace des ressources financières de l'entreprise, offrant une structure organisée pour gérer les opérations comptables et financières.

            - **PermissionController.php**: 

            - **RoleController.php**: 

              >
              > ### RoleController.php
              >    ```php
              >
              >     <?php
              >
              >     declare(strict_types = 1);
              >
              >     namespace App\Http\Controllers\API\RESTful\V1;
              >
              >     use App\Http\Requests\Roles\v1\CreateRoleRequest;
              >     use App\Http\Requests\Roles\v1\UpdateRoleRequest;
              >     use Core\Utils\Controllers\RESTful\RESTfulResourceController;
              >     use Domains\Role\Services\RESTful\Contracts\RoleRESTfulQueryServiceContract;
              >     use Domains\Role\Services\RESTful\Contracts\RoleRESTfulReadWriteServiceContract;
              >     use Illuminate\Http\Request;
              >
              >     /**
              >      * **`RoleController`**
              >      * Controller for managing role resources. This controller extends the 
              >      * RESTfulController and provides CRUD operations for role resources.
              >      * 
              >      * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
              >      */
              >     class RoleController extends RESTfulResourceController
              >     {
              >
              >        /**
              >         * Create a new RoleController instance.
              >         * 
              >         * @param RoleRESTfulReadWriteServiceContract $roleRESTfulReadWriteService
              >         *        The Role RESTful Read-Write Service instance.
              >         * 
              >         * @param RoleRESTfulQueryServiceContract $roleRESTfulQueryService
              >         *        The Role RESTful Query Service instance.
              >         * 
              >         * @return @void
              >         */
              >         public function __construct(
              >             RoleRESTfulReadWriteServiceContract $roleRESTfulReadWriteService, 
              >             RoleRESTfulQueryServiceContract $roleRESTfulQueryService
              >         )
              >             parent::__construct(
              >                 $roleRESTfulReadWriteService,
              >                 $$roleRESTfulQueryService
              >             );
              >             // Set specific request classes for store and update methods
              >             $this->setRequestClass('store', CreateRoleRequest::class);
              >             $this->setRequestClass('update', UpdateRoleRequest::class);
              >         }
              >
              >         /**
              >          * Determine if the user is authorized to make this request.
              >          */
              >         public function isAuthorize(): bool
              >         {
              >             return true;
              >         }
              >
              >         /**
              >          *  Authoroze whether or not if the user can execute the action
              >          */
              >         public function authorize(): bool
              >         {
              >             return parent::authorize();
              >         }
              >     }
              >

            - **UserController.php**: 
  
      - **Controller.php**: Le fichier Controller.php dans le répertoire Http/Controllers/ de Laravel sert de classe de base pour les contrôleurs, centralisant le code commun et permettant la personnalisation du comportement global de l'application.
  
    - **Middleware/**: Le répertoire `Middleware/` contient les middlewares de l'application. Les middlewares sont des classes intermédiaires qui peuvent traiter les requêtes HTTP entrantes avant qu'elles n'atteignent les routes de l'application ou les contrôleurs. Ils peuvent également agir sur les réponses HTTP sortantes avant qu'elles ne soient renvoyées au client.

    > A titre illustrative prenons le cas du middleware `PermissionMiddleware.php`
    > Le fichier `PermissionMiddleware.php` dans le répertoire `Middleware/` représente un middleware spécifique conçu pour gérer la vérification des autorisations d'accès aux ressources de l'application. Son rôle est crucial dans la sécurisation des endpoints et dans le contrôle de l'accès aux fonctionnalités sensibles de l'application.
  
    - **Requests/**: Le répertoire `Requests/` contient un ensemble de fichier de classes de requêtes HTTP qui encapsulent la logique de validation des requêtes HTTP entrantes dans l'application. Ces classes sont utilisées pour traiter les requêtes d'API ou les soumissions de formulaires en vérifiant la validité des données fournies par l'utilisateur. Chaque classe de requête représente un type spécifique d'action ou de ressource de l'application. Par exemple, les classes `CreateRoleRequest` et `UpdateRoleRequest` traitent respectivement les requêtes de création et de mise à jour de rôles. Elles étendent respectivement les form requests classes personnalisées de base et ajoutent des règles de validation personnalisées ainsi que des autorisations d'accès.
    >
    >    ```php
    >
    >     <?php
    >
    >     declare(strict_types = 1);
    >
    >     namespace App\Http\Requests;
    >
    >     use Core\Utils\Requests\CreateResourceRequest;
    >     use Domains\Roles\DataTransfertObjects\CreateRoleDTO;
    >
    >     class CreateRoleRequest extends CreateResourceRequest
    >     {
    >         public function __construct(){
    >             parent::__construct(CreateRoleDTO::fromRequest(request()));
    >         }
    >
    >         /**
    >          * Determine if the user is authorized to make this request.
    >          */
    >         public function isAuthorize(): bool
    >         {
    >             return true;
    >         }
    >
    >         /**
    >          *  Authoroze whether or not if the user can execute the action
    >          */
    >         public function authorize(): bool
    >         {
    >             return parent::authorize();
    >         }
    >     }
    >
  
      - **Finances/**: Contient les form request personnalisées spécifiques aux modules finances.
  
      - **ResourceRequest.php**: est un Form Request personnalisé pour etre utilise generalement.
  
    - **Resources/**: Le répertoire `Resources/` dans `Http/` contient les ressources de l'API utilisées pour formater et transformer les données avant de les renvoyer en réponse à des requêtes HTTP liées aux modules de l'application.
  
      - **API/PaginateResource.php**: Ce fichier contient une classe nommée `PaginateResource` qui représente une ressource de pagination pour les API. Cette classe est utilisée pour formater les réponses paginées des API de l'application offrant une sortie cohérente et structurée des données paginées pour faciliter la consommation de l'API par les clients. Elle étend la classe `JsonResource` de Laravel.

      - **Finances/**: Ce répertoire contient les ressources API utilisées pour formater et transformer les données avant de les renvoyer en réponse à des requêtes HTTP liées au module finance.
  
    - **Kernel.php**: Le fichier Kernel.php joue un rôle central dans la gestion des middlewares HTTP de l'application Laravel, permettant de définir les middlewares globaux, de groupe et de route, contrôlant ainsi le flux des requêtes HTTP à travers l'application.

  - **Jobs/**: Jobs pour les tâches en arrière-plan de l'application.

  - **Imports/**: Ce répertoire contient les fonctionnalités d'importation de données dans l'application. Plus précisément, il s'agit d'un espace dédié au traitement des fichiers `Excel` et à leur conversion en données exploitables par l'application.

  - **Models/**: Le répertoire `Models/` contient les modèles Eloquent, qui sont des représentations des données de la base de données utilisées par l'application Laravel, permettant ainsi de manipuler ces données de manière orientée objet.
    > ### Role
    >
    >    ```php
    >
    >    <?php
    >
    >    declare(strict_types = 1);
    >
    >    namespace App\Models;
    >
    >    use Core\Data\Eloquent\Contract\ModelContract;
    >    use Core\Utils\Helpers\Sluggable\HasSlug;
    >
    >    /**
    >     * Class ***`Role`***
    >     *
    >     * This model represents the `roles` table in the database.
    >     * that interact with an Eloquent model.
    >     * It extends the `ModelContract` class and provides access to the database table 
    >     * associated with the model.The attributes that should be treated as dates.
    >     *
    >     * @property  string    $id;
    >     * @property  string    $name;
    >     * @property  string    $slug;
    >     * @property  string    $key;
    >     * @property  string    $description;
    >     * @property  bool      $status;
    >     * @property  string    $created_at;
    >     * @property  string    $updated_at;
    >     * @property  string    $deleted_at;
    >     *
    >     * @package ***`\App\Models`***
    >     */
    >    class Role extends ModelContract
    >    {
    >        use HasSlug, HasPermissions;
    >         
    >         /**
    >          * The database connection that should be used by the model.
    >          *
    >          * @var string
    >          */
    >         protected $connection = "pgsql";
    >         
    >         /**
    >          * The table associated with the model.
    >          *
    >          * @var string
    >          */
    >         protected $table = "roles";
    >         
    >         /**
    >          * The attributes that aren't mass assignable.
    >          *
    >          * @var array<int, string>
    >          */
    >         protected $guarded = [
    >             "slug", "key"
    >         ];
    >         
    >         /**
    >          * The attributes that are mass assignable.
    >          *
    >          * @var array<int, string>
    >          */
    >         protected $fillable = [
    >             "name", "slug", "key", "description"
    >         ];
    >         
    >         /**
    >          * The attributes that should be hidden for arrays.
    >          *
    >          * @var array<int, string>
    >          */
    >         protected $hidden = [
    >             "key"
    >         ];
    >         
    >         /**
    >          * The attributes that should be visible in arrays.
    >          *
    >          * @var array<int, string>
    >          */
    >         protected $visible = [
    >             "name", "slug", "description"
    >         ];
    >         
    >         /**
    >          * The accessors to append to the model's array and JSON representation.
    >          *
    >          * @var array<int, string>
    >          */
    >         protected $appends = [
    >             ///"description"
    >         ];
    >         
    >         /**
    >          * The attributes that should be cast to native types.
    >          *
    >          * @var array<string, string>
    >          */
    >         protected $casts = [
    >             "name"          => "string",
    >             "slug"          => "string",
    >             "key"           => "string",
    >             "description"   => "string"
    >         ];
    >         
    >         /**
    >          * The attributes that should be treated as dates.
    >          *
    >          * @var array<int, string>
    >          */
    >         protected $dates = [
    >             ///"created_at"
    >         ];
    >         
    >         /**
    >          * The model's default attribute values.
    >          *
    >          * @var array<string, mixed>
    >          */
    >         protected $attributes = [
    >             //"description"   => "description",
    >         ];
    >         
    >         /**
    >          * The relationships that should always be loaded.
    >          *
    >          * @var array<int, string>
    >          */
    >         protected $with = [
    >             "permissions"
    >         ];
    >         
    >        /**
    >         * The "boot" method of the model.
    >         * 
    >         *  @return void
    >         */
    >        protected static function boot(): void
    >        {
    >            parent::boot();
    >        }
    >         
    >        /**
    >         * The "booted" method of the model.
    >         * 
    >         *  @return void
    >         */
    >        protected static function booted(): void
    >        {
    >            parent::booted();
    >        }
    >         
    >        /**
    >         * `Role` constructor.
    >         * 
    >         *  @param array $attributes .
    >         */
    >        public function __construct(array $attributes){
    >            parent::__construct($attributes);
    >        }
    >    }
    >

  - **Observers/**: Observateurs de modèles pour écouter les événements de base de données.

  - **Providers/**: Fournisseurs de services personnalisés pour l'application.

      - **AppServiceProvider.php**: Dans le fichier `AppServiceProvider.php`, vous trouverez le fournisseur de services clé de l'application Laravel. Ce fichier joue un rôle central dans l'amorçage initial de l'application, où il s'occupe de tâches vitales telles que l'enregistrement des liaisons et des fournisseurs de services. En liant différentes implémentations à leurs interfaces respectives, ce fournisseur de services facilite grandement l'injection de dépendances, favorisant ainsi l'utilisation généralisée des interfaces dans toute l'application. En somme, il assure une configuration fluide du conteneur de services de l'application, ce qui est essentiel pour son bon fonctionnement.
      > 
      > - **Binding des Contrats de DTO et Controller** :
      >   - Binds `DTOInterface` to `BaseDTO`.
      >   - Binds `RESTfulResourceControllerContract` to `RESTfulResourceController`.
      >
      > - **Binding des Repository Contracts** :
      >   - Binds `ReadOnlyRepositoryInterface` to `EloquentReadOnlyRepository`.
      >   - Binds `ReadWriteRepositoryInterface` to `EloquentReadWriteRepository`.
      >
      > - **Binding Services Contracts** :
      >   - Binds `QueryServiceContract` to `QueryService` qui dépend de `ReadOnlyRepositoryInterface`.
      >   - Binds `ReadWriteServiceContract` to `ReadWriteService` qui dépend de `ReadWriteRepositoryInterface`.
      >
      >   - Binds `RestJsonQueryServiceContract` to `RestJsonQueryService` qui utilise internement `QueryService`.
      >   - Binds `RestJsonReadWriteServiceContract` to `RestJsonReadWriteService` qui utilise internement de `ReadWriteService`.
      >
      > - **Règle de Validation Personnalisée** :
      > Définit une règle de validation personnalisée nommée `'unique_ignore_case'`, permettant la validation d'unicité insensible à la casse dans la base de données.

      - **AuthServiceProvider.php**: Ce fournisseur de services est responsable de la configuration et de l'enregistrement des services d'authentification, notamment la définition des gardes(`guard`), des politiques, et toute autre fonctionnalité liée à l'authentification. 

        Voici quelques détails supplémentaires sur son fonctionnement :

        - **Définition des gardes (`guards`)** : Ce fichier permet de spécifier quel type de garde sera utilisé pour l'authentification des utilisateurs. Les gardes déterminent comment les utilisateurs sont authentifiés et comment leurs informations d'identification sont vérifiées.

        - **Définition des politiques (`policies`)** : Il permet également de mapper les modèles aux politiques correspondantes. Les politiques définissent les autorisations associées à chaque modèle, contrôlant ainsi l'accès aux ressources en fonction des rôles et des permissions des utilisateurs.
        
        - **Configuration de Passport** : En plus de la gestion de l'authentification traditionnelle, ce fichier peut être utilisé pour configurer Laravel Passport, qui est une bibliothèque permettant de mettre en place un serveur OAuth2. Passport permet d'émettre des jetons d'accès sécurisés pour l'authentification API et la gestion des accès.
        
        - **Expiration des jetons d'accès** : Il permet de définir la durée de validité des jetons d'accès et des jetons de rafraîchissement, contrôlant ainsi la sécurité et la durée de connexion des utilisateurs.

      - **BroadcastServiceProvider.php**: Ce fournisseur de services enregistre les services de diffusion utilisés pour la diffusion d'événements en temps réel dans l'application, tels que `Pusher` ou `Redis`.

      - **EventServiceProvider.php**: Ce fournisseur de services est utilisé pour enregistrer les écouteurs d'événements(`events`) et les abonnés(`listeners`). Il est responsable de la mise en correspondance des événements(`events`) avec leurs écouteurs ou abonnés (`listeners`).

      - **ModulesServiceProvider.php**: Ce fournisseur de services pourrait être utilisé pour enregistrer des modules ou des fonctionnalités modulaires dans l'application. Il pourrait gérer des tâches liées à l'enregistrement de modules, à la configuration ou à l'amorçage.
      - Le fichier ModulesServiceProvider.php joue un rôle crucial dans l'enregistrement des services liés aux différents modules ou des fonctionnalités modulaires de l'application. Voici une description détaillée de son fonctionnement :

        - **Enregistrement des services** : Le fournisseur de services enregistre les différentes implémentations des contrats de service pour chaque module de l'application. Il utilise la méthode `bind()` pour lier chaque contrat à son implémentation correspondante.

        - **Services RESTful** : Les services RESTful sont enregistrés pour chaque module, ce qui permet d'interagir avec les ressources du module via des `API REST`. Pour chaque service `RESTful`, le fournisseur de services résout les dépendances nécessaires et crée une instance du service correspondant.

        - **Résolution de dépendances** : Les dépendances requises pour chaque service sont résolues en utilisant le conteneur de services de Laravel. Cela garantit que chaque service a accès aux fonctionnalités nécessaires pour interagir avec la base de données ou d'autres services.

        - **Gestion des opérations CRUD** : Les services enregistrés sont responsables de la gestion des opérations CRUD (`Create`, `Read`, `Update`, `Delete`, etc.) sur les ressources associées à chaque module. Cela inclut la création, la lecture, la mise à jour la suppression des données, etc.

        - **Utilisation du Repository Design Pattern** : Les services reposent sur le repository design pattern de conception pour encapsuler l'accès aux données. Cela permet de séparer la logique métier de l'accès aux données, ce qui rend le code plus modulaire et facile à maintenir.

      - **QueryBuilderServiceProvider.php**: Ce fournisseur de services enrichit les capacités du générateur de requêtes Eloquent en introduisant des macros personnalisées. Ces macros offrent des fonctionnalités supplémentaires au générateur de requêtes Eloquent, simplifiant ainsi la manipulation des données au sein de l'application.

      - **RouteServiceProvider.php**: Le fichier `RouteServiceProvider.php` est un composant essentiel de l'infrastructure de routage de Laravel.

  - **Rules/**: Règles de validation personnalisées pour les requetes entrants.
   
- **bootstrap/**: Ce répertoire contient les fichiers permettant de charger l'application Laravel et de démarrer l'application Laravel.

- **core/**: Ce répertoire contient les composants essentiels et reutilisable de l'application, notamment ceux liés à la gestion et à la manipulation des données. Ainsi que  ceux lies a la logique metier qui alimentent votre application.

  - **Data/**: Ce dossier contient différentes composantes liées à la manipulation des données, y compris des classes pour travailler avec notre ORM Eloquent, des interfaces pour définir les contrats des modeles Eloquent, et des implémentations concrètes de ces derniers.

    - **Eloquent/**:
      - **Casts/**: Contient des classes pour la conversion de types de données personnalisées dans les modèles Eloquent.

      - **Contract/**: Contient la classe `ModelContract` est une classe de modèle de base pour tous les modèles de l'application. Elle étend la classe de modèle Eloquent de Laravel et fournit des fonctionnalités et des caractéristiques supplémentaires.
      
        - **ModelContract.php**: La classe ModelContract sert de modèle de base pour tous les modèles de l'application. Elle étend la classe Model d'Eloquent de Laravel et offre des fonctionnalités supplémentaires et des caractéristiques specifiques.
          
          > Elle fournit des fonctionnalités telles que la gestion des usines (factory) avec HasFactory, la gestion des UUID avec HasUuids, et la prise en charge de la suppression logique avec SoftDeletes. De plus, elle implémente des fonctionnalités personnalisées telles que la gestion de l'identifiant du créateur avec HasCreator.

      - **Observers/**: Contient l'observer de base dont doit heriter toutes les autres classes d'observers

      - **ORMs/**:
      - **Scopes/**: le répertoire Scopes est utilisé pour stocker des classes qui définissent des `scopes` pour les queries modèle. Les `scopes` permettent de définir des clauses de query réutilisables qui peuvent être appliquées à un query model pour filtrer les résultats en fonction de certains critères prédéfinis. Par exemple, un `scope` peut être utilisé pour filtrer les enregistrements en fonction de leur statut actif ou inactif.
      - **ValueObjects/**: Contient des fichiers de classe qui représentent des valeurs immuables et sont utilisées pour encapsuler des données. Les `Value Objects` sont des classes qui représentent des valeurs immuables et sont utilisées pour encapsuler des données. Contrairement aux objets entités qui représentent des objets avec une identité unique et mutable, les `Value Objects` représentent des valeurs qui sont déterminées uniquement par leurs attributs et ne possèdent pas d'identité propre. Ils sont souvent utilisés pour représenter des concepts tels que des montants d'argent, des coordonnées géographiques, des adresses e-mail, des numeros de telephone, etc. En encapsulant ces valeurs dans des objets, on peut garantir leur immuabilité et leur cohérence, ce qui peut rendre le code plus sûr et plus facile à comprendre.
    
    - **Repositories/**:
  
      - **Contracts/**: Contient des interfaces définissant les contrats pour les classes de repository.

        - **ReadOnlyRepositoryInterface.php**: L'interface `ReadOnlyRepositoryInterface` définit les règles pour interagir avec les données en mode `read-only` de l'application. Elle propose des méthodes telles que all, find, where, etc., offrant ainsi un accès sécurisé et non modificateur aux données de la base de données. Cette interface permet de consulter les données sans les modifier, ce qui est utile dans de nombreuses situations où la `read-only` est nécessaire, comme la consultation de données historiques ou la lecture de données partagées entre plusieurs parties de l'application.

        - **ReadWriteRepositoryInterface.php**: L'interface `ReadWriteRepositoryInterface` est un contrat définissant un ensemble de méthodes pour interagir avec les données en mode `read-write` de l'application. Cette interface étend l'interface `ReadOnlyRepositoryInterface`, ce qui signifie qu'elle hérite de toutes les méthodes de l'interface de `read-only` et ajoute des méthodes supplémentaires pour la création, la mise à jour et la suppression des enregistrements. Contrairement à l'interface `ReadOnlyRepositoryInterface`, cette interface permet non seulement de récupérer des enregistrements, mais aussi de les créer, de les mettre à jour et de les supprimer. Elle inclut des méthodes telles que create pour créer de nouveaux enregistrements, update pour mettre à jour des enregistrements existants, softDelete pour effectuer une suppression douce, permanentlyDelete pour supprimer définitivement des enregistrements doucement supprimés, etc. En résumé, cette interface offre un ensemble complet d'opérations CRUD (`Create`, `Read`, `Update`, `Delete`) pour interagir avec les données de la base de données.

      - **Eloquent/**:

        - **BaseRepository.php**: Ce fichier contient la classe `BaseRepository`, qui sert de classe de base pour les repositories Eloquent dans l'application. Il inclut des fonctionnalités communes et des méthodes partagées par les repositories `EloquentReadOnlyRepository` et `EloquentReadWriteRepository`.

        - **EloquentReadOnlyRepository.php**: La classe abstraite `EloquentReadOnlyRepository` sert de fondation pour les repositories en `read-only` qui interagissent avec un model Eloquent de l'application. Elle implémente l'interface `ReadOnlyRepositoryInterface`, fournissant des opérations de lecture essentielles pour récupérer des données à partir du model associé. Cette classe inclut des méthodes telles que `all` pour récupérer tous les enregistrements, `find` pour localiser un enregistrement par son ID, `exists` pour vérifier l'existence d'enregistrements en fonction de conditions spécifiées.
          >
          >    ```php
          >
          >     <?php
          >
          >     declare(strict_types = 1);
          >
          >     namespace Core\Data\Repositories\Eloquent;
          >
          >     use Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface;
          >     use Illuminate\Database\Eloquent\Model;
          >
          >     /**
          >      * The ***`EloquentReadOnlyRepository`*** abstract class.
          >      *
          >      * This abstract class serves as a base class for read-only repositories 
          >      * that interact with an Eloquent model.
          >      * It extends the `BaseRepository` class and implements the 
          >      * `ReadWriteRepositoryInteonlyrface`.
          >      *
          >      * @package ***`Core\Data\Repositories\Eloquent`***
          >      */
          >     class EloquentReadOnlyRepository extends BaseRepository implements ReadOnlyRepositoryInterface
          >     {
          >         /**
          >          * `EloquentReadOnlyRepository` constructor.
          >          * 
          >          * Creates a new instance of the `EloquentReadOnlyRepository` class
          >          * associating it with the provided Eloquent model.
          >          * This constructor is called when you create a new instance of the 
          >          * repository, allowing you to specify the model that the repository will 
          >          * interact with.
          >          *  @param \Illuminate\Database\Eloquent\Model $model The Eloquent model
          >          * associated with the repository.
          >          */
          >         public function __construct(Model $model){
          >             parent::__construct($model);
          >         }
          >     }
          >

        - **EloquentReadWriteRepository.php**: La classe abstraite `EloquentReadWriteRepository` sert de base pour les repositories en `read-write` qui interagissent avec un model Eloquent de l'application. Elle étend la classe `EloquentReadOnlyRepository` et implémente l'interface `ReadWriteRepositoryInterface`. Cette classe offre des fonctionnalités de création, de mise à jour et de suppression de données, en plus des opérations de lecture héritées de la classe parente. Elle inclut des méthodes telles que `create` pour créer un nouvel enregistrement, `update` pour mettre à jour un enregistrement existant et `softDelete` pour effectuer une suppression douce (soft delete)
          >
          >    ```php
          >
          >     <?php
          >
          >     declare(strict_types = 1);
          >
          >     namespace Core\Data\Repositories\Eloquent;
          >
          >     use Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface;
          >     use Illuminate\Database\Eloquent\Model;
          >
          >     /**
          >      * The ***`EloquentReadWriteRepository`*** abstract class.
          >      *
          >      * This abstract class serves as a base class for read-write repositories 
          >      * that interact with an Eloquent model.
          >      * It extends the `BaseRepository` class and implements the 
          >      * `ReadWriteRepositoryInterface`.
          >      *
          >      * @package ***`Core\Data\Repositories\Eloquent`***
          >      */
          >     class EloquentReadWriteRepository extends EloquentReadOnlyRepository implements ReadWriteRepositoryInterface
          >     {
          >         /**
          >          * `EloquentReadWriteRepository` constructor.
          >          * 
          >          * Creates a new instance of the `EloquentReadWriteRepository` class
          >          * associating it with the provided Eloquent model.
          >          * This constructor is called when you create a new instance of the 
          >          * repository, allowing you to specify the model that the repository will 
          >          * interact with.
          >          *  @param \Illuminate\Database\Eloquent\Model $model The Eloquent model
          >          * associated with the repository.
          >          */
          >         public function __construct(Model $model){
          >             parent::__construct($model);
          >         }
          >     }
          >
  
  - **Logic/Sercices/**: Ici, nous gérons la logique métier de notre application, avec des contrats et des services responsables de diverses opérations, allant de la simple lecture de données à des opérations plus complexes de `read-write`.
  
    - **Contracts/**:

      - **QueryServiceContract.php**: Le `QueryServiceContract` définit les spécifications pour un gerer la logique metier lie au query service. Cette interface décrit des méthodes pour récupérer des données d'une source de données de manière efficace et systématique. Elle offre des fonctionnalités telles que la récupération de tous les enregistrements, la pagination des résultats, la recherche d'enregistrements par leur ID, le filtrage des enregistrements en fonction de critères spécifiques, le décompte des enregistrements, l'exécution de requêtes ou actions personnalisées, et la gestion des enregistrements supprimés. Ce contrat sert de modèle pour implementer des queries services qui interagissent avec les repositories de données, facilitant ainsi que les opérations de récupération de données robustes et normalisées dans toute l'application.

      - **ReadWriteServiceContract.php**: L'interface `ReadWriteServiceContract` étend l'interface `QueryServiceContract` et définit les règles pour un gerer un service en `read-write`, qui fournit des méthodes pour créer, mettre à jour et supprimer des enregistrements. Les méthodes incluses permettent de créer un nouvel enregistrement, de mettre à jour un enregistrement existant, de supprimer un ou plusieurs enregistrements de manière souple (soft delete), de restaurer des enregistrements supprimés, de vider la corbeille (trash), et de supprimer définitivement des enregistrements. Cette interface fournit une abstraction pour les opérations CRUD (créer, lire, mettre à jour, supprimer) et offre des fonctionnalités de gestion complètes des données au sein d'une application.

    - **Manager/**:
      - **AbstractService.php**: Cette classe abstraite fournit une base commune pour les services de la logic metier dans l'application. Elle encapsule la logique métier commune et fournit des méthodes génériques qui peuvent être utilisées par d'autres services spécifiques.

      - **QueryService.php**: La classe `QueryService` implémente l'interface `QueryServiceContract` et fournit des méthodes pour récupérer des données à partir d'une source de données. Elle encapsule les opérations de lecture de base telles que la récupération de tous les enregistrements, la pagination, la recherche par ID, la recherche avec des critères spécifiques, le comptage du nombre d'enregistrements, ainsi que l'exécution de requêtes personnalisées.
          >
          >    ```php
          >
          >     <?php
          >
          >     declare(strict_types = 1);
          >
          >     namespace Core\Logic\Services\Manager;
          >
          >     use Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface;
          >     use Core\Logic\Services\Contracts\QueryServiceContract;
          >     use Illuminate\Database\Eloquent\Model;
          >
          >     /**
          >      * Constructor for the **`QueryService`** abstract class.
          >      *
          >      * This abstract class provides a base implementation of the 
          >      * `QueryServiceContract` interface,
          >      * which defines methods for querying and retrieving records.
          >      * 
          >      * @package ***`Core\Logic\Services\Manager`***
          >      */
          >     class QueryService extends AbstractService implements QueryServiceContract
          >     {
          >         /**
          >          * Constructor for the **`QueryService`** abstract class.
          >          * 
          >          * @param \Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface $readOnlyRepository The read-only repository 
          >          * to be used for querying and retrieving records.
          >          */
          >         public function __construct(
          >             ReadOnlyRepositoryInterface $readOnlyRepository
          >         )
          >         {
          >             parent::__construct($readOnlyRepository);
          >         }
          >     }
          >

      - **ReadWriteService.php**: La classe `ReadWriteService` implémente l'interface `ReadWriteServiceContract` et étend la classe `QueryService`. Elle ajoute des méthodes pour créer, mettre à jour et supprimer des enregistrements, en plus des fonctionnalités de lecture déjà fournies par la classe `QueryService`. Cela permet d'avoir un service complet pour les opérations CRUD (création, lecture, mise à jour et suppression) sur les données de votre application.
          >
          >    ```php
          >
          >     <?php
          >
          >     declare(strict_types = 1);
          >
          >     namespace Core\Logic\Services\Manager;
          >
          >     use Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface;
          >     use Core\Logic\Services\Contracts\QueryServiceContract;
          >     use Illuminate\Database\Eloquent\Model;
          >
          >     /**
          >      * Constructor for the **`ReadWriteService`** abstract class.
          >      *
          >      * The `ReadWriteService` class provides a concrete implementation of the `ReadWriteServiceContract`.
          >      * It extends the `QueryService` class and adds write operations to manipulate data using the associated `ReadWriteRepositoryInterface`.
          >      * This class is responsible for creating, updating, soft deleting, restoring, and permanently deleting records.
          >      * 
          >      * @package ***`Core\Logic\Services\Manager`***
          >      */
          >     class ReadWriteService extends QueryService implements ReadWriteServiceContract
          >     {
          >         /**
          >          * Constructor for the ReadWriteService abstract class.
          >          * 
          >          * @param \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface $readWriteRepository The read-only repository 
          >          * to be used for querying and retrieving records.
          >          */
          >         public function __construct(
          >             ReadWriteRepositoryInterface $readWriteRepository
          >         )
          >         {
          >             parent::__construct($readWriteRepository);
          >         }
          >     }
          >

    - **RestJson/**:
      - **Contracts/**:
        - **RestJsonQueryServiceContract.php**: Cette interface définit le contrat pour un query service RESTful JSON, qui fournit des méthodes pour traiter des requetes `REST/JSON` et de formater les reponses au format JSON.

        - **RestJsonReadWriteServiceContract.php**: Cette interface définit le contrat pour un service RESTful JSON de `read/write`, offrant des méthodes pour créer, mettre à jour, supprimer et récupérer des données au format JSON.

      - **RestJsonQueryService.php**: La classe `RestJsonQueryService` implémente les fonctionnalités de la couche de service pour traiter des requêtes en lecture de type `REST/JSON`.
          > ### RestJsonQueryService.php
          >
          >    ```php
          >
          >     <?php
          >
          >     declare(strict_types = 1);
          >
          >     namespace Core\Logic\Services\RestJson;
          >
          >     use Core\Logic\Services\Contracts\QueryServiceContract;
          >     use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;
          >     use Illuminate\Database\Eloquent\Model;
          >
          >     /**
          >      * Constructor for the **`RestJsonQueryService`** abstract class.
          >      *
          >      * The `RestJsonQueryService` class is an abstract class that provides a 
          >      * concrete implementation of the `RestJsonQueryServiceContract`.
          >      * It extends the `QueryService` class and adds methods for retrieving 
          >      * records in a `RESTful` JSON format.
          >      * This class is responsible for retrieving all records, `paginating` 
          >      * records, `finding` records by ID, `filtering` records based on `criteria`, 
          >      * `counting` records, and `retrieving` soft deleted records.
          >      * 
          >      * @package \Core\Logic\Services\RestJson
          >      */
          >     abstract class RestJsonQueryService implements RestJsonQueryServiceContract
          >     {
          >         /**
          >          * The query service instance.
          >          * 
          >          * @var \Core\Logic\Services\Contracts\QueryServiceContract|null
          >          */
          >          protected QueryServiceContract $queryService;
          >
          >         /**
          >          * Constructor for the **`QueryService`** abstract class.
          >          * 
          >          * @param QueryServiceContract $queryService The query service 
          >          * to be used for querying and retrieving records.
          >          */
          >         public function __construct(QueryServiceContract $queryService)
          >         {
          >             parent::__construct($queryService);
          >             $this->queryService = $queryService;
          >         }
          >
          >         /**
          >          * Set the read-only service associated with the service.
          >          * 
          >          * @param  \Core\Logic\Services\Contracts\QueryServiceContract $service The read-only service instance. 
          >          * @return void
          >          */
          >          public function setReadOnlyService(QueryServiceContract $service): void
          >          {
          >             $this->queryService = $service;
          >          }
          >
          >         /**
          >          * Get the read-only service associated with the service.
          >          * 
          >          * @return \Core\Logic\Services\Contracts\QueryServiceContract The read-only service instance.
          >          */
          >          public function getReadOnlyService(
          >               QueryServiceContract $service
          >          ): \Core\Logic\Services\Contracts\QueryServiceContract
          >          {
          >             return $this->queryService;
          >          }
          >     }
          >

      - **RestJsonReadWriteService.php**: Le fichier RestJsonReadWriteService.php contient une classe qui implémente les fonctionnalités de la couche de service pour la création, la mise à jour, la suppression et la récupération de données au format JSON. Cette classe est destinée pour traiter des opérations CRUD (créer, lire, mettre à jour, supprimer) `REST/JSON`, offrant ainsi une interface cohérente pour interagir avec les ressources JSON dans l'application application.
          > ### RestJsonReadWriteService.php
          >
          >    ```php
          >
          >     <?php
          >
          >     declare(strict_types = 1);
          >
          >     namespace Core\Logic\Services\RestJson;
          >
          >     use Core\Logic\Services\Contracts\ReadWriteServiceContract;
          >     use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;
          >     use Illuminate\Database\Eloquent\Model;
          >
          >     /**
          >      * Constructor for the **`RestJsonReadWriteService`** abstract class.
          >      *
          >      * The `RestJsonReadWriteService` class is an abstract class that provides a 
          >      * concrete implementation of the `RestJsonReadWriteServiceContract`.
          >      * It extends the RestJsonQueryService class and adds methods for `creating`, 
          >      * `updating`, and `deleting` records in a `RESTful JSON` format.
          >      * This class is responsible for `creating` records, `updating` records, 
          >      * `soft deleting` records, `permanently deleting` records, `restoring` soft 
          >      * deleted records,
          >      * `emptying the trash`, and `performing bulk` operations on records.
          >      * 
          >      * @package \Core\Logic\Services\RestJson
          >      */
          >     abstract class RestJsonReadWriteService extends RestJsonQueryService 
          >     implements RestJsonReadWriteServiceContract
          >     {
          >         /**
          >          * The read-write service instance.
          >          * 
          >          * @var \Core\Logic\Services\Contracts\ReadWriteServiceContract|null
          >          */
          >          protected ReadWriteServiceContract $readWriteService;
          >
          >         /**
          >          * Constructor for the **`QueryService`** abstract class.
          >          * 
          >          * @param ReadWriteServiceContract $queryService The query service 
          >          * to be used for querying and retrieving records.
          >          */
          >         public function __construct(ReadWriteServiceContract $readWriteService)
          >         {
          >             parent::__construct($readWriteService);
          >             $this->readWriteService = $readWriteService;
          >         }
          >
          >         /**
          >          * Set the read-write service associated with the service.
          >          * 
          >          * @param  \Core\Logic\Services\Contracts\ReadWriteServiceContract $service The read-only service instance. 
          >          * @return void
          >          */
          >          public function setReadWriteService(ReadWriteServiceContract $service)
          >          {
          >             $this->readWriteService = $service;
          >          }
          >
          >         /**
          >          * Get the read-write service associated with the service.
          >          * 
          >          * @return \Core\Logic\Services\Contracts\ReadWriteServiceContract The read-only service instance.
          >          */
          >          public function getReadWriteService(): ReadWriteServiceContract
          >          {
          >             return $this->readWriteService;
          >          }
          >     }
          >
  
  - **Logic/Utils/**: Ce répertoire, contient des classes utilitaires et des fonctions utilisées à travers différents composants de la couche logique de l'application. Ces utilitaires sont conçus pour fournir des fonctionnalités communes ou helper à effectuer diverses tâches au sein de l'application. Ils incluent des fonctions helper, des utilitaires de traitement des données ou toute autre logique réutilisable qui ne appartient pas à un domaine ou un service spécifique.

    - **Controllers/**:
      - **RESTful/**:
        - **Contracts/**:
          - **RESTfulResourceControllerContract.php**: Le fichier `RESTfulResourceController.php` définit une interface `RESTfulResourceControllerContract` qui sert de contrat pour un contrôleur RESTful. Ce contrat spécifie les méthodes CRUD de base attendues dans une classe qui agit comme un contrôleur de base `RESTful` pour la gestion des features.

        - **RESTfulResourceController.php**: Le fichier `RESTfulResourceController.php` contient une classe qui implémente l'interface `RESTfulResourceControllerContract`. Cette classe sert de contrôleur de base RESTful et fournit des méthodes pour effectuer des opérations CRUD (`Create`, `Read`, `Update`, `Delete`) sur les ressources. Les méthodes de ce contrôleur gèrent les requêtes HTTP correspondantes pour afficher, créer, mettre à jour et supprimer des ressources, ainsi que pour effectuer des opérations de filtrage et d'autres actions sur les ressources.
          >
          >    ```php
          >
          >     <?php
          >
          >     declare(strict_types = 1);
          >
          >     namespace Core\Logic\Services\RestJson;
          >
          >     use Core\Logic\Services\Contracts\ReadWriteServiceContract;
          >     use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;
          >     use Illuminate\Database\Eloquent\Model;
          >
          >     /**
          >      * Constructor for the **`RestJsonReadWriteService`** abstract class.
          >      *
          >      * The `RestJsonReadWriteService` class is an abstract class that provides a 
          >      * concrete implementation of the `RestJsonReadWriteServiceContract`.
          >      * It extends the RestJsonQueryService class and adds methods for `creating`, 
          >      * `updating`, and `deleting` records in a `RESTful JSON` format.
          >      * This class is responsible for `creating` records, `updating` records, 
          >      * `soft deleting` records, `permanently deleting` records, `restoring` soft 
          >      * deleted records,
          >      * `emptying the trash`, and `performing bulk` operations on records.
          >      * 
          >      * @package \Core\Logic\Services\RestJson
          >      */
          >     abstract class RestJsonReadWriteService extends RestJsonQueryService 
          >     implements RestJsonReadWriteServiceContract
          >     {
          >         /**
          >          * The RESTful service contract responsible for handling read-write 
          >          * operations.
          >          * 
          >          * @var RestJsonReadWriteServiceContract|null
          >          */
          >          protected ?RestJsonReadWriteServiceContract $restJsonReadWriteService;
          >         
          >         /**
          >          * The RESTful service contract responsible for handling query operations.
          >          * 
          >          * @var RestJsonQueryServiceContract|null
          >          */
          >          protected ?RestJsonQueryServiceContract $restJsonQueryService;
          >
          >         /**
          >          * Constructor for the **`RESTfulController`** abstract class.
          >          * 
          >          * @param RestJsonReadWriteServiceContract|null $restJsonReadWriteService 
          >          *        The RESTful service contract for managing resources.
          >          * 
          >          * @param RestJsonQueryServiceContract|null     $restJsonQueryService     
          >          *        The RESTful query service contract for querying resources.
          >          * @return void
          >          */
          >         public function __construct(
          >               RestJsonReadWriteServiceContract $restJsonReadWriteService = null,
          >               RestJsonQueryServiceContract $restJsonQueryService = null
          >         )
          >         {
          >             if ($restJsonReadWriteService === null 
          >                   && $restJsonQueryService === null
          >             ) {
          >                   throw new \InvalidArgumentException('At least one of   
          >                         $restJsonReadWriteService or $restJsonQueryService should 
          >                         be precise.'
          >                   );
          >               $this->restJsonReadWriteService = $restJsonReadWriteService;
          >               $this->restJsonQueryService = $restJsonQueryService;
          >             }
          >         }
          >     }
          >
  
    - **DataTransfertObjects**: Dans le contexte du transfert de données, un objet `DTO` (`Data Transfer Object`) est utilisé pour encapsuler un ensemble de données et les transférer entre les couches d'une application. Par exemple, lors de la communication entre le `contrôleur` et le `service`, un `DTO` peut être utilisé pour structurer les données à transférer.
  
      - **BaseDTO.php**: Le fichier `BaseDTO.php` contient une implémentation de base d'un objet DTO. Il peut contenir des propriétés et des méthodes communes à tous les objets DTO de l'application, fournissant ainsi une base réutilisable pour la création de nouveaux objets DTO.

      - **DTOInterface.php**: Le fichier `DTOInterface.php` définit une interface pour les objets `DTO`, spécifiant les méthodes que chaque objet `DTO` doit implémenter. Cette interface fournit une structure standardisée pour les objets `DTO` utilisés dans l'application.

    - **Enums/**:
      - **Common/ErrorCodeEnum.php**: Le fichier `ErrorCodeEnum.php` contient une classe d'énumération ``ErrorCodeEnum`` située dans l'espace de noms Common, conçue pour gérer les codes d'erreur couramment utilisés dans l'application. Cette classe d'énumération définit probablement un ensemble de codes d'erreur en tant que constantes, chacune associée à un scénario ou type d'erreur spécifique. Ces codes d'erreur peuvent être utilisés dans toute l'application pour identifier et gérer différentes conditions d'erreur de manière cohérente. En centralisant les codes d'erreur dans une classe d'énumération, la base de code devient plus organisée, lisible et maintenable, facilitant ainsi la gestion des erreurs et le dépannage au sein de l'application.

      - **Contract/ErrorContract.php**: offre une gamme de méthodes pour gérer les énumérations relatives aux erreurs.
      - ***.php**: sont des ensembles de fichier qui contiennent des définitions de classes qui représentent des ensembles spécifiques de valeurs constantes. Ces valeurs constantes sont généralement utilisées pour représenter des choix restreints ou des options prédéfinies dans l'application. Les énumérations fournissent un moyen pratique de référencer ces valeurs constantes à l'aide de noms symboliques significatifs, améliorant ainsi la lisibilité et la maintenabilité du code. Elles sont souvent utilisées pour définir des types de données spécifiques ou des options standardisées, contribuant ainsi à une organisation claire et à une meilleure compréhension du code.

    - **Exceptions/**:

      - **Contract/CoreException.php**: Le fichier définit la classe `CoreException`, qui sert de classe d'exception de base pour les exceptions liées au cœur de l'application. Il fournit des comportements d'exception communs et permet une gestion cohérente des erreurs dans l'ensemble du code. Cette classe étend la classe PHP intégrée `\Exception` et inclut des fonctionnalités telles que la spécification des codes d'état HTTP, des codes d'erreur et des détails d'erreur supplémentaires. Il comprend également des méthodes pour récupérer et définir ces propriétés, rendre les exceptions sous forme de réponses JSON pour les contextes API, et générer des représentations sous forme de chaînes de l'exception.
      
      - ***.php**: ensemble de fichiers PHP définissant différentes classes d'exceptions. Chaque fichier PHP représente une classe d'exception spécifique et fournit des fonctionnalités pour gérer des situations d'erreur particulières dans l'application. Ces classes peuvent étendre la classe d'exception personnalise CoreException pour encapsuler des erreurs spécifiques et fournir des méthodes pour récupérer des informations sur l'erreur, définir des codes d'erreur et générer des représentations adaptées pour les différents contextes de l'application.

    - **Helpers/**: Ce répertoire contient des classes utilitaires qui fournissent diverses fonctionnalités d'aide pour simplifier le développement et la gestion de l'application.

      - **Responses/Json**:

        - **ForceRequestResponseToBeJson.php**: Cette classe est responsable de forcer une requête HTTP à retourner une réponse au format JSON, quelle que soit la méthode d'accès ou les en-têtes de la requête. Elle intercepte la réponse et convertit son contenu en JSON si nécessaire, garantissant ainsi que les réponses sont toujours cohérentes avec le format JSON spécifié par l'application.

      - **Sluggable/HasSlug.php**: Ce fichier contient une trait qui peut être utilisée dans les models pour faciliter la génération et la gestion des slugs.

      - **RouteHelper.php**: Ce classe fournit une méthode utilitaire pour charger dynamiquement les routes de l'API à partir des différentes versions fournies. Cette classe permet de charger les fichiers de route pour chaque version de l'API et de les regrouper par version. Elle garantit également que les réponses suivent un schéma JSON spécifié, même si le contenu n'est pas déjà au format JsonResponse, en appliquant automatiquement le middleware approprié. Cela permet d'assurer une cohérence dans la structure des réponses JSON pour les différentes versions de l'API, simplifiant ainsi le processus de gestion des routes et des versions dans une application.

    - **Middleware/**:

      - **ForceJsonResponseMiddleware.php**: Un middleware qui garantit que toutes les réponses HTTP sont au format JSON, même si le contenu n'est pas déjà dans un format JsonResponse. Cela assure une cohérence dans la structure des réponses pour les API, simplifiant ainsi la gestion des réponses.
  
      - **CORSMiddleware.php**: Un middleware qui gère les requêtes `CORS` (Cross-Origin Resource Sharing) en ajoutant les en-têtes CORS appropriés aux réponses HTTP. Cela permet aux clients d'accéder aux ressources depuis des origines différentes et renforce la sécurité des applications web en contrôlant l'accès aux ressources côté serveur.

    - **Mixins/helpers.php**: regroupe toutes sortes de petites fonctions pratiques qui rendent la vie plus facile lors le developpement de l'application.

    - **Requests/**:
      - **Contracts/**:
        - **ResourceRequestInterface.php**: Le fichier `ResourceRequestInterface.php` contient une interface appelée `ResourceRequestInterface`. Cette interface sert de contrat pour les classes de form requests qui gèrent différentes opérations sur les ressources.
          > Les classes qui implémentent cette interface doivent fournir des méthodes pour la validation, l'autorisation et la récupération des données spécifiques à l'opération de ressource correspondante.

      - **CreateResourceRequest.php**: Le fichier CreateResourceRequest.php contient une classe abstraite appelée CreateResourceRequest. Cette classe étend la classe de base ResourceRequest et fournit une structure pour gérer la logique d'autorisation spécifique à la création de ressources.

      - **ResourceRequest.php**: Le fichier `ResourceRequest.php` contient une classe abstraite `ResourceRequest` qui sert de base pour les classes de form request personnalisées. Cette classe étend la classe `FormRequest` de Laravel et implémente l'interface `ResourceRequestInterface`.

        > Les classes concrètes qui étendent `ResourceRequest` doivent fournir leur propre implémentation des méthodes `isAuthorize` et `process`.
        >
        > La méthode `authorize` est appelée lors de la phase d'autorisation du cycle de vie de la requête. Elle configure le Data Transfer Object (`DTO`) associé à cette requête, puis vérifie si l'utilisateur est autorisé en fonction de la logique d'autorisation implémentée dans la classe concrète.
        >
        > Cette classe vise à centraliser la logique de traitement des requêtes liées aux ressources et à fournir une structure cohérente pour gérer ces requêtes dans une application Laravel.

      - **UpdateResourceRequest.php**: La classe `UpdateResourceRequest` étend la classe de base `ResourceRequest` et fournit une structure pour gérer la logique d'autorisation spécifique à la création de ressources. Les classes concrètes étendant `UpdateResourceRequest` doivent implémenter la méthode isAuthorize pour définir leur logique d'autorisation.

    - **Rules/**: Le répertoire `Rules` contient des classes qui définissent des règles de validation personnalisées pour les données dans une application Laravel. Ces règles peuvent être utilisées pour valider divers types de données, telles que les UUID, les identifiants polymorphiques, les numéros de téléphone, etc.

    - **Traits**:
      - **Database/Migrations**: Contient un ensemble de traits conçus pour faciliter la gestion et la création de migrations dans les applications Laravel. Ces traits offrent des fonctionnalités supplémentaires et des méthodes utilitaires pour simplifier les tâches courantes liées aux migrations de base de données.  Ils incluent des fonctionnalités telles que la gestion des clés primaires composites, la définition de contraintes de clé étrangère, l'ajout de timestamps automatiques, la définition de clés primaires UUID, et bien plus encore.

      - **IsEnum.php**: Le fichier IsEnum.php contient un trait appelé IsEnum, qui est utilisé pour faciliter la gestion des énumérations dans le code. Ce trait offre plusieurs méthodes pour interagir avec les énumérations définies, notamment pour obtenir des valeurs aléatoires, récupérer toutes les valeurs disponibles, obtenir les noms des constantes, récupérer toutes les valeurs et leurs étiquettes, ainsi que pour obtenir les clés (constantes) de l'énumération, etc.

      - **TooManyFailedAttemptsTrait.php**: Le fichier `TooManyFailedAttemptsTrait.php` contient un trait nommé `TooManyFailedAttemptsTrait`. Ce trait fournit des méthodes pour gérer le contrôle des tentatives de connexion échouées, en limitant le nombre de tentatives autorisées et en déterminant le délai de décroissance pour réessayer. Il utilise également le service de RateLimiter de Laravel pour effectuer le contrôle de fréquence des tentatives de connexion. En cas de dépassement du nombre maximal de tentatives, une exception est levée pour informer l'utilisateur qu'il a dépassé le nombre maximal de tentatives de connexion autorisées.

- **config/**: Contient tous les fichiers de configuration de l'application, y compris les configurations de base de données, de cache, de session, etc.

  - **app.php** : Contient les configurations principales de l'application, telles que le nom de l'application, le fuseau horaire par défaut, la locale et d'autres paramètres globaux.
    > Le fichier app.php est une composante clé de la configuration de ton application.
    >
    > Ce fichier de configuration joue un rôle essentiel dans l'initialisation de l'application. En plus des paramètres principaux tels que le nom de l'application, l'environnement, le mode de débogage, l'URL de l'application, le fuseau horaire, la langue, la clé d'encryption, etc., ce fichier contient deux sections principales :
    >
    > - **Fournisseurs de services autochargés** : Cette section définit les fournisseurs de services qui seront automatiquement chargés lors de chaque demande à l'application. Les fournisseurs de services sont des composants fondamentaux de Laravel qui permettent d'étendre les fonctionnalités de l'application en fournissant différents services et fonctionnalités supplémentaires. Dans cette section, on peux ajouter des fournisseurs de services provenant de packages externes ainsi que des fournisseurs de services personnalisés développés spécifiquement pour ton application. Cela te permet d'ajouter et de configurer facilement de nouvelles fonctionnalités dans ton application.
    >
    > - **Alias de classe** : Cette section définit les alias de classe qui simplifient l'accès aux classes importantes de l'application. Les alias de classe permettent d'utiliser des noms plus courts et plus conviviaux pour accéder à des classes spécifiques. Par exemple, l'alias ```'Excel' => Maatwebsite\Excel\Facades\Excel::class``` nous permet d'accéder facilement à la classe Excel fournie par le package `Maatwebsite\Excel` en utilisant simplement le nom `'Excel'`. Cela rend l'utilisation de certaines classes plus intuitive et facilite le développement de ton application en réduisant la saisie et en améliorant la lisibilité du code.
  
  - **auth.php** : Fichier de configuration pour l'authentification. Utilisé pour configurer l'authentification dans l'application, y compris les gardes d'authentification par défaut, les fournisseurs de données utilisateur et les configurations de réinitialisation de mot de passe. Il permet de spécifier les paramètres par défaut pour l'authentification, de définir les méthodes de stockage de session et de personnaliser les modèles utilisateurs pour chaque garde.

  - **broadcasting.php** : Fichier de configuration pour la diffusion d'événements en temps réel dans l'application. Il permet de configurer la diffusion d'événements en temps réel en spécifiant les pilotes de diffusion (par exemple, `Pusher`, `Redis`) et d'autres paramètres associés.
    >    ```php
    >    use Illuminate\Support\Facades\Broadcast;
    >
    >    Broadcast::channel('chat.{roomId}', function ($user, $roomId) {
    >        // Vérifie si l'utilisateur est autorisé à rejoindre le canal
    >        return $user->canJoinRoom($roomId);
    >    });
    >
    >    Broadcast::channel('notifications.{userId}', function ($user, $userId) {
    >        // Vérifie si l'utilisateur est autorisé à recevoir des notifications
    >        return $user->id === $userId;
    >    });
    >

  - **cache.php** : Le fichier `cache.php` de Laravel permet de configurer les mécanismes de mise en cache utilisés dans l'application, tels que les pilotes de mise en cache (`file`, `base de données`, `Redis`, etc.), les configurations spécifiques à chaque pilote, etc.
  
  - **cors.php** : Le fichier `cors.php` de Laravel permet de configurer les paramètres de `Cross-Origin Resource Sharing (CORS)` pour définir les autorisations d'accès aux ressources des requêtes HTTP cross-origin dans l'application.

  - **database.php** : Le fichier `database.php` de Laravel permet de configurer les connexions à la base de données et d'autres paramètres associés à la gestion des bases de données dans l'application.

    > Ce fichier contient les configurations de connexion à la base de données pour différentes plateformes comme `MySQL`, `PostgreSQL`, `SQLite`, etc. Il permet de spécifier la connexion par défaut, les détails de connexion pour chaque plateforme, ainsi que les configurations pour Redis. Il inclut également la gestion des migrations de base de données et les paramètres pour les bases de données Redis.

  - **filesystems.php** : Le fichier `filesystems.php` de Laravel permet de configurer les systèmes de fichiers utilisés dans l'application, définissant notamment les pilotes de stockage de fichiers (`local`, `public`, `S3`, etc.), les options de configuration et les systèmes de fichiers cloud.

  - **hashids.php** : Fichier de configuration pour la bibliothèque Hashids, utilisée pour générer des identifiants hashés pour les modèles dans l'application.

  - **hashing.php** : Permet de configurer les options de hachage dans l'application, y compris l'algorithme de hachage par défaut et les options de configuration associées.

  - **logging.php** : Utilisé pour configurer les journaux (logs) de l'application, y compris les canaux de journalisation, les niveaux de journalisation, etc.

  - **mail.php** : Utilisé pour configurer les paramètres d'envoi d'e-mails, y compris les pilotes de messagerie utilisés (SMTP, Mailgun, Sendmail, etc.), les informations d'authentification, etc.

  - **passport.php** : Le fichier `passport.php` de Laravel permet de configurer l'authentification `OAuth2` avec `Laravel Passport`, notamment le choix du garde d'authentification, les clés de chiffrement pour la génération de tokens d'accès sécurisés, l'utilisation d'UUID pour les identifiants de clients, et la configuration des clients d'accès personnel et d'accès autorisé. Les valeurs de ces paramètres peuvent être définies dans le fichier d'environnement pour une gestion pratique et sécurisée.

  - **queue.php** : Le fichier `queue.php` de Laravel permet de configurer les connexions de file d'attente pour les travaux en arrière-plan, y compris les pilotes de file d'attente utilisés (`database`, `Redis`, etc.) et leurs configurations spécifiques. Il spécifie les connexions par défaut et les détails de configuration pour chaque serveur utilisé dans l'application.

  - **session.php** : Utilisé pour configurer les options de stockage de session pour l'application, telles que le pilote de stockage de session utilisé (`fichier`, `base de données`, `Redis`, etc.), les durées de vie de session, les options de stockage, etc.

  - **sanctum.php** : Fichier de configuration pour Laravel Sanctum, utilisé pour implémenter l'authentification API stateless dans l'application.

  - **services.php** : Le fichier `services.php` de Laravel permet de configurer les services tiers utilisés dans l'application, tels que les fournisseurs Mailgun, Postmark, AWS, OAuth, Socialite, etc. les identifiants client pour les services externes, les clés d'API, etc. Il fournit un emplacement conventionnel pour ces informations, facilitant l'intégration des services tiers avec l'application Laravel.

  - **view.php** : Contient les configurations pour la gestion des vues dans l'application, y compris les chemins des répertoires de vues, les compilateurs de vues, etc.

- **database/**: Contient les migrations de base de données, les seeders et les factories.

  - **migrations/**: Fichiers PHP pour définir la structure de la base de données. Définition de la structure de la base de données.

  - **seeders/**: Classes pour générer des données de test. Les seeders sont utilisés pour alimenter la base de données avec des données de test initiales, ce qui permet de simplifier le processus de développement et de tests automatisés.

  - **Factories/**: Fabriques pour générer des données de test de manière structurée. Les factories sont utilisées en conjonction avec les seeders pour générer des données réalistes et cohérentes. Elles permettent de créer des enregistrements de manière programmée en utilisant des modèles définis pour les différentes entités de l'application.

- **domains/**: 

  - **Roles/**: 

    - **DataTransfertObjects/**: 

      - **CreateRoleDTO.php**: La classe `CreateRoleDTO` est une composante clé du processus de création de nouveaux rôles dans le système. En tant qu'objet de transfert de données (`DTO`), elle encapsule les données nécessaires à la création d'un rôle et fournit des mécanismes de validation pour garantir l'intégrité des données.

      - **UpdateRoleDTO.php**: La classe `UpdateRoleDTO`, qui est utilisée pour mettre à jour les informations d'un rôle existant dans le système. Comme pour `CreateRoleDTO`, cette classe agit en tant qu'objet de transfert de données (`DTO`) en encapsulant les données nécessaires à la mise à jour d'un rôle. Elle fournit également des règles de validation pour assurer la cohérence des données mises à jour.

    - **Repositories/**: 

      - **RoleReadOnlyRepository.php**: 
          > ### RoleReadOnlyRepository.php
          >
          >    ```php
          >
          >     <?php
          >
          >     declare(strict_types = 1);
          >
          >     namespace Domains\Roles\Repositories;
          >
          >     use App\Models\Role;
          >     use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;
          >
          >     /**
          >      * ***`RoleReadOnlyRepository`***
          >      *
          >      * This class extends the EloquentReadOnlyRepository class, which suggests 
          >      * that it is responsible for providing read-only access to the Role 
          >      * $instance data.
          >      * 
          >      * @package ***`\Domains\Roles\Repositories`***
          >      */
          >     class RoleReadOnlyRepository extends EloquentReadOnlyRepository
          >     {
          >         /**
          >          * Constructor for the **`RoleReadOnlyRepository`** class.
          >          * 
          >          * @param  \App\Models\Role $model
          >          * @return void
          >          */
          >         public function __construct(\App\Models\Role $model)
          >         {
          >             parent::__construct($model);
          >         }
          >     }
          >

      - **RoleReadWriteRepository.php**: Ce fichier contient la définition de la classe RoleReadWriteRepository. Cette classe se trouve dans l'espace de noms Domains\Roles\Repositories. Elle est responsable de fournir un accès en lecture et en écriture aux données de l'instance de rôle.
      La classe RoleReadWriteRepository étend la classe EloquentReadWriteRepository, ce qui suggère qu'elle hérite de fonctionnalités pour la manipulation des données en lecture et en écriture.
          > ### RoleReadWriteRepository.php
          >
          >    ```php
          >
          >     <?php
          >
          >     declare(strict_types = 1);
          >
          >     namespace Domains\Roles\Repositories;
          >
          >     use App\Models\Role;
          >     use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
          >
          >     /**
          >      * ***`RoleReadWriteRepository`***
          >      *
          >      * This class extends the EloquentReadWriteRepository class, which suggests 
          >      * that it is responsible for providing read-write access to the Role 
          >      * $instance data.
          >      * 
          >      * @package ***`\Domains\Roles\Repositories`***
          >      */
          >     class RoleReadWriteRepository extends EloquentReadWriteRepository
          >     {
          >         /**
          >          * Constructor for the **`RoleReadWriteRepository`** class.
          >          * 
          >          * @param  \App\Models\Role $model
          >          * @return void
          >          */
          >         public function __construct(\App\Models\Role $model)
          >         {
          >             parent::__construct($model);
          >         }
          >     }
          >

    - **Services/**: 

      - **RESTful/**: 

        - **Contracts/**: 

          - **RoleRESTfulQueryServiceContract.php**: Cette interface étend le contrat `RestJsonQueryServiceContract`, qui fournit un ensemble de méthodes communes pour effectuer des RESTful `query` sur des ressources spécifique aux ressources de rôle.

          - **RoleRESTfulReadWriteServiceContract.php**: L'interface étend le contrat `RestJsonReadWriteServiceContract`, qui fournit des méthodes APIs RESTful `read/write`  spécifique a la resource rôle via des points. Les classes implémentant cette interface doivent fournir les fonctionnalités nécessaires pour traiter des requetes RESTful `read` et `write` spécifique a la resource rôle via des points d'accès API RESTful.

        - **RoleRESTfulQueryService.php**: Le fichier `RoleRESTfulQueryService.php` définit une classe appelée `RoleRESTfulQueryService` dans le répertoire `Services/RESTful` du module Roles. Cette classe est responsable de fournir un service permettant d'effectuer des `RESTful queries` sur les ressources de rôle. Elle hérite de la classe RestJsonQueryService du module Core et implémente le contrat `RoleRESTfulQueryServiceContract`.
        Le rôle principal de la classe `RoleRESTfulQueryService` est de faciliter les `RESTful queries` concernant les ressources de rôle. Elle utilise la classe `RestJsonQueryService` fournie par le module `Core` et implémente le contrat `RoleRESTfulQueryServiceContract`.
          > ### RoleRESTfulQueryService.php
          >
          >    ```php
          >
          >     <?php
          >
          >     declare(strict_types = 1);
          >
          >     namespace Domains\Roles\Services\RESTful;
          >
          >     use Core\Logic\Services\Contracts\QueryServiceContract;
          >     use Core\Logic\Services\RestJson\RestJsonQueryService;
          >     use Domains\Roles\Services\RESTful\Contracts\RoleRESTfulQueryServiceContract;
          >
          >     /**
          >      * Class ***`RoleRESTfulQueryService`***
          >      *
          >      * The `RoleRESTfulQueryService` class is responsible for providing a 
          >      * RESTful implementation of the query service for the Roles module.
          >      * It extends the `RestJsonQueryService` class provided by the Core module 
          >      * and implements the `RoleRESTfulQueryServiceContract` interface.
          >      * 
          >      * The `RoleRESTfulQueryService` class primarily serves as a wrapper around 
          >      * the underlying query service, providing RESTful capabilities for querying 
          >      * Role resources.
          >      * 
          >      * @package ***`\Domains\Roles\Services\RESTful`***
          >      */
          >     class RoleRESTfulQueryService extends RestJsonQueryService implements RoleRESTfulQueryServiceContract
          >     {
          >         /**
          >          * Constructor for the **`RoleRESTfulQueryService`** class.
          >          * 
          >          * @param QueryServiceContract $queryService The query service instance 
          >          * to be used.
          >          * @return void
          >          */
          >         public function __construct(QueryServiceContract $queryService)
          >         {
          >             parent::__construct($queryService);
          >         }
          >     }
          >

        - **RoleRESTfulReadWriteService.php**:

          > ### RoleRESTfulReadWriteService.php
          >
          >    ```php
          >
          >     <?php
          >
          >     declare(strict_types = 1);
          >
          >     namespace Domains\Roles\Services\RESTful;
          >
          >     use Core\Logic\Services\RestJson\ReadWriteServiceContract;
          >     use Core\Logic\Services\RestJson\RestJsonReadWriteService;
          >     use Domains\Roles\Services\RESTful\Contracts\RoleRESTfulReadWriteServiceContract;
          >
          >     /**
          >      * Class ***`RoleRESTfulReadWriteService`***
          >      *
          >      * The `RoleRESTfulReadWriteService` class is responsible for providing a 
          >      * RESTful implementation of the query service for the Roles module.
          >      * It extends the `ReadWriteServiceContract` class provided by the Core 
          >      * module 
          >      * and implements the `RoleRESTfulReadWriteServiceContract` interface.
          >      * 
          >      * The `RoleRESTfulReadWriteService` class primarily serves as a wrapper 
          >      * around 
          >      * the underlying query service, providing RESTful capabilities for querying 
          >      * Role resources.
          >      * 
          >      * @package ***`\Domains\Roles\Services\RESTful`***
          >      */
          >     class RoleRESTfulReadWriteService extends RestJsonReadWriteService implements RoleRESTfulReadWriteServiceContract
          >     {
          >         /**
          >          * Constructor for the **`RoleRESTfulReadWriteService`** class.
          >          * 
          >          * @param ReadWriteServiceContract $readWriteService The read-write service instance 
          >          * to be used.
          >          * @return void
          >          */
          >         public function __construct(ReadWriteServiceContract $readWriteService)
          >         {
          >             parent::__construct($readWriteService);
          >         }
          >     }
          >


- **public/**: Le document root de l'application. Contient le point d'entrée de l'application, les fichiers CSS, JavaScript et les ressources publiques.

  - **.htaccess:** Fichier utilisé par le serveur web Apache pour configurer des règles de réécriture d'URL, la sécurité et d'autres fonctionnalités du serveur.

  - **index.php:** Point d'entrée principal de l'application Laravel. Toutes les requêtes HTTP sont dirigées vers ce fichier, qui initialise l'application Laravel et traite la requête en fonction des routes définies dans l'application.

  - **robots.txt:** Fichier utilisé pour contrôler le comportement des robots d'indexation des moteurs de recherche sur le site web. Il peut être utilisé pour autoriser ou bloquer l'accès à certaines parties du site aux robots d'indexation.

- **resources/**: Contient les fichiers non exécutables comme les vues, les langues, les fichiers de feuilles de style (CSS), les fichiers JavaScript et les fichiers d'images.

  - **views**: Les vues Blade, qui définissent la présentation de l'application.

- **routes/**: Contient les fichiers de définition des routes de l'application.

  - **web.php**: Routes HTTP pour l'interface utilisateur.

  - **api.php**: Routes API.

- **storage/**: Contient les fichiers générés par l'application, tels que les logs, les sessions, les caches, etc.

  - **apps/**: Ils sont souvent utilisés pour stocker des données générées par l'application ou des données utilisateur téléchargées.

  - **framework/**: Contient les fichiers générés par le framework Laravel.
    
  - **logs/**: Les fichiers de logs générés par l'application.

  - **oauth-private.key**: Clé privée utilisée pour le chiffrement dans OAuth.

  - **oauth-public.key**: Clé publique utilisée pour la vérification dans OAuth.

- **tests/**: Contient les tests unitaires, integrations et fonctionnels de l'application.
  - **Feature/** : Ce répertoire contient les tests de fonctionnalités (Feature tests) de l'application. Ces tests permettent de tester les fonctionnalités de l'application du point de vue de l'utilisateur, en simulant des interactions avec l'application via son interface publique (par exemple, en effectuant des requêtes HTTP).

  - **Integration/** : Ce répertoire contient les tests d'intégration de l'application. Les tests d'intégration vérifient le bon fonctionnement des interactions entre différentes parties de l'application, telles que les couches du modèle, les contrôleurs et les services.

  - **Unit/** : Ce répertoire contient les tests unitaires de l'application. Les tests unitaires visent à tester des unités individuelles de code, comme des fonctions ou des méthodes de classe, de manière isolée. Ils ne dépendent pas d'autres parties de l'application et sont généralement rapides à exécuter.

- **vendor**: Contient les dépendances de l'application installées via Composer.

- **.env**: Fichier d'environnement contenant les variables d'environnement de l'application.

- **.env.testing**: Fichier d'environnement spécifique aux tests. Il est utilisé pour définir des variables d'environnement spécifiques à l'environnement de test, distinctes de celles définies dans le fichier .env principal.

- **phpunit.xml**: Le fichier phpunit.xml est un fichier de configuration pour PHPUnit, l'outil de test unitaire pour les applications PHP, y compris les applications Laravel. Ce fichier permet de définir divers paramètres de configuration pour les tests PHPUnit.
 Fichier de configuration pour PHPUnit, l'outil de test unitaire pour les applications PHP, y compris les applications Laravel. Il définit les paramètres de configuration nécessaires à l'exécution des tests PHPUnit, spécifiant les répertoires contenant les tests à exécuter, les fichiers sources à inclure dans les tests, et permettant la définition de variables d'environnement PHP spécifiques à l'exécution des tests.
