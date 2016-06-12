<?php

namespace HansOtt\SpotifyBackupper\BackupStorage;

use Dropbox\Client;
use Dropbox\WriteMode;

final class BackupStorageDropbox implements BackupStorage
{
    private $client;

    /**
     * BackupStorageDropbox constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function writeFile($filePath, $data)
    {
        $filePath = '/' . ltrim($filePath, '/');
        $this->client->uploadFileFromString($filePath, WriteMode::force(), $data);
    }
}
