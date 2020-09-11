<?php

declare(strict_types=1);

namespace Jazz;

use Jazz\Exception\FrozenException;

trait TFreezer
{

    private bool $frozen = false;
    private array $frozenKeys = [];


    // MUTATOR METHODS
    /**
     * Freeze class (Read Only)
     * @param string|null $key
     * @postcondition is frozen
     */
    public function freeze(string $key = null): void
    {
        ($key !== null)
            ? $this->frozenKeys[$key] = true
            : $this->frozen = true;
    }

    /**
     * Verify if object is frozen
     * @param string|null $key
     * @throws FrozenException
     */
    protected function verifyFrozen(string $key = null): void
    {
        if ($this->frozen($key)) {
            throw new FrozenException();
        }
    }


    // ACCESSOR METHODS
    /**
     * Returns if object is frozen
     * @param string|null $key
     * @return bool
     */
    public function frozen(string $key = null): bool
    {
        return ($key === null)
            ? $this->frozen
            : isset($this->frozenKeys[$key]);
    }
}
