<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;

class Menu extends BaseController
{
    public function index()
    {
        return redirect()->to("/menu/menu1");
    }

    public function menu1()
    {
        return uview("usr/menu/menu1");
    }

    public function menu2()
    {
        return uview("usr/menu/menu2");
    }

}
