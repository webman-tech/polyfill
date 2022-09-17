<?php

namespace WebmanTech\Polyfill;

use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use WebmanTech\Polyfill\Traits\LaravelComponentGetter;
use WebmanTech\Polyfill\Traits\SymfonyUploadedFileWrapper;

class LaravelUploadedFile extends UploadedFile
{
    use SymfonyUploadedFileWrapper;
    use LaravelComponentGetter;

    /**
     * 移除对 illuminate/container 的依赖
     * @inheritDoc
     */
    public function storeAs($path, $name, $options = [])
    {
        $options = $this->parseOptions($options);

        $disk = Arr::pull($options, 'disk');

        /** @var FilesystemFactory $filesystem */
        $filesystem = $this->getLaravelComponent('filesystem', FilesystemFactory::class);
        return $filesystem->disk($disk)->putFileAs(
            $path, $this, $name, $options
        );
    }
}
