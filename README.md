# framework
Tout en PSR 15 middlewares

Framework de base

requirements  : PHP 7.1 (version 7.1.19  employée)


La structure de base est construite sur :

Psr\Http\Message\ResponseInterface;
Psr\Http\Message\ServerRequestInterface;
Psr\Http\Server\MiddlewareInterface;
Psr\Http\Server\RequestHandlerInterface;

ces interfaces sont la base des middlewares qui assurent la mise en marche, le dispatching, le routing
et toutes les autres fonctions que l'on peut ajouter , comme l'authentification... etc   


ROUTER : "zendframework/zend-expressive-fastroute": "^3.0"

l'implémentation permet d'ajouter des middlewares soit directement pour toute l'application;
ex :  $app->pipe(TrailingSlashMiddleware::class) 

soit au niveau du routing: 

$router->get('/mon-profil', [LoggedInMiddleware::class, AccountAction::class], 'account.profile');
$router->post('/mon-profil', [LoggedInMiddleware::class, AccountEditAction::class]);



TEMPLATES : interface renderer => 
"zendframework/zend-expressive-template": "^2.0",
"zendframework/zend-expressive-platesrenderer": "^2.0",      ==> pour rendre du php avec League/Plates  


l'interface peut aussi prendre en charge TWIG
dans ce cas il faut charger twig à la place et modifier en conséquence les parties liées au rendu 
 
