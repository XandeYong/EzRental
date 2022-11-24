<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DailyTaskController extends Controller
{
    public function __construct()
    {
        //call daily function here
        $this->example();

    }

    //put daily function here
    public function example() {
        echo "i am being executed. [example]";
    }

}
