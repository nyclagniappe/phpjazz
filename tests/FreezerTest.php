<?php

declare(strict_types=1);

namespace JazzTest;

use Jazz\TFreezer;
use Jazz\Exception\FrozenException;

class FreezerTest extends AUnit
{

    private $myFreezer;

    /**
     * Set Up
     */
    public function setUp(): void
    {
        $this->myFreezer = new class {
            use TFreezer;

            public function modify(): void
            {
                $this->verifyFrozen();
            }
        };
    }


    // TEST METHODS
    /**
     * Test modification of frozen object
     */
    public function test(): void
    {
        $obj = $this->myFreezer;
        self::assertFalse($obj->frozen());

        $obj->modify();
        $obj->modify();

        self::assertFalse($obj->frozen());

        // freeze object
        $obj->freeze();
        self::assertTrue($obj->frozen());

        $this->expectException(FrozenException::class);
        $obj->modify();
    }
}
