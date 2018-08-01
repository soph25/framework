<?php
namespace App\Plate;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use App\Repository\ConversationRepository;
use Slim\Interfaces\RouterInterface;

class ReadAll implements ExtensionInterface
{
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
        //$this->cr = $cr;
    }

    public function addLink($ref, $url)
    {
        $this->_links[$ref] = $url;
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('readAllFrom', [$this, 'readAllFrom']);
    }

    public function readAllFrom(ConversationRepository $cr, int $userId, int $conv)
    {
    
        $messages =  $cr->getMessagesFor($userId, $conv);
        foreach ($messages as $message) {
         //var_dump($message['to_id']);
            if ($message['read_at'] === null && $message['to_id'] === $userId) {
                //$update = false;
                $message['read_at'] = "NOW()";
            }
            $update = false;
            return $cr->readAllFrom($update, $message['from_id'], $message['to_id']);
        }

         
        //return;
        //return $view->render($cr, function (int $page) use ($route, $routerParams, $queryArgs) {
            //if ($page > 1) {
                //$queryArgs['p'] = $page;
            //}
            //return $this->router->pathFor($route, $routerParams, $queryArgs);
        ///});
    }
}
