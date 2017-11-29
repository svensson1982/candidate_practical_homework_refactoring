<?php
namespace Language\Helper;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class StoreFile
{
    use Constant;

    private $log;
    private $fileName;

    /**
     * StoreFile constructor.
     * @param $fileName
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
        $this->log = new Logger('store_file');
        $this->log->pushHandler(new StreamHandler(dirname(dirname(__DIR__)) . '/Log/error_store_file.log', Logger::ERROR));
    }

    /**
     * @param $data
     */
    public function storeFile($data)
    {
        $directory = dirname($this->fileName);
        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        try {
            $this->createFile($data);
        } catch (\Exception $e) {
            echo '<pre>' . $e->getMessage() . '</pre>';
            $this->log->error(sprintf($this->STORE_FILE_ERROR, $this->fileName, $directory));
        }
    }

    /**
     * @param $data
     * @throws \Exception
     */
    private function createFile($data)
    {
        if (strlen($data) !== file_put_contents($this->fileName, $data)) {
            throw new \Exception(sprintf($this->CREATE_FILE_ERROR, $this->fileName));
        }
    }
}
