# Réalisation d'une api de blog avec laravel

le blog est une application qui va contenir des articles ecrits par un ou plusieurs auteurs.

## **Le blog offre les Fonctionnalités suivantes :**

1. **La gestion des utilisateurs**
    - Inscription.
    - Connection.
    - Modification des informations.
    - Deconnection.
    - creer des permissions.
    - attribution des roles.
    - creation du role admin avec les fonctionnalitees suivantes :
        - Suppressions des utilisateurs.
        - Suppressions des articles.
        - Creation des articles.
        - Modifier le rôle d’un utilisateur.
        - Modifier ses articles.
        - Pouvoir consulter l'ensemble des articles.
        - Pouvoir consulter l'ensemble des utilisateurs.
    - Creation du role redacteur avec les fonctionnalitées suivantes :
        - Creation des articles.
        - Suppressions de n'importe quelle articles.
        - Modifier ses articles.
        - Pouvoir consulter l'ensemble des articles.
    - Creation du role reader avec les fonctionnalitées suivantes :
        - Commenter les articles.
        - Rechercher les articles par titre.
        - Rechercher les articles par categories.
        - Pouvoir consulter l'ensemble des articles.

2. **La gestion des articles :**
    - Creation des articles.
    - Modification des articles.
    - Suppression des articles.
    - Voir les articles.

3. **La gestion des commentaires :**
    - Creation des commentaires.
    - Modification des commentaires.
    - Suppression des commentaires.
    - Voir des commentaires d'un article.

4. **La gestion des tags :**
    - Creation des tags.
    - Modification des tags.
    - Suppression des tags.
    - Voir des tags d'un article.

5. **La gestion des catégories :**
    - Creation des categories.
    - Modification des categories.
    - Suppression des categories.
    - Voir des categories d'un article.

6. **La gestion des likes :**
    - liker un article
    - annuler son like

7. **La gestion des recherches :**
    - Rechercher un article par tag.
    - Rechercher un article par auteur.
    - Rechercher un article par titre.
    - Rechercher un article par categorie.
    - Rechercher un article par contenu.


----


## **Explication des endpoints**

### **Les endpoints de la partie administration**

*N.B : Tous les endpoints de la partie administrateur sont prefixes par le mot "admin"* 

1. **Les endpoints pour gerer les utilisateurs**

    Comme endpoints pour gerer les utilisateurs nous avouns : 
    - La route : **Route::get('/user',[UsersController::class ,'index'])** , elle permet de recuperer tous les utilisateurs du blog.
    - La route : **Route::get('/user/{user}/show',[UsersController::class,'show'])** , elle permet de recuperer un utilisateurs precis.
    - La route : **Route::post('/user/{user}/update',[UsersController::class,'update'])** , elle permet de modifier les informations d'un utilisateur.
    - La route : **Route::delete('/user/{user}/destroy',[UsersController::class,'destroy'])** , elle permet de supprimer le compte d'un utilisateur.

2. **Les endpoints pour gerer les articles**

    Comme endpoints pour gerer les articles nous avouns : 
    - La route : **Route::get('/post',[ArticlesController::class ,'index'])** , elle permet de recuperer tous les articles du blog avec son auteur,sa categorie,ses commentaires,les likes ,le nombre de like et de commentaires.
    - La route : **Route::get('/post/{post}/show',[ArticlesController::class,'show'])** , elle permet de recuperer un articles du blog avec son auteur,sa categorie,ses commentaires,les likes ,le nombre de like et de commentaires.
    - La route : **Route::post('/post/{post}/{user}/update',[ArticlesController::class,'update'])** , elle permet de modifier les informations d'un article.
    - La route : **Route::delete('/post/{post}/{user}/destroy',[ArticlesController::class,'destroy'])** , elle permet de supprimer un article. 

3. **Les endpoints pour gerer les roles**

    Comme endpoints pour gerer les roles nous avouns : 
    - La route : **Route::get('/roles',[RolesController::class ,'index'])** , elle permet de recuperer tous les roles.
    - La route : **Route::delete('/role/{role}/destroy',[RolesController::class,'destroy'])** , elle permet de supprimer un role.

4. **Les endpoints pour gerer la recherche**

    Comme endpoints pour gerer la recherche nous avouns : 
    - La route : **Route::get('/search',[SearchAdminFormController::class ,'search'])** , elle permet de faire une recherche sur les articles par titre et par catégorie.

5. **Les endpoints pour gerer les commentaires**

    Comme endpoints pour gerer les commentaires nous avouns : 
    - La route : **Route::post('/comment/{post}',[CommentsController::class ,'store'])** , elle permet de faire des commentaires sur n'importe quelle article.


----


### **Les endpoints de la partie utilisateur**


1. **Les endpoints pour gerer les utilisateurs**

    Comme endpoints pour gerer les utilisateurs nous avouns : 
    - La route : **Route::post('/register',[UserController::class,'register'])** , elle permet a l'utilisateur de creer un compte.
    - La route : **Route::post('login',[UserController::class,'login'])** , elle permet a l'utilisateur de se connecter a son compte.
    - La route : **Route::post('logout',[UserController::class,'logout'])** , elle permet a l'utilisateur de se déconnecter de son compte.
    - La route : **Route::get('/users',[UserController::class,'index'])** , elle permet de recuperer tous les utilisateurs du blog.
    - La route : **Route::get('/users/show',[UserController::class,'show'])** , elle permet de recuperer un utilisateurs precis.
    - La route : **Route::post('/user/{user}/update',[UserController::class,'update'])** , elle permet a l'utilisateur de modifier ses informations.
    - La route : **Route::delete('/users/destroy',[UserController::class,'destroy'])** , elle permet a l'utilisateur de supprimer ses informations.

2. **Les endpoints pour gerer les articles**

    Comme endpoints pour gerer les articles nous avouns : 
    - La route : **Route::post('/register',[UserController::class,'register'])** , elle permet a l'utilisateur de creer un compte.
    - La route : **Route::post('login',[UserController::class,'login'])** , elle permet a l'utilisateur de se connecter a son compte.
    - La route : **Route::post('logout',[UserController::class,'logout'])** , elle permet a l'utilisateur de se déconnecter de son compte.
    - La route : **Route::get('/users',[UserController::class,'index'])** , elle permet de recuperer tous les utilisateurs du blog.
    - La route : **Route::get('/users/show',[UserController::class,'show'])** , elle permet de recuperer un utilisateurs precis.
    - La route : **Route::post('/user/{user}/update',[UserController::class,'update'])** , elle permet a l'utilisateur de modifier ses informations.
    - La route : **Route::delete('/users/destroy',[UserController::class,'destroy'])** , elle permet a l'utilisateur de supprimer ses informations.


3. **Les endpoints pour gerer les articles**

    Comme endpoints pour gerer les utilisateurs nous avouns : 

    - La route : **Route::get('/posts',[ArticleController::class,'index'])** , elle permet de recuperer tous les articles du blog avec son auteur,sa categorie,ses commentaires,les likes ,le nombre de like et de commentaires.
    - La route : **Route::get('/posts/{post}',[ArticleController::class,'show'])** , elle permet de recuperer un articles du blog avec son auteur,sa categorie,ses commentaires,les likes ,le nombre de like et de commentaires.
    - La route : **Route::post('/posts',[ArticleController::class,'store'])** , elle permet a un utilisateur de creer un article.
    - La route : **Route::post('/posts/{post}/update',[ArticleController::class,'update'])** , elle permet de modifier les informations d'un article.
    - La route : **Route::delete('/posts/{post}',[ArticleController::class,'destroy'])** , elle permet de supprimer un article. 


4. **Les endpoints pour gerer les commentaires**

    Comme endpoints pour gerer les commentaires nous avouns : 
        
    - La route : **Route::get('/comments/{post}',[CommentController::class,'index'])** , elle permet de recuperer tous les commentaires d'un article du blog.
    - La route : **Route::post('/comments/{post}',[CommentController::class,'store'])** , elle permet de creer un commentaire d'un article du blog.
    - La route : **Route::get('/comments/{comment}',[CommentController::class,'show'])** , elle permet de recuperer un article precis.
    - La route : **Route::post('/comments/{comment}/update',[CommentController::class,'update'])** , elle permet a l'utilisateur de modifier un commentaire.
    - La route : **Route::delete('/comments/{comment}',[CommentController::class,'destroy'])** , elle permet a l'utilisateur de supprimer son  commentaire.

5. **Les endpoints pour gerer les categories**

    Comme endpoints pour gerer les categories nous avouns : 
        
    - La route : **Route::get('/category',[CategoryController::class,'index'])** , elle permet de recuperer toutes les categories creees par un utilisateur pour les articles.
    - La route : **Route::post('/category',[CategoryController::class,'store'])** , elle permet de creer une categorie.
    - La route : **Route::get('/category/{category}',[CategoryController::class,'show'])** , elle permet de recuperer une categorie precise.
    - La route : **Route::post('/category/{category}/update',[CategoryController::class,'update'])** , elle permet a l'utilisateur de modifier une categorie.
    - La route : **Route::delete('/category/{category}/delete',[CategoryController::class,'destroy'])** , elle permet a l'utilisateur de supprimer une categorie.

6. **Les endpoints pour gerer les tags**

    Comme endpoints pour gerer les tags nous avouns : 
        
    - La route : **Route::get('/tags',[TagController::class,'index'])** , elle permet de recuperer toutes les tags crées par un utilisateur pour les articles.
    - La route : **Route::post('/tags',[TagController::class,'store'])** , elle permet de creer un tag.
    - La route : **Route::get('/tags/{tag}',[TagController::class,'show'])** , elle permet de recuperer un tag precise.
    - La route : **Route::post('/tags/{tag}/update',[TagController::class,'update'])** , elle permet a l'utilisateur de modifier un tag.
    - La route : **Route::delete('/tags/{tag}/delete',[TagController::class,'destroy'])** , elle permet a l'utilisateur de supprimer une categorie.

7. **Les endpoints pour gerer les recherches**

    Comme endpoints pour gerer les recherches nous avouns : 
        
    - La route : **Route::get('/searchs',[SearchController::class,'search'])** , elle permet de faire une recherche sur un article par titre,auteur,categorie,tag,contenu.

8. **Les endpoints pour gerer les likes**

    Comme endpoints pour gerer les likes nous avouns : 
        
    - La route : **Route::post('/posts/{post}/likes',[LikeController::class,'likeOrUnlike'])** , elle permet de faire un like ou de deliker.


----


## **Installation du projet** 

Pour utiliser l'application vous devez respecter les étapes suivantes :  

1. Telecharger l'application grace au lien github suivant : [DOWNLOAD API_BLOG](https://github.com/anague25/Create_Api_Blog/tree/Api_Blog_V1)
2. Installer et executer wampserver, vous pouvez telecharger wampserer grace au lien suivant : [DOWNLOAD WAMPSERVER](https://www.wampserver.com/en/download-wampserver-64bits/)
3. Creer une base de donnees ayant pour nom : ***laravel_api_blog***
4. Utiliser un terminal par exemple ***git bash*** pour acceder au repertoire de l'application 
5. Executer la commande ***php artisan migrate*** pour creer tout les tables du  projet dans la base de donnée
6. Telecharger et intaller ***postman***, vous pouvez le faire garce au lien suivant : [DOWNLOAD POSTMAN](https://www.postman.com/downloads/)
7. dans le repertoire du projet aller dans le dossier ***route*** puis ouvrer le fichier ***api.php*** et vous verez tous les endpoints de l'application 
8. Executer la commande ***php artisan serve*** pour demarrer l'application
9. Maintenant tout est pret pour utiliser l'application en testant les ***endpoints*** avec postman, Merci! 

