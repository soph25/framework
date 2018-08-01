<?php

namespace App\Account\Action;

use App\Auth\DatabaseAuth;
use App\Auth\User;
use App\Auth\UserTable;
use Framework\Database\Hydrator;
use Framework\Renderer\RenderInterface;
use Framework\Response\RedirectResponse;
use Framework\Router;
use Framework\Session\FlashService;
use Framework\Validator;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;
use Framework\Actions\RouterAwareAction;
use Framework\Validator\ValidationError;
class SignupAction
{
    private $container;
    /**
     * @var RendererInterface
     */
    private $renderer;
    /**
     * @var UserTable
     */
    private $userTable;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var DatabaseAuth
     */
    private $auth;
    /**
     * @var FlashService
     */
    private $flashService;

    use RouterAwareAction;

    public function __construct(
        ContainerInterface $container,
        RenderInterface $renderer,
        UserTable $userTable,
        Router $router,
        DatabaseAuth $auth,
        FlashService $flashService
    ) {
        $this->container = $container->get('lobin');
        $this->renderer = $renderer;
        $this->userTable = $userTable;
        $this->router = $router;
        $this->auth = $auth;
        $this->flashService = $flashService;
    }

    public function __invoke(ServerRequestInterface $request)
    {

        if ($request->getMethod() === 'GET') {
            return $this->container->render('accountsignup');
        }
    //var_dump($request->getUri()->getPath());
    //var_dump($this->auth->getUser());
        $params = $request->getParsedBody();

        $validator = (new Validator($params))
            ->required('username', 'email', 'password', 'password_confirm')
            ->length('username', 5)
            ->email('email')
            ->confirm('password')
            ->length('password', 4)
            ->unique('username', $this->userTable)
            ->unique('email', $this->userTable);


        if ($validator->isValid()) {
            $userParams = [
                'username' => $params['username'],
                'email'    => $params['email'],
                'password' => password_hash($params['password'], PASSWORD_DEFAULT)
            ];


            $this->userTable->insert($userParams);
            $user = Hydrator::hydrate($userParams, User::class);
            $user->id = $this->userTable->getPdo()->lastInsertId();
            $this->auth->setUser($user);
            $this->flashService->success('Votre compte a bien été créé');
            return new RedirectResponse($this->router->generateUri('account.profile'));
        }
        $errors = $validator->getErrors();
        //$erreurs = $errors->__toString();
        $emailerreur = $errors['email']->__toString();
        $usernamerreur = $errors['username']->__toString();

        return $this->container->render('accountsignup', [
            'errors' => $errors,
            'user'   => [
                'username' => $params['username'],
                'email'    => $params['email']
            ]
        ]);

       
    }

        
    
}
