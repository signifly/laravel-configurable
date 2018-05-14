<?php

namespace Signifly\Configurable;

use Countable;
use ArrayAccess;
use Illuminate\Database\Eloquent\Model;

class Config implements ArrayAccess, Countable
{
    /**
     * The config db key.
     *
     * @var string|null
     */
    protected $configKey;

    /**
     * The config data.
     *
     * @var array
     */
    protected $data;

    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create a new Config instance.
     *
     * @param array $data
     */
    public function __construct(Model $model, $configKey = null)
    {
        $this->model = $model;

        $this->configKey = $configKey;

        $this->data = $model->{$this->getConfigKey()};
    }

    /**
     * Get an attribute from config.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return array_get($this->data, $key, $default);
    }

    /**
     * Determine if an attribute exists in config.
     *
     * @param  string  $key
     * @return boolean
     */
    public function has(string $key)
    {
        return array_has($this->data, $key);
    }

    /**
     * Set an attribute in config.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function set(string $key, $value)
    {
        array_set($this->data, $key, $value);

        $this->model->{$this->getConfigKey()} = $this->data;
    }

    /**
     * Remove an attribute from config.
     *
     * @param  string $key
     * @return bool
     */
    public function remove(string $key)
    {
        $this->model->{$this->getConfigKey()} = array_except($this->data, $key);

        return $this;
    }

    /**
     * Get all attributes from config.
     *
     * @return array
     */
    public function all()
    {
        return $this->model->{$this->getConfigKey()};
    }

    /**
     * Count attributes in config.
     *
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Get a specific attribute as a collection.
     *
     * @param  string $key
     * @return \Illuminate\Support\Collection
     */
    public function collect(string $key)
    {
        return collect($this->get($key));
    }

    /**
     * Get the config key.
     *
     * @return string
     */
    protected function getConfigKey()
    {
        return $this->configKey ?? $this->model->getConfigKey();
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

     /**
     * Get the value for a given offset.
     *
     * @param  string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * Set the value for a given offset.
     *
     * @param  string $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  string $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * Get an attribute from config.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Determine if an attribute exists in config.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->has($key);
    }

    /**
     * Set an attribute in config.
     *
     * @param string $key
     * @param bool $value
     */
    public function __set($key, $value)
    {
        return $this->set($key, $value);
    }

    /**
     * Remove an attribute from config.
     *
     * @param string $key
     */
    public function __unset($key)
    {
        return $this->remove($key);
    }
}
