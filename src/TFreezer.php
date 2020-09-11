<?php

declare(strict_types=1);

namespace Jazz;

use Jazz\Exception\FrozenException;

trait TFreezer
{

    private bool $frozen = false;


    // MUTATOR METHODS
    /**
     * Freeze class (Read Only)
     * @postcondition is frozen
     */
    public function freeze(): void
    {
        $this->frozen = true;
    }

    /**
     * Verify if object is frozen
     * @throws FrozenException
     */
    protected function verifyFrozen(): void
    {
        if ($this->frozen()) {
            throw new FrozenException();
        }
    }


    // ACCESSOR METHODS
    /**
     * Returns if object is frozen
     * @return bool
     */
    public function frozen(): bool
    {
        return $this->frozen;
    }
}
