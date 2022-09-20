# webman-tech/polyfill

webman 是基于 php-cli 的框架，这区别于传统的 php-fpm 框架，因此部分功能存在区别（比如 Http Request 信息的获取）

但是 packagist（composer 包）中有大部分的扩展是基于 `symfony/http-foundation` 的，如果不能使用的话会产生很多不便

因此本扩展的目标是使得 webman 下能快速使用如 SymfonyRequest 等类

## 安装

```bash
composer require webman-tech/polyfill
```

### 版本说明

由于 symfony>6 的版本使用 php8，且加强了类型返回，与 <6 版本的方法无法兼容，因此该包也必须做拆分

| webman-tech/polyfill | symfony | laravel |
| ---- | ---- | ---- |
| 1.x | 5.x | 8.x |
| 2.x | 6.x | 9.x |

## Symfony

```bash
composer require symfony/http-foundation
```

```php
namespace app\controller;

use support\Request;
use WebmanTech\Polyfill\SymfonyRequest;
use WebmanTech\Polyfill\SymfonyUploadedFile;

class FooController
{
    public function bar(Request $request) 
    {
        $symfonyRequest = SymfonyRequest::wrapper($request); // $symfonyRequest 此时所有功能同 `Symfony\Component\HttpFoundation\Request`
        $symfonyUploadedFile = SymfonyUploadedFile::wrapper($request->file('file')); // $symfonyUploadedFile 此时所有功能同 `Symfony\Component\HttpFoundation\File\UploadedFile`
    }
}
```

## Laravel

```bash
composer require illuminate/http
```

```php
namespace app\controller;

use support\Request;
use WebmanTech\Polyfill\LaravelRequest;
use WebmanTech\Polyfill\LaravelUploadedFile;

class FooController
{
    public function bar(Request $request) 
    {
        $laravelRequest = LaravelRequest::wrapper($request); // $laravelRequest 此时所有功能同 `Illuminate\Http\Request`
        $laravelUploadedFile = LaravelUploadedFile::wrapper($request->file('file')); // $laravelUploadedFile 此时所有功能同 `Illuminate\Http\UploadedFile`
    }
}
```
