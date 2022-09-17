<?php

namespace WebmanTech\Polyfill;

use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use support\Container;
use WebmanTech\Polyfill\Traits\SymfonyUploadedFileWrapper;

class LaravelUploadedFile extends UploadedFile
{
    use SymfonyUploadedFileWrapper;

    /**
     * 移除对 illuminate/container 的依赖
     * @inheritDoc
     */
    public function storeAs($path, $name, $options = [])
    {
        $options = $this->parseOptions($options);

        $disk = Arr::pull($options, 'disk');

        if (!Container::has(FilesystemFactory::class)) {
            // 必须先定义容器依赖
            throw new \InvalidArgumentException('must define dependence of ' . FilesystemFactory::class);
        }

        return Container::get(FilesystemFactory::class)->disk($disk)->putFileAs(
            $path, $this, $name, $options
        );
    }
}
