<?php
namespace Framework\Plate;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;


/**
 * Série d'extensions concernant les textes
 *
 * @package Framework\Twig
 */
class TextExtension implements ExtensionInterface
{

     public function register(Engine $engine)
    {
        $engine->registerFunction('excerpt', [$this, 'excerpt']);
        $engine->registerFunction('limit', [$this, 'limit']); 
    }

     public function limit(string $content, int $maxLength = 20): string
    {
        if (mb_strlen($content) > $maxLength) {
            $excerpt = mb_substr($content, 0, $maxLength);
            $lastSpace = mb_strrpos($excerpt, ' ');
            return mb_substr($excerpt, 0, $lastSpace) . '...';
        }
        return $content;
    }
    /**
     * Renvoie un extrait du contenu
     * @param string $content
     * @param int $maxLength
     * @return string
     */
    public function excerpt(string $content, int $maxLength = 50): string
    {
        if (mb_strlen($content) > $maxLength) {
            $excerpt = mb_substr($content, 0, $maxLength);
            $lastSpace = mb_strrpos($excerpt, ' ');
            return mb_substr($excerpt, 0, $lastSpace) . '...';
        }
        return $content;
    }
}
