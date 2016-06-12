<?php

namespace HansOtt\SpotifyBackupper\Client;

use HansOtt\SpotifyBackupper\Spotify\Track;
use HansOtt\SpotifyBackupper\Spotify\Playlist;

interface Client
{
    /**
     * Get the user's playlists.
     *
     * @param int $limit
     * @param int $offset
     * @param bool $includeCollaborative
     *
     * @return Playlist[]
     */
    public function getPlaylists($limit = 20, $offset = 0, $includeCollaborative = true);

    /**
     * Get the tracks of a playlist.
     *
     * @param Playlist $playlist
     * @param int $limit
     * @param int $offset
     *
     * @return Track[]
     */
    public function getPlaylistTracks(Playlist $playlist, $limit = 20, $offset = 0);

    /**
     * Get the user's saved tracks.
     *
     * @param int $limit
     * @param int $offset
     *
     * @return Track[]
     */
    public function getSavedTracks($limit = 20, $offset = 0);
}
