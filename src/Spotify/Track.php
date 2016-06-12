<?php

namespace HansOtt\SpotifyBackupper\Spotify;

use HansOtt\SpotifyBackupper\CastsToArray;

final class Track implements CastsToArray
{
    private $id;

    private $name;

    private $uri;

    private $artists;

    /**
     * Track constructor.
     *
     * @param string $id
     * @param string $name
     * @param string $uri
     * @param Artist[] $artists
     */
    public function __construct($id, $name, $uri, array $artists)
    {
        $this->id = (string) $id;
        $this->name = (string) $name;
        $this->uri = (string) $uri;
        $this->artists = $artists;
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

    public function getArtists()
    {
        return $this->artists;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'uri' => $this->uri,
            'artists' => array_map(function (Artist $artist) {
                return $artist->toArray();
            }, $this->getArtists()),
        );
    }
}
