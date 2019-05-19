<?php
namespace Application\Controller;

use Framework\Controller;

/**
 * Class AdminController
 * @package Application\Controller
 */
class AdminController extends Controller
{
    /**
     * Panel admin
     *
     * @return render
     */
    public function panel()
    {   
        return $this->render('admin.twig', array(
            'title' => 'Panel Admin'
        ));
    }
}
