<?php
include('FileManagerInterface.php');

/**
 * Файл Менеджер
 */
class FileManager implements FileManagerInterface
{
    private $file;

    public function __construct()
    {

    }

    public function create($filePath, $mode)
    {
        $file = fopen($filePath, $mode);
        $fileObg = new FileText($file, $filePath);
        $this->setFile($fileObg);
        return $this->getFile();
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(File $file)
    {
        $this->file = $file;
    }

    public function delete(File $file)
    {
        return unlink($file->getFilePath());
    }
}





