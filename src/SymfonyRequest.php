<?php

namespace Kriss\WebmanPolyfill;

use Kriss\WebmanPolyfill\Traits\SymfonyRequestWrapper;
use Symfony\Component\HttpFoundation\Request;

class SymfonyRequest extends Request
{
    use SymfonyRequestWrapper;
}
