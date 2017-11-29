<?php
namespace Language\Helper;

use Language\Helper\StoreFile;

class Storage
{
    use Constant;

    private $path;

    /**
     * Storage constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param $dir
     * @param $lang
     * @return \Language\Helper\StoreFile
     */
    public function storeCacheFile($dir, $lang): StoreFile
    {
        return new StoreFile($this->path . sprintf($this->PHP_FILE, $dir, $lang));
    }

    /**
     * @param $lang
     * @return \Language\Helper\StoreFile
     */
    public function storeAppletCacheFile($lang): StoreFile
    {
        return new StoreFile($this->path . sprintf($this->XML_FILE, $lang));
    }
}
