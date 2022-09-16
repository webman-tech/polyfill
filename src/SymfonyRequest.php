<?php

namespace WebmanTech\Polyfill;

use WebmanTech\Polyfill\Traits\SymfonyRequestWrapper;
use Symfony\Component\HttpFoundation\Request;

class SymfonyRequest extends Request
{
    use SymfonyRequestWrapper;
}
