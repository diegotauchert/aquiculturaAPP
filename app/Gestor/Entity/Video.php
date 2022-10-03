<?php

namespace App\Gestor\Entity;

use Waynestate\Youtube\ParseId;

class Video
{
    private $video;
    private $id;

    public function __construct($anexo)
    {

        if ($anexo->video) {
            $this->video = $anexo->video;
            $this->id = ParseId::fromUrl($anexo->video);
        }

        return $this;
    }

    public function img(): String
    {
        $url = '';

        if ($this->video) {
            $url = "https://i.ytimg.com/vi/" . $this->id . "/0.jpg";
        }

        return $url;
    }

    public function player($autoPlay = 1): String
    {
        $url = '';

        if ($this->video) {
            $url = "https://www.youtube.com/embed/" . $this->id . "?autoplay=" . $autoPlay;
        }

        return $url;
    }

    public function getID(): String
    {
        return $this->id;
    }

    public function getURL(): String
    {
        return $this->video;
    }
}
