<?php

use PHPUnit\Framework\TestCase;
use Framework\Container;

class BookHandlerTest extends TestCase
{
    public function testConstructor()
    {
        $container = new Container();
        $handler = $container->get('Application\Handler\BookHandler');
        $this->assertIsObject($handler);
    }
}
