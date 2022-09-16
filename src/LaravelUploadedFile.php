<?php

namespace Kriss\WebmanPolyfill;

use Illuminate\Http\UploadedFile;
use Webman\Http\UploadFile;

class LaravelUploadedFile extends UploadedFile
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