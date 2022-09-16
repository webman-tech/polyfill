<?php

namespace WebmanTech\Polyfill;

use Illuminate\Http\UploadedFile;
use WebmanTech\Polyfill\Traits\SymfonyUploadedFileWrapper;

class LaravelUploadedFile extends UploadedFile
{
    use SymfonyUploadedFileWrapper;
}
