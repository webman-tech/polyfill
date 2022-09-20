<?php

namespace WebmanTech\Polyfill;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use WebmanTech\Polyfill\Traits\SymfonyUploadedFileWrapper;

class SymfonyUploadedFile extends UploadedFile
{
    use SymfonyUploadedFileWrapper;
}
