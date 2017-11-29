<?php
namespace Tests;

use Language\Config;
use Language\LanguageBatchBo;

class LanguageBatchBoTest extends \PHPUnit_Framework_TestCase
{

    private $languageBatchBo;

    /**
     * @test
     * setUp function
     */
    public function setUp(){
        $this->languageBatchBo = new LanguageBatchBo();
    }

    /**
     * @test
     * @group batchbo
     */
    public function generateLanguageFilesTest()
    {
        $this->languageBatchBo->generateLanguageFiles();
        $cache_path = Config::get('system.paths.root') . '/cache';

        $applications = Config::get('system.translated_applications');
        foreach ($applications as $application => $languages) {
            foreach ($languages as $language) {
                $file_path = $cache_path . '/' . $application . '/' . $language . '.php';
                $this->assertFileExists($file_path);
                $contents = file_get_contents($file_path);

                $this->assertNotEmpty($contents);
                $this->addToAssertionCount(2);
            }
        }

        $this->assertGreaterThan(0, $this->getNumAssertions());
    }

    /**
     * @test
     * @group batchbo
     */
    public function generateAppletLanguageXmlFiles()
    {
        //call
        $this->languageBatchBo->generateAppletLanguageXmlFiles();

        $flash_path = Config::get('system.paths.root') . '/cache/flash';

        foreach ($this->languageBatchBo->applets as $appletDirectory => $appletLanguageId) {
            $languages = $this->languageBatchBo->getLanguageApi()->getAppletLanguages($appletLanguageId);
            foreach ($languages as $language) {
                $file_path = $flash_path . '/lang_' . $language . '.xml';
                $this->assertFileExists($file_path);
                $contents = file_get_contents($file_path);

                $this->assertNotEmpty($contents);
                $this->addToAssertionCount(2);
            }
        }

        $this->assertGreaterThan(0, $this->getNumAssertions());
    }
}