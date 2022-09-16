<?php

namespace Kriss\WebmanPolyfill;

use Illuminate\Http\UploadedFile;
use Kriss\WebmanPolyfill\Traits\SymfonyUploadedFileWrapper;

class LaravelUploadedFile extends UploadedFile
{
    use SymfonyUploadedFileWrapper;
}
