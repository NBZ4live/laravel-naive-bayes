<?php

namespace Tsuzukit\NaiveBayes\Facade;

use Illuminate\Support\Facades\Facade;

class NaiveBayes extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'naive_bayes';
    }

}
