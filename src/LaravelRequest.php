<?php

namespace WebmanTech\Polyfill;

use Illuminate\Http\Request;
use WebmanTech\Polyfill\Traits\SymfonyRequestWrapper;

class LaravelRequest extends Request
{
    use SymfonyRequestWrapper;
}
