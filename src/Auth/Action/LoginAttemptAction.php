<?php
namespace App\Auth\Action;

use App\Auth\DatabaseAuth;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RenderInterface;
use Framework\Response\RedirectResponse;
use Framework\Router;
use Framework\Session\FlashService;
use Framework\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\RouterInterface;
use Psr\Container\ContainerInterface;
use Framework\Database\NoRecordException;
use Framework\Events\EventManager;
use App\Auth\Action\OnLoginEvent;

class LoginAttemptAction
{
    private $container;
    /**
     * @var RendererInterface
     */
    private $renderer;
    /**
     * @var DatabaseAuth
     */
    private $auth;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var RouterInterface
     */
    private $router;

    use RouterAwareAction;

    public function __construct(
        ContainerInterface $container,
        RenderInterface $renderer,
        Router $router,
        DatabaseAuth $auth,
        SessionInterface $session
    ) {
        $this->container = $container->get('lobin');
        $this->renderer = $renderer;
        $this->auth = $auth;
        $this->router = $router;
        $this->session = $session;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $params = $request->getParsedBody();
//$manager = new EventManager();
//$manager->attach('database.auth.login', function ($event) use ($manager){
//unlink($event->getTarget()->getImage());
//});
        try {
            $user = $this->auth->login($params['username'], $params['password']);
            //$manager->trigger(new OnLoginEvent($user));
            $path = $this->session->get('auth.redirect') ?: $this->router->generateUri('admin');
            $this->session->delete('auth.redirect');

            return new RedirectResponse($path);
        } catch (NoRecordException $exception) {
            (new FlashService($this->session))->error('Identifiant ou mot de passe incorrect');
            return $this->redirect('auth.login');
        }
    }
}
