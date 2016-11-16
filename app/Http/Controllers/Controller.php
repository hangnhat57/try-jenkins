<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function commonFunc() {

    }

    public function doSomething() {
        $this->commonFunc();
        for ($i = 0; $i <= 10; ++$i) {
            $i++;
        }
        return 'aaaa';
    }

    public function doOtherThing() {
        $this->commonFunc();
        for ($i = 0; $i <= 10; ++$i) {
            $i++;
        }
        return 'aaaa';
    }
}
