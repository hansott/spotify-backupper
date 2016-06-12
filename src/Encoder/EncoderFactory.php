<?php

namespace HansOtt\SpotifyBackupper\Encoder;

use InvalidArgumentException;

final class EncoderFactory
{
    private $encoders = array();

    public function registerEncoder($format, Encoder $encoder)
    {
        $this->encoders[$format] = $encoder;
    }

    public function getEncoder($format)
    {
        if ($this->isSupported($format) === false) {
            throw new InvalidArgumentException(
                sprintf('No encoder defined for the format: "%s"', $format)
            );
        }

        return $this->encoders[$format];
    }

    public function isSupported($format)
    {
        return isset($this->encoders[$format]);
    }
}
