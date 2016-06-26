<?php

namespace HansOtt\SpotifyBackupper\Client;

use Buzz\Message\Request;
use Buzz\Message\Response;
use HansOtt\SpotifyBackupper\Spotify\User;
use InvalidArgumentException;
use Buzz\Client\ClientInterface;
use HansOtt\SpotifyBackupper\Spotify\Track;
use HansOtt\SpotifyBackupper\Spotify\Artist;
use HansOtt\SpotifyBackupper\Spotify\Playlist;
use HansOtt\SpotifyBackupper\Spotify\Album;

final class ClientBuzz implements Client
{
    const BASE_URI = 'https://api.spotify.com';

    private $client;

    private $accessToken;

    /**
     * ClientBuzz constructor.
     *
     * @param ClientInterface $client
     * @param string $accessToken
     */
    public function __construct(ClientInterface $client, $accessToken)
    {
        $this->client = $client;
        $this->accessToken = (string) $accessToken;
    }

    private function performRequest($endpoint, array $params = array())
    {
        $uri = static::BASE_URI . '/' . ltrim($endpoint, '/') . '?' . http_build_query($params);
        $request = new Request(Request::METHOD_GET, $uri);
        $request->addHeader(sprintf('Authorization: Bearer %s', $this->accessToken));
        $response = new Response();
        $this->client->send($request, $response);
        $content = $response->getContent();

        if ($response->getStatusCode() !== 200) {
            throw new InvalidArgumentException('An error occurred while calling the spotify API (' . $uri . '): ' . $content);
        }

        return json_decode($content, true);
    }

    public function getPlaylists($limit = 20, $offset = 0, $includeCollaborative = true)
    {
        $data = $this->performRequest(
            '/v1/me/playlists',
            array(
                'limit' => (int) $limit,
                'offset' => (int) $offset,
            )
        );

        $playlists = isset($data['items']) && is_array($data['items']) ? $data['items'] : array();

        $playlists = array_map(function (array $playlist) {
            $owner = new User($playlist['owner']['id'], $playlist['owner']['uri']);

            return new Playlist($playlist['id'], $playlist['name'], $playlist['uri'], $owner, $playlist['collaborative']);
        }, $playlists);

        $playlists = array_filter($playlists);

        return array_filter($playlists, function (Playlist $playlist) use ($includeCollaborative) {
            if ($includeCollaborative === false && $playlist->isCollaborative()) {
                return false;
            }

            return true;
        });
    }

    private function convertResponseToTracks($data)
    {
        $tracks = isset($data['items']) && is_array($data['items']) ? $data['items'] : array();

        return array_map(function (array $track) {
            $track = $track['track'];

            $artists = array_map(function (array $artist) {
                return new Artist($artist['id'], $artist['name'], $artist['uri']);
            }, $track['artists']);

            return new Track($track['id'], $track['name'], $track['uri'], $artists);
        }, $tracks);
    }

    public function getPlaylistTracks(Playlist $playlist, $limit = 20, $offset = 0)
    {
        $data = $this->performRequest(
            sprintf('/v1/users/%s/playlists/%s/tracks', $playlist->getOwner()->getId(), $playlist->getId()),
            array(
                'limit' => (int) $limit,
                'offset' => (int) $offset,
            )
        );

        return $this->convertResponseToTracks($data);
    }

    public function getSavedTracks($limit = 20, $offset = 0)
    {
        $data = $this->performRequest(
            '/v1/me/tracks',
            array(
                'limit' => (int) $limit,
                'offset' => (int) $offset,
            )
        );

        return $this->convertResponseToTracks($data);
    }

    public function getSavedAlbums($limit = 20, $offset = 0)
    {
        $data = $this->performRequest(
            '/v1/me/albums',
            array(
                'limit' => (int) $limit,
                'offset' => (int) $offset,
            )
        );

        return $this->convertResponseToAlbums($data);
    }

    private function convertResponseToAlbums($data)
    {
        $albums = isset($data['items']) && is_array($data['items']) ? $data['items'] : array();

        return array_map(function (array $album) {
            $album = $album['album'];

            $artists = array_map(function (array $artist) {
                return new Artist($artist['id'], $artist['name'], $artist['uri']);
            }, $album['artists']);

            return new Album($album['id'], $album['name'], $album['uri'], $artists);
        }, $albums);
    }
}
