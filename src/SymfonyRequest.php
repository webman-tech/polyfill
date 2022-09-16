<?php

namespace Kriss\WebmanPolyfill;

use Symfony\Component\HttpFoundation\Request;
use Webman\Http\UploadFile;

class SymfonyRequest extends Request
{
    public static function wrapper(\Webman\Http\Request $request): self
    {
        return new self(
            $request->get(),
            $request->post(),
            [],
            $request->cookie(),
            array_map(function (UploadFile $file) {
                return SymfonyUploadedFile::wrapper($file);
            }, $request->file()),
            [],
            $request->rawBody()
        );
    }
}