<?php

namespace HansOtt\SpotifyBackupper\BackupStorage;

interface BackupStorage
{
    /**
     * Create a file.
     *
     * @param string $filePath
     * @param string $data
     */
    public function writeFile($filePath, $data);
}
