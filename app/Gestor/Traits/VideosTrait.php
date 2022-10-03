<?php

namespace App\Gestor\Traits;

use App\Gestor\Entity\Video;

/**
 * Method videos
 */
trait VideosTrait
{

    public function video(): Video
    {
        $video = new Video($this);

        return $video;
    }

}
