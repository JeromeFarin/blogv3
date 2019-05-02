<?php
namespace Application\Controller;

use Framework\Controller;

class AdminController extends Controller
{
    public function panel()
    {   
        return $this->render('admin.twig', array(
            'title' => 'Panel Admin'
        ));
    }
}
