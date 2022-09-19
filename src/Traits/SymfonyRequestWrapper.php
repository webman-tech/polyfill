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
     * 暂时移除，因为 symfony/http-foundation > 6.0 版本后该方法定义了类型返回，小于 6 的没有，暂时无法兼容
     * 后期升级到 8.0 支持后打开
     * @inheritDoc
     */
    /*public static function createFromGlobals()
    {
        throw new \InvalidArgumentException('Not support');
    }*/
}
