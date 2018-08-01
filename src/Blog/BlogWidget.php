<?php

namespace App\Blog;

use App\Admin\AdminWidgetInterface;
use App\Blog\Table\PostTable;
use Framework\Renderer\RenderInterface;
use Psr\Container\ContainerInterface;

class BlogWidget implements AdminWidgetInterface
{
    private $container;
    /**
     * @var RendererInterface
     */
    private $renderer;
    /**
     * @var PostTable
     */
    private $postTable;

    public function __construct(RenderInterface $renderer, PostTable $postTable, ContainerInterface $container)
    {
        $this->renderer = $renderer;
        $this->postTable = $postTable;
        $this->container = $container->get('badmin');
    }

    public function render(): string
    {
        $count = $this->postTable->count();
        return $this->container->render('blogadminwidget', compact('count'));
    }

    public function renderMenu(): string
    {
        //return $this->container->render('blogadminmenu');
    }
}
