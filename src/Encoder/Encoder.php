<?php

namespace HansOtt\SpotifyBackupper\Encoder;

interface Encoder
{
    public function encode(array $data);

    /**
     * Get the file extension.
     *
     * @return string
     */
    public function getFileExtension();
}
