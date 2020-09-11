<?php

declare(strict_types=1);

namespace Jazz;

use Jazz\Exception\KeyUndefinedException;

interface IAccessor
{
    // MUTATOR METHODS
    /**
     * Sets KEY to VALUE
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, $value): void;

    /**
     * Unsets KEY
     * @param string $key
     * @throws KeyUndefinedException
     */
    public function unset(string $key): void;


    // ACCESSOR METHODS
    /**
     * Returns VALUE for KEY
     * @param string $key
     * @return mixed
     * @throws KeyUndefinedException
     */
    public function get(string $key);

    /**
     * Returns if KEY is defined
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;
}
