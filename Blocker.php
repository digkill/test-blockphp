<?php

/**
 * Блокератор
 */
class Blocker
{
    private $filePath;
    private $file;

    /**
     * @param    string $id Идентификатор блокировки
     */
    public function __construct($id)
    {
        $this->filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $id;
        $this->file = fopen($this->filePath, "a+");
    }


    /**
     * Пытается получить блокировку
     *
     * @return    boolean
     */
    public function open()
    {
        return $this->file && flock($this->file, LOCK_EX | LOCK_NB);
    }

    /**
     * Высвобождает блокировку
     *
     * @return    void
     */
    public function close()
    {
        flock($this->file, LOCK_UN);
        fclose($this->file);
    }

}


