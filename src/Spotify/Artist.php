<?php

namespace HansOtt\SpotifyBackupper\Spotify;

use HansOtt\SpotifyBackupper\CastsToArray;

final class Artist implements CastsToArray
{
    private $id;

    private $name;

    private $uri;

    /**
     * Artist constructor.
     *
     * @param string $id
     * @param string $name
     * @param string $uri
     */
    public function __construct($id, $name, $uri)
    {
        $this->id = (string) $id;
        $this->name = (string) $name;
        $this->uri = (string) $uri;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'uri' => $this->uri,
        );
    }
}
