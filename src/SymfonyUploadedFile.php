<?php

namespace Kriss\WebmanPolyfill;

use Kriss\WebmanPolyfill\Traits\SymfonyUploadedFileWrapper;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SymfonyUploadedFile extends UploadedFile
{
    use SymfonyUploadedFileWrapper;
}
