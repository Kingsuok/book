<?php

namespace App\Http\Controllers\View\Admin;
use Log;

class IndexController extends CommonController
{

    // to index interface
    public function toIndex()
    {
        return view('admin.index');
    }

}
