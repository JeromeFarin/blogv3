<?php

namespace Framework;

class FlashBag
{
    private $flash = [];

    public function getFlash()
    {
        $this->flash += $_SESSION['flash'];
        foreach ($this->flash as $value) {
            echo '<script type="text/javascript">',
                'newFlash(\'',$value,'\');',
                '</script>';
        }
        // $_SESSION['flash'] = '';
        echo '<script type="text/javascript">',
            'flash();',
            '</script>';
    }
}
