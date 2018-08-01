<?php
namespace App\Blog;

use Framework\Upload;

class PostUpload extends Upload
{

    protected $path = '/home/sophie/monp/public/uploads/posts';

    protected $formats = [
        'thumb' => [320, 180]
    ];
}
