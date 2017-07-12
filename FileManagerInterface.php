<?php

/**
 * Файл Менеджер
 */
interface FileManagerInterface
{

    public function __construct();

    public function create($filePath, $mode);

    public function getFile();

    public function setFile(File $file);

    public function delete(File $file);
}





