<?php

namespace WebmanTech\Polyfill\Traits;

use InvalidArgumentException;
use WebmanTech\Polyfill\SymfonyUploadedFile;
use Webman\Http\Request;
use Webman\Http\UploadFile;

trait SymfonyRequestWrapper
{
    public static function wrapper(Request $request): self
    {
        $files = self::wrapperFiles($request->file());
        // 以下 SERVER 参数在 SymfonyRequest 中被使用到
        $server = [
            /**
             * 目前没有更好的获取办法，按道理可以通过 $request->connection->protocol 或 Workerman\Protocols\Http 来判断
             */
            'SERVER_PROTOCOL' => 'HTTP/1.1',
            'REMOTE_ADDR' => $request->getRemoteIp(),
            'SERVER_PORT' => $request->getLocalPort(),
            'QUERY_STRING' => $request->queryString(),
            /**
             * https://www.workerman.net/q/8167
             */
            'HTTPS' => $request->header('https') ?: $request->getLocalPort() == 443,
            'SERVER_NAME' => $request->getLocalIp(),
            'SERVER_ADDR' => $request->getLocalIp(),
            'REQUEST_METHOD' => strtoupper($request->method()),
            'REQUEST_URI' => $request->uri(),
        ];
        foreach ($request->header() as $key => $value) {
            $server['HTTP_' . str_replace('-', '_', strtoupper($key))] = $value;
        }

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
    public static function createFromGlobals()
    {
        throw new InvalidArgumentException('Not support');
    }

    private static function wrapperFiles(array $files)
    {
        return array_map(function ($file) {
            if ($file instanceof UploadFile) {
                return SymfonyUploadedFile::wrapper($file);
            }
            if (is_array($file)) {
                return self::wrapperFiles($file);
            }
            throw new InvalidArgumentException('file type error');
        }, $files);
    }
}
