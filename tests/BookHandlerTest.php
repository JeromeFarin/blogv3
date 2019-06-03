<?php

use PHPUnit\Framework\TestCase;
use Framework\Container;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\UriFactory;
use Application\Manager\BookManager;

class BookHandlerTest extends TestCase
{
    private $handler;

    public function testConstructorBookHAndler()
    {
        $container = new Container();
        $this->handler = $container->get('Application\Handler\BookHandler');
        $this->assertIsObject($this->handler);
    }

    public function testOneReturn()
    {        
        $request = new ServerRequest();
        $uri = new UriFactory();
        $container = new Container();
        $manager = new BookManager();
        
        $request = $request->withUri($uri->createUri()->withPath('/book/3'));
        
        $handler = $container->get('Application\Handler\BookHandler');
        
        // dd($manager->getPdo());
        $handler->one($request);

        $this->assertIsObject($handler);
    }
}
