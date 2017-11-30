<?php
namespace Language\Helper;

use Language\Helper\SaveFile;

class Storage
{

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
     * @param $pattern
     * @param $dir
     * @param $lang
     * @return SaveFile
     */
    public function storeCacheFile($pattern, $dir, $lang): SaveFile
    {
        return new SaveFile($this->path . sprintf($pattern, $dir, $lang));
    }

    /**
     * @param $pattern
     * @param $lang
     * @return \Language\Helper\SaveFile
     */
    public function storeAppletCacheFile($pattern, $lang): SaveFile
    {
        return new SaveFile($this->path . sprintf($pattern, $lang));
    }
}
