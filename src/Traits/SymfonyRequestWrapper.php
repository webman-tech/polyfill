<?php

namespace WebmanTech\Polyfill\Traits;

use WebmanTech\Polyfill\SymfonyUploadedFile;
use Webman\Http\Request;
use Webman\Http\UploadFile;

trait SymfonyRequestWrapper
{
    public static function wrapper(Request $request): self
    {
        $files = array_map(function (UploadFile $file) {
            return SymfonyUploadedFile::wrapper($file);
        }, $request->file());
        $server = array_merge([
            'HTTP_HOST' => $request->host(),
            'REQUEST_URI' => $request->uri(),
        ], $_SERVER);

        $self = new self(
            $request->get(),
            $request->post(),
            [],
            $request->cookie(),
            $files,
            $server,
            $request->rawBody()
        );
        $self->headers->replace($request->header());
        return $self;
    }

    /**
     * @inheritDoc
     */
    public static function createFromGlobals(): static
    {
        throw new \InvalidArgumentException('Not support');
    }
}
