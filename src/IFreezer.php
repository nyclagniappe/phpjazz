<?php

declare(strict_types=1);

namespace Jazz;

interface IFreezer
{

    // MUTATOR METHODS
    /**
     * Freeze class (Read Only)
     * @postcondition is frozen
     */
    public function freeze();



    // ACCESSOR METHODS
    /**
     * Returns if object is frozen
     * @return bool
     */
    public function frozen(): bool;
}
