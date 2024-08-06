<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;

class Summernote extends BaseController
{
    public function cleaner()
    {
        logMessage($this->request->getPost());
    }

}
