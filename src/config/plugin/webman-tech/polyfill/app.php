<?php

use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use support\Container;

return [
    'enable' => true,
    'laravel' => [
        /**
         * 如果用到 Laravel UploadedFile 中的 store 或 storeAs 相关方法，需要提供 filesystem 实现
         */
        'filesystem' => function () {
            return Container::get(FilesystemFactory::class);
        }
    ],
];
