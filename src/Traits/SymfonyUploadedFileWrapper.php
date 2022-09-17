<?php

namespace WebmanTech\Polyfill\Traits;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Webman\Http\UploadFile;

trait SymfonyUploadedFileWrapper
{
    public static function wrapper($file, bool $test = false): self
    {
        if ($file instanceof UploadFile) {
            return new self(
                $file->getRealPath(),
                $file->getUploadName(),
                $file->getUploadMineType(),
                $file->getUploadErrorCode(),
                $test
            );
        }
        if ($file instanceof UploadedFile) {
            return new self(
                $file->getRealPath(),
                $file->getClientOriginalName(),
                $file->getClientMimeType(),
                $file->getError(),
                $test
            );
        }
        throw new \InvalidArgumentException('Not Support file type: ' . get_class($file));
    }
}
