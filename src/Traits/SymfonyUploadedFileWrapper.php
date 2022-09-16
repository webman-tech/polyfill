<?php

namespace Kriss\WebmanPolyfill\Traits;

use Webman\Http\UploadFile;

trait SymfonyUploadedFileWrapper
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
