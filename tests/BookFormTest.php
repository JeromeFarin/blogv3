<?php

use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;
use Framework\Container;

class BookFormTest extends TestCase
{
    public function testHandleWithoutPOST()
    {
        $request = new ServerRequest();
        $container = new Container();
        $form = $container->get('Application\Form\BookForm');

        $form->handle($request);

        $this->assertIsObject($form);
    }

    public function testHandleWithPOST()
    {
        $request = new ServerRequest();
        $container = new Container();

        $request = $request->withMethod('POST');
        $request = $request->withParsedBody(['book' => ['name'=>'book_1','owner'=>'Denis']]);
        
        $form = $container->get('Application\Form\BookForm');
        
        $form->handle($request);

        $this->assertIsObject($form);

        return $request;
    }

    /**
     * @depends testHandleWithPOST
     */
    public function testHandleWithCover(ServerRequest $request)
    {
        $request = $request->withUploadedFiles(['book_cover' => 'dqzdqzdq']);

        dd($request);
    }
}
