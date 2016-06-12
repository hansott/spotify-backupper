<?php

namespace HansOtt\SpotifyBackupper\Encoder;

final class EncoderJson implements Encoder
{
    public function encode(array $data)
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function getFileExtension()
    {
        return 'json';
    }
}
