<?php

namespace HansOtt\SpotifyBackupper\Spotify;

use HansOtt\SpotifyBackupper\CastsToArray;

final class Playlist implements CastsToArray
{
    private $id;

    private $name;

    private $uri;

    private $owner;

    private $isCollaborative;

    /**
     * Playlist constructor.
     *
     * @param string $id
     * @param string $name
     * @param string $uri
     * @param User $owner
     * @param bool $isCollaborative
     */
    public function __construct($id, $name, $uri, User $owner, $isCollaborative)
    {
        $this->id = (string) $id;
        $this->name = (string) $name;
        $this->uri = (string) $uri;
        $this->owner = $owner;
        $this->isCollaborative = (bool) $isCollaborative;
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

    public function getOwner()
    {
        return $this->owner;
    }

    public function isCollaborative()
    {
        return $this->isCollaborative;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'uri' => $this->uri,
            'owner' => $this->owner->toArray(),
            'is_collaborative' => $this->isCollaborative,
        );
    }
}
