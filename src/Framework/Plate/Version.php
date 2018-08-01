<?php
namespace App\Plate;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use Pagerfanta\Pagerfanta;
use Slim\Interfaces\RouterInterface;

class Version implements ExtensionInterface
{
     public function __construct(RouterInterface $router)
    {
        $this->router = $router;
        
    }

    public function addLink($ref, $url)
    {
        $this->_links[$ref] = $url;
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('version', [$this, 'version']);
        
    }

     public function version($path)
    {
        
        if(file_exists($file = $_SERVER['DOCUMENT_ROOT'].$path)){
              $mtime = filemtime($file);
              $ext = substr($file, strrpos($file, '.'));
              return str_replace($ext, '-'. hash('md5',$mtime),$path) . $ext;   
        }
        return $path; 
          
    }
}
