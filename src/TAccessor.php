<?php

declare(strict_types=1);

namespace Jazz;

trait TAccessor
{
    // ARRAY ACCESS METHODS
    /**
     * Offset SET
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * Offset UNSET
     * @param string $offset
     */
    public function offsetUnset($offset): void
    {
        $this->unset($offset);
    }

    /**
     * Offset GET
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Offset EXISTS
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }


    // MAGIC METHODS
    /**
     * Sets KEY to VALUE
     * @param string $key
     * @param mixed $value
     */
    public function __set(string $key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Unsets KEY
     * @param string $key
     */
    public function __unset(string $key)
    {
        $this->unset($key);
    }

    /**
     * Returns VALUE for KEY
     * @param string $key
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->get($key);
    }

    /**
     * Returns if KEY is defined
     * @param string $key
     * @return bool
     */
    public function __isset(string $key): bool
    {
        return $this->has($key);
    }
}
