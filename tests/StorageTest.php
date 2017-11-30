<?php
namespace Tests;

use Faker;
use Language\Config;
use Language\Helper\SaveFile;
use Language\Helper\Storage;

class StorageTest extends \PHPUnit_Framework_TestCase
{

    private $dir;
    private $file;
    private $lang;
    private $faker;
    private $storage;

    public function setUp()
    {
        $this->faker = Faker\Factory::create();
        $this->lang = $this->faker->languageCode;
        $this->dir = Config::get('system.paths.root') . '/tests';
        $this->file = $this->faker->word;
        $this->storage = new Storage($this->dir);
    }

    /**
     * @test
     */
    public function storeCacheFileTest()
    {
        $pattern = '/%s/%s.php';
        $file_and_path = $this->dir . '/' . $this->lang . '/' . $this->file . '.php';
        $result_1 = $this->storage->storeCacheFile($pattern, $this->lang, $this->file);
        $result_2 = new SaveFile($file_and_path);

        $this->assertEquals($result_1, $result_2);
    }

    /**
     * @test
     */
    public function storeAppletCacheFileTest()
    {
        $pattern = '/lang_%s.xml';
        $file_and_path = $this->dir . '/lang_' . $this->lang. '.xml';
        $result_1 = $this->storage->storeAppletCacheFile($pattern, $this->lang);
        $result_2 = new SaveFile($file_and_path);

        $this->assertEquals($result_1, $result_2);
    }
}