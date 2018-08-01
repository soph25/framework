<?php
namespace App\Admin;

use Framework\Renderer\RenderInterface;
use Psr\Container\ContainerInterface;

class DashboardAction
{

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var AdminWidgetInterface[]
     */
    private $widgets;

    private $container;

    public function __construct(RenderInterface $renderer, array $widgets, ContainerInterface $container)
    {
        $this->renderer = $renderer;
        $this->widgets = $widgets;
        $this->container = $container->get('badmin');
  
    }

    public function __invoke()
    {
        $widgets = array_reduce($this->widgets, function (string $html, AdminWidgetInterface $widget) {
            return $html . $widget->render();
        }, '');
        //var_dump($widgets);
        //die();
        return $this->container->render('admindashboard', compact('widgets'));
    }
}
