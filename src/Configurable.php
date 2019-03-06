<?php

namespace Signifly\Configurable;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

trait Configurable
{
    /**
     * Cached config instances.
     *
     * @var array
     */
    protected $cachedConfigs = [];

    /**
     * Get a Config value object.
     *
     * @return Config
     */
    public function config()
    {
        return $this->makeConfig($this, $this->getConfigKey());
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

    /**
     * Create a new Config instance.
     *
     * @param  Model  $model
     * @param  string $key
     * @return Config
     */
    protected function makeConfig(Model $model, string $key)
    {
        return Arr::get($this->cachedConfigs, $key, function () use ($key, $model) {
            return $this->cachedConfigs[$key] = new Config($model, $key);
        });
    }
}
