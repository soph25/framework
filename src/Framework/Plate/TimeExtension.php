<?php
namespace Framework\Plate;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class TimeExtension implements ExtensionInterface
{


    public function register(Engine $engine)
    {
        $engine->registerFunction('ago', [$this, 'ago']);
    }
    

    public function aga(\DateTime $date, string $format = 'd/m/Y H:i')
    {
        return '<span class="timeago" datetime="' . $date->format(\DateTime::ISO8601) . '">' .
            $date->format($format) .
            '</span>';
    }

    public function ago($datetime, $full = false)
    {
    $now = new \DateTime;
    $ago = new \DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'année',
        'm' => 'moi',
        'w' => 'week',
        'd' => 'day',
        'h' => 'heure',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    //return $string ? implode(', ', $string) . '' : 'just now';
    return 'il y a ' . implode(', ', $string) .  ( implode(', ', $string) > 1 ? '' : '' ) . '  environ';
    }
}
