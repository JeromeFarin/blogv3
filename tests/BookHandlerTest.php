<?php

use PHPUnit\Framework\TestCase;
use Framework\Container;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\UriFactory;

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
        
        $request = $request->withUri($uri->createUri()->withPath('/book/3'));
        
        $handler = $container->get('Application\Handler\BookHandler');
        
        $handler->one($request);

        $this->assertIsObject($handler);
    }

    public function testListReturn()
    {
        $request = new ServerRequest();
        $uri = new UriFactory();
        $container = new Container();
        
        $request = $request->withUri($uri->createUri()->withPath('/book/3'));
        
        $handler = $container->get('Application\Handler\BookHandler');
        
        $handler->list($request);

        $this->assertIsObject($handler);
    }

    public function testListDoneReturn()
    {
        $request = new ServerRequest();
        $uri = new UriFactory();
        $container = new Container();
        
        $request = $request->withUri($uri->createUri()->withPath('/book/3'));
        
        $handler = $container->get('Application\Handler\BookHandler');
        
        $handler->listDone($request);

        $this->assertIsObject($handler);
    }
}
