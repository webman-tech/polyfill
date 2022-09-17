<?php

namespace WebmanTech\Polyfill;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use WebmanTech\Polyfill\Traits\LaravelComponentGetter;
use WebmanTech\Polyfill\Traits\SymfonyRequestWrapper;

class LaravelRequest extends Request
{
    use SymfonyRequestWrapper;
    use LaravelComponentGetter;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->registerValidation();
    }

    /**
     * @inheritDoc
     */
    protected function convertUploadedFiles(array $files)
    {
        return array_map(function (UploadedFile $file) {
            return LaravelUploadedFile::wrapper($file);
        }, parent::convertUploadedFiles($files));
    }

    /**
     * @see https://github.com/laravel/framework/blob/9.x/src/Illuminate/Foundation/Providers/FoundationServiceProvider.php
     * @see FoundationServiceProvider::registerRequestValidation()
     */
    protected function registerValidation()
    {
        if (!class_exists(Validator::class)) {
            return;
        }

        self::macro('validate', function (array $rules, ...$params) {
            /** @var ValidationFactory $validator */
            $validator = $this->getLaravelComponent('validation', ValidationFactory::class);
            return $validator->validate($this->all(), $rules, ...$params);
        });

        self::macro('validateWithBag', function (string $errorBag, array $rules, ...$params) {
            try {
                return $this->validate($rules, ...$params);
            } catch (ValidationException $e) {
                $e->errorBag = $errorBag;

                throw $e;
            }
        });
    }
}
