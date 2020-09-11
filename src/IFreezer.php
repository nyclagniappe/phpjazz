<?php

declare(strict_types=1);

namespace Jazz;

interface IFreezer
{

    // MUTATOR METHODS
    /**
     * Freeze class (Read Only)
     * @param string|null $key
     * @postcondition is frozen
     */
    public function freeze(string $key = null): void;



    // ACCESSOR METHODS
    /**
     * Returns if object is frozen
     * @param string|null $key
     * @return bool
     */
    public function frozen(string $key = null): bool;
}
