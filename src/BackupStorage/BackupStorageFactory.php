<?php

namespace HansOtt\SpotifyBackupper\BackupStorage;

use Closure;
use InvalidArgumentException;

final class BackupStorageFactory
{
    private $storageConstructors = array();

    public function registerStorage($storageKey, Closure $constructor)
    {
        $this->storageConstructors[$storageKey] = $constructor;
    }

    private function assertInstanceOfBackupStorage($backupStorage)
    {
        if (!$backupStorage instanceof BackupStorage) {
            throw new InvalidArgumentException(
                sprintf(
                    'The backup storage constructor returned an instance of "%s" but expected "%s".',
                    is_object($backupStorage) ? get_class($backupStorage) : gettype($backupStorage),
                    BackupStorage::class
                )
            );
        }
    }

    public function createStorage($storageKey)
    {
        if ($this->isSupported($storageKey) === false) {
            throw new InvalidArgumentException(
                sprintf('No backup storage defined for the storage key: "%s"', $storageKey)
            );
        }

        $constructor = $this->storageConstructors[$storageKey];
        $backupStorage = $constructor();
        $this->assertInstanceOfBackupStorage($backupStorage);

        return $backupStorage;
    }

    public function isSupported($storageKey)
    {
        return isset($this->storageConstructors[$storageKey]);
    }
}
