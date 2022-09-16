<?php

namespace Kriss\WebmanPolyfill;

use Symfony\Component\HttpFoundation\File\File;

class SymfonyFile extends File
{
    public static function wrapper(\Webman\File $file, bool $checkPath = true): self
    {
        return new self(
            $file->getRealPath(),
            $checkPath
        );
    }
}