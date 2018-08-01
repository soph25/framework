<?php
namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use Framework\Actions\RouterAwareAction;
use Psr\Container\ContainerInterface;
use Framework\Renderer\RenderInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Framework\Router;
use League\Plates\Engine;
use Framework\Cache;

class BlogAction
{
    private $router;
    /**
     * @var RendererInterface
     */
    private $renderer;

    private $postTable;

    private $cache;

    private $container;

    use RouterAwareAction;

    public function __construct(Router $router, RenderInterface $renderer, ContainerInterface $container, PostTable $postTable, Cache $cache)
    {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->container = $container->get('plates');
        $this->postTable = $postTable;
        $this->cache = $cache;
    }

    public function __invoke(Request $request)
    {
       
      
        $slug = $request->getAttribute('id');
        
        if ($slug) {
            return $this->show($request);
        }
        return $this->index($request);
    }

    


    public function index(Request $request): string
    {
        $params = $request->getQueryParams();
        $posts = $this->postTable->findPaginated(12, $params['p'] ?? 1);
        //var_dump($this->cache->getCacheDir());
        //$this->cache->store('_blogindex', $this->container->render('index', ['name' => 'Jonathan', 'router' => $this->router, 'posts' => $posts]));
        //return $this->cache->retrieve('_blogindex');
        return $this->container->render('index', ['name' => 'Jonathan', 'router' => $this->router, 'posts' => $posts]);
    }

    public function show(Request $request)
    {
        $slug = $request->getAttribute('slug');
        $post = $this->postTable->find($request->getAttribute('id'));
        if ($post->slug !== $slug) {
            return $this->redirect('blog.show', [
                'slug' => $post->slug,
                'id' => $post->id
            ]);
        }
       
        return $this->container->render('show', [
            'post' => $post
        ]);
    }
}
