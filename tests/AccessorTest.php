<?php

declare(strict_types=1);

namespace JazzTest;

use ArrayAccess;
use Jazz\IAccessor;
use Jazz\TAccessor;
use Jazz\Exception\KeyUndefinedException;

class AccessorTest extends AUnit
{
    private $myClass;

    /**
     * Set Up
     */
    public function setUp(): void
    {
        $this->myClass = new class implements IAccessor, ArrayAccess
        {
            use TAccessor;

            private array $data = [];

            public function set(string $key, $value): void
            {
                $this->data[$key] = $value;
            }
            public function unset(string $key): void
            {
                $this->verify($key);
                unset($this->data[$key]);
            }
            public function get(string $key)
            {
                $this->verify($key);
                return $this->data[$key];
            }
            public function has(string $key): bool
            {
                return array_key_exists($key, $this->data);
            }
            private function verify(string $key): void
            {
                if (!array_key_exists($key, $this->data)) {
                    throw new KeyUndefinedException($key);
                }
            }
        };
    }


    // TEST METHODS
    /**
     * Test direct method operations
     * @throws KeyUndefinedException
     */
    public function testAccessorMethodOperations(): void
    {
        $key = 'id';
        $val = 'test';
        $obj = $this->myClass;

        self::assertFalse($obj->has($key));

        $obj->set($key, $val);
        self::assertTrue($obj->has($key));
        self::assertEquals($val, $obj->get($key));

        $obj->unset($key);
        self::assertFalse($obj->has($key));
    }

    /**
     * Test array access operations
     */
    public function testArrayAccessOperations(): void
    {
        $key = 'id';
        $val = 'test';
        $obj = $this->myClass;

        self::assertFalse(isset($obj[$key]));

        $obj[$key] = $val;
        self::assertTrue(isset($obj[$key]));
        self::assertEquals($val, $obj[$key]);

        unset($obj[$key]);
        self::assertFalse(isset($obj[$key]));
    }

    /**
     * Test magic property operations
     */
    public function testMagicPropertyOperations(): void
    {
        $val = 'test';
        $obj = $this->myClass;

        self::assertFalse(isset($obj->id));

        $obj->id = $val;
        self::assertTrue(isset($obj->id));
        self::assertEquals($val, $obj->id);

        unset($obj->id);
        self::assertFalse(isset($obj->id));
    }


    /**
     * Test failure to access non-existent property
     */
    public function testFailToAccessNonExistentProperty(): void
    {
        $this->expectException(KeyUndefinedException::class);
        $obj = $this->myClass;
        $obj->id;
    }

    /**
     * Test failure to remove non-existent property
     */
    public function testFailToUnsetNonExistentProperty(): void
    {
        $this->expectException(KeyUndefinedException::class);
        $obj = $this->myClass;
        unset($obj->id);
    }
}
