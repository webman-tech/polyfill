<?php

namespace Kriss\WebmanPolyfill;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Webman\Http\UploadFile;

class SymfonyUploadedFile extends UploadedFile
{
    public static function wrapper(UploadFile $file, bool $test = false): self
    {
        return new self(
            $file->getRealPath(),
            $file->getUploadName(),
            $file->getUploadMineType(),
            $file->getUploadErrorCode(),
            $test
        );
    }
}