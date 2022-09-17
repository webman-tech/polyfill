<?php

namespace WebmanTech\Polyfill\Traits;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Webman\File;
use Webman\Http\UploadFile;

trait SymfonyUploadedFileWrapper
{
    public static function wrapper($file, bool $test = false): self
    {
        if ($file instanceof UploadFile) {
            $self = new self(
                $file->getRealPath(),
                $file->getUploadName(),
                $file->getUploadMineType(),
                $file->getUploadErrorCode(),
                $test
            );
        } elseif ($file instanceof UploadedFile) {
            $self = new self(
                $file->getRealPath(),
                $file->getClientOriginalName(),
                $file->getClientMimeType(),
                $file->getError(),
                $test
            );
        } else {
            throw new \InvalidArgumentException('Not Support file type: ' . get_class($file));
        }

        return $self->withOriginFile($file);
    }

    protected $_originFile;

    protected function withOriginFile($file): self
    {
        $this->_originFile = $file;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isValid()
    {
        // webman 下不能使用 is_uploaded_file 校验
        return \UPLOAD_ERR_OK === $this->getError();
    }

    /**
     * @inheritDoc
     */
    public function move(string $directory, string $name = null)
    {
        // 使用 webman 的文件移动功能
        $file = $this->_originFile instanceof UploadFile
            ? $this->_originFile
            : new File($this->getRealPath());
        $name = $name ?: $this->getClientOriginalName();

        return $file->move(rtrim($directory, '/\\') . DIRECTORY_SEPARATOR . $name);
    }
}
