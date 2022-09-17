<?php

use support\Container;

return [
    'enable' => true,
    'laravel' => [
        /**
         * 如果用到 Laravel UploadedFile 中的 store 或 storeAs 相关方法，需要提供 filesystemFactory 实现
         */
        'filesystem' => function () {
            return Container::get(\Illuminate\Contracts\Filesystem\Factory::class);
        },
        /**
         * 如果用到 Laravel Request 中的 validate，需要提供 validationFactory 实现
         */
        'validation' => function() {
            if (function_exists('validator')) {
                return validator();
            }
            return Container::get(\Illuminate\Contracts\Validation\Factory::class);
        }
    ],
];
