<?php

namespace WebmanTech\Polyfill;

use WebmanTech\Polyfill\Traits\SymfonyUploadedFileWrapper;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SymfonyUploadedFile extends UploadedFile
{
    use SymfonyUploadedFileWrapper;
}
