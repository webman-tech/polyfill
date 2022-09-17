<?php

namespace WebmanTech\Polyfill;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use WebmanTech\Polyfill\Traits\SymfonyRequestWrapper;

class LaravelRequest extends Request
{
    use SymfonyRequestWrapper;

    /**
     * @inheritDoc
     */
    protected function convertUploadedFiles(array $files)
    {
        return array_map(function (UploadedFile $file) {
            return LaravelUploadedFile::wrapper($file);
        }, parent::convertUploadedFiles($files));
    }
}
