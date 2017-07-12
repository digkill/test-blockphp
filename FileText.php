<?php
include('File.php');

/**
 * Файл
 */
class FileText implements File
{
    private $file;
    private $filePath;

    public function __construct($file, $filePath)
    {
        $this->file = $file;
        $this->filePath = $filePath;

        return $this;
    }

    public function isExist()
    {
        return is_file($this->getFilePath());
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

    public function close()
    {
        if (!$this->isExist()) {
            return false;
        }

        return fclose($this->file);
    }

    public function write($body, $length = null)
    {
        if (!$this->isExist()) {
            return false;
        }

        $isLength = is_null($length);

        if (!$isLength) {
            $write = fwrite($this->file, $body, $length);
        } else {
            $write = fwrite($this->file, $body);
        }

        return $write;
    }

    public function truncate($size)
    {
        if (!$this->isExist()) {
            return false;
        }

        return ftruncate($this->file, $size);
    }


    public function flush()
    {
        if (!$this->isExist()) {
            return false;
        }

        return fflush($this->file);
    }

    public function lock($operation)
    {
        if (!$this->isExist()) {
            return false;
        }

        return flock($this->file, $operation);
    }

    public function getContent()
    {
        return file_get_contents($this->getFilePath());
    }
}





