<?php
namespace Tests;

use Faker;
use Language\Config;
use Language\Helper\SaveFile;

class SaveFileTest extends \PHPUnit_Framework_TestCase
{

    private $faker;


    public function setUp()
    {
        $this->faker = Faker\Factory::create();
    }

    /**
     * @test
     * @group storefile
     */
    public function saveFileTest()
    {
        $dir = Config::get('system.paths.root') . '/tests/' . $this->faker->word . '/';
        $file = $this->faker->word . '.php';
        $file_and_path = $dir . $file;
        $fileContent = $this->faker->text($maxNbChars = 200);

        //save file
        $saveFile = new SaveFile($file_and_path);
        $saveFile->save($fileContent);

        $checkContent = file_get_contents($file_and_path);

        $this->assertEquals($checkContent, $fileContent);
        //after delete all of them
        unlink($file_and_path);
        rmdir($dir);
    }

    /**
     * @test
     * @group storefile
     */
    public function saveFailFileContentTest()
    {
        $dir = Config::get('system.paths.root') . '/tests/' . $this->faker->word . '/';
        $file = $this->faker->word . '.php';
        $file_and_path = $dir . $file;
        $fileContent = $this->faker->text($maxNbChars = 200);
        $anotherContent = $this->faker->sentence($nbWords = 2, $variableNbWords = true);

        //save file
        $saveFile = new SaveFile($file_and_path);
        $saveFile->save($fileContent);

        $checkContent = file_get_contents($file_and_path);

        $this->assertNotEquals($anotherContent, $checkContent);
        //after delete all of them
        unlink($file_and_path);
        rmdir($dir);
    }

/*    public function createFileTest()
    {

    }*/
}