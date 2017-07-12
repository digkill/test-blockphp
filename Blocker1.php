<?php

/**
 * Блокератор
 */
class Blocker
{
    const EXT_LOCK_FILE = '.pid';

    private $id;
    private $tmpDirectory;

    private $filePath;
    private $lock;

    private $fileManger;

    /**
     * @param string $id Идентификатор блокировки
     * @param FileManagerInterface $fileManager Файл Менеджер
     */
    public function __construct($id, FileManagerInterface $fileManager)
    {
        $this->id = $id;
        $this->tmpDirectory = sys_get_temp_dir();
        $this->filePath = $this->tmpDirectory . DIRECTORY_SEPARATOR . $this->id . self::EXT_LOCK_FILE;
        $this->fileManger = new FileManager();
    }

    public function isLock()
    {
        $this->lock = $this->isFileAndProcessActive();
        return $this->lock;
    }

    public function getLock()
    {
        return $this->lock;
    }

    /**
     * @return bool
     */
    public function setLock()
    {
        if ($this->isLock()) {
            return true;
        }

        try {
            $pid = getmypid();

            /**
             * @var File $file
             */
            $file = $this->fileManger->create($this->filePath, 'a');

            $file->truncate(0);
            $file->write($pid);
            $file->lock(LOCK_EX + LOCK_NB);
            $file->close();

        } catch (Exception $e) {
            echo 'Выброшено исключение: ', $e->getMessage(), "\n";
            exit(-1);
        }
    }


    /**
     * Пытается получить блокировку
     *
     * @return    boolean
     */
    public function open()
    {
        if ($this->isLock()) {
            return false;
        }

        $this->setLock();
        return true;
    }

    /**
     * Высвобождает блокировку
     *
     * @return    void
     */
    public function close()
    {
        /**
         * @var File $file
         */
        $file = $this->fileManger->create($this->filePath, 'r+');
        $file->flush();
        $file->lock(LOCK_UN);
        $file->close();

        $this->fileManger->delete($file);
    }

    private function isFileAndProcessActive()
    {
        /**
         * @var File $file
         */
        $file = $this->fileManger->create($this->filePath, 'r+');
        if ($file->isExist()) {
            $pid = intval($file->getContent());

            if (posix_kill($pid, 0)) {
                return true;
            } else {
                if (!$this->fileManger->delete($file)) {
                    exit(-1);
                }
            }
        }
        return false;
    }


}


