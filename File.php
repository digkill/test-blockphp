<?php

/**
 * Файл
 */
interface File
{
    public function __construct($file, $filePath);

    public function isExist();

    public function getFilePath();

    public function setFilePath($filePath);

    public function close();

    public function write($body, $length = null);

    public function truncate($size);

    public function flush();

    public function lock($operation);

    public function getContent();

}





