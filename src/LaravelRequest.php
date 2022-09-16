<?php

namespace Kriss\WebmanPolyfill;

use Illuminate\Http\Request;
use Kriss\WebmanPolyfill\Traits\SymfonyRequestWrapper;

class LaravelRequest extends Request
{
    use SymfonyRequestWrapper;
}
