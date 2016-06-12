<?php

namespace HansOtt\SpotifyBackupper\BackupStorage;

final class BackupStorageLocal implements BackupStorage
{
    public function writeFile($filePath, $data)
    {
        file_put_contents($filePath, $data, LOCK_EX);
    }
}
