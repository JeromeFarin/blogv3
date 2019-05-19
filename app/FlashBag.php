<?php

namespace Framework;

class FlashBag
{
    private $flash = [];

    public function getFlash()
    {
        if (isset($_SESSION['flash']) && !empty($_SESSION['flash'])) {
            if (isset($_SESSION['flash']['set']) && !empty($_SESSION['flash']['set'])) {
                unset($_SESSION['flash']['set']);
            } else {
                foreach ($_SESSION['flash'] as $key => $value) {
                    $this->flash[$key]= $value;
                }
                unset($_SESSION['flash']);
            }
        }
        foreach ($this->flash as $value) {
            echo '<script type="text/javascript">',
                'newFlash(\'',$value,'\');',
                '</script>';
        }

        echo '<script type="text/javascript">',
            'flash();',
            '</script>';
    }

    public function setFlash(array $values)
    {
        unset($_SESSION['flash']);
        foreach ($values as $key => $value) {
            $_SESSION['flash'][$key] = $value;
        }
        $_SESSION['flash']['set'] = true;
    }
}
