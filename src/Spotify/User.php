<?php

namespace HansOtt\SpotifyBackupper\Spotify;

use HansOtt\SpotifyBackupper\CastsToArray;

final class User implements CastsToArray
{
    private $id;

    private $uri;

    /**
     * User constructor.
     *
     * @param string $id
     * @param string $uri
     */
    public function __construct($id, $uri)
    {
        $this->id = (string) $id;
        $this->uri = (string) $uri;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'uri' => $this->uri,
        );
    }
}
