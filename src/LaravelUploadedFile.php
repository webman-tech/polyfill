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
     * @var FilesystemFactory
     */
    protected $_filesystem;

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
        if (!$this->_filesystem) {
            $filesystem = config('plugin.webman-tech.polyfill.app.laravel.filesystem');
            if ($filesystem instanceof \Closure) {
                $this->_filesystem = call_user_func($filesystem);
            }
        }
        if (!$this->_filesystem instanceof FilesystemFactory) {
            throw new \InvalidArgumentException('filesystem Not ' . FilesystemFactory::class);
        }

        return $this->_filesystem->disk($disk)->putFileAs(
            $path, $this, $name, $options
        );
    }
}
