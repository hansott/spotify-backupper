<?php

namespace HansOtt\SpotifyBackupper;

use HansOtt\SpotifyBackupper\Client\Client;
use HansOtt\SpotifyBackupper\Spotify\Track;
use HansOtt\SpotifyBackupper\Spotify\Album;
use HansOtt\SpotifyBackupper\Encoder\Encoder;
use HansOtt\SpotifyBackupper\BackupStorage\BackupStorage;

final class Backupper
{
    private $client;

    private $encoder;

    private $backupStorage;

    public function __construct(Client $client, Encoder $encoder, BackupStorage $backupStorage)
    {
        $this->client = $client;
        $this->encoder = $encoder;
        $this->backupStorage = $backupStorage;
    }

    public function backup($includeCollaborative = true)
    {
        echo 'Getting playlists...' . PHP_EOL;

        $limit = 50;
        $offset = 0;
        $allPlaylists = [];

        do {
            $playlists = $this->client->getPlaylists($limit, $offset, $includeCollaborative);
            $allPlaylists = array_merge($allPlaylists, $playlists);
            $fetched = count($playlists);
            $offset += $limit;
        } while ($fetched === $limit);

        foreach ($allPlaylists as $playlist) {
            echo sprintf('Getting tracks for playlist "%s"...', $playlist->getName()) . PHP_EOL;

            $limit = 50;
            $offset = 0;
            $allTracks = [];

            do {
                $tracks = $this->client->getPlaylistTracks($playlist, $limit, $offset);
                $allTracks = array_merge($allTracks, $tracks);
                $fetched = count($tracks);
                $offset += $limit;
            } while ($fetched === $limit);

            $data = $playlist->toArray();
            $data['tracks'] = array_map(function (Track $track) {
                return $track->toArray();
            }, $allTracks);

            $data = $this->encoder->encode($data);
            $filePath = sprintf('%s-%s.%s', date('Y-m-d'), $playlist->getId(), $this->encoder->getFileExtension());
            $this->backupStorage->writeFile($filePath, $data);
            echo sprintf('Created backup of playlist "%s".', $playlist->getName()) . PHP_EOL;
        }

        echo 'Getting saved tracks...' . PHP_EOL;

        $limit = 50;
        $offset = 0;
        $allTracks = [];

        do {
            $tracks = $this->client->getSavedTracks($limit, $offset);
            $allTracks = array_merge($allTracks, $tracks);
            $fetched = count($tracks);
            $offset += $limit;
        } while ($fetched === $limit);

        $data = array_map(function (Track $track) {
            return $track->toArray();
        }, $allTracks);

        $data = $this->encoder->encode($data);
        $filePath = sprintf('saved-tracks-%s.%s', date('Y-m-d'), $this->encoder->getFileExtension());
        $this->backupStorage->writeFile($filePath, $data);
        echo 'Created backup of saved tracks.' . PHP_EOL;

        echo 'Getting saved albums...' . PHP_EOL;

        $limit = 50;
        $offset = 0;
        $allAlbums = [];

        do {
            $albums = $this->client->getSavedAlbums($limit, $offset);
            $allAlbums = array_merge($allAlbums, $albums);
            $fetched = count($albums);
            $offset += $limit;
        } while ($fetched === $limit);

        $data = array_map(function (Album $album) {
            return $album->toArray();
        }, $allAlbums);

        $data = $this->encoder->encode($data);
        $filePath = sprintf('saved-albums-%s.%s', date('Y-m-d'), $this->encoder->getFileExtension());
        $this->backupStorage->writeFile($filePath, $data);
        echo 'Created backup of saved albums.' . PHP_EOL;

        echo 'Finished' . PHP_EOL;
    }
}
