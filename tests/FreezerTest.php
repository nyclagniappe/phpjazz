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
            public function modifyField(): void
            {
                $this->verifyFrozen('id');
            }
        };
    }


    // TEST METHODS
    /**
     * Test modification of frozen object
     */
    public function testModificationOfObject(): void
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

    /**
     * Test modification of frozen property
     */
    public function testModificationOfProperty(): void
    {
        $key = 'id';
        $fakeKey = 'fake';

        $obj = $this->myFreezer;
        self::assertFalse($obj->frozen());
        self::assertFalse($obj->frozen($key));
        self::assertFalse($obj->frozen($fakeKey));

        $obj->freeze($key);
        self::assertFalse($obj->frozen());
        self::assertTrue($obj->frozen($key));
        self::assertFalse($obj->frozen($fakeKey));

        $obj->modify();
        $obj->modify();

        $this->expectException(FrozenException::class);
        $obj->modifyField();
    }
}
