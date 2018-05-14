<?php

namespace Signifly\Configurable;

trait Configurable
{
    /**
     * Get a Config value object.
     *
     * @param  array $value
     * @return \App\Models\ValueObjects\Config
     */
    public function config()
    {
        return new Config($this);
    }

    /**
     * Get the config database key.
     *
     * @return string
     */
    public function getConfigKey()
    {
        return 'config';
    }
}
