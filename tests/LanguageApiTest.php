<?php
namespace Tests;

use Faker;
use Language\ApiCall;
use Language\Helper\Constant;
use Language\LanguageBatchBo;
use Language\Helper\LanguageApi;

class LanguageApiTest extends \PHPUnit_Framework_TestCase
{
    use Constant;

    private $faker;
    private $languageApi;
    private $languageBatchBo;

    /**
     * @test
     */
    public function setUp()
    {
        $this->faker = Faker\Factory::create();
        $this->languageApi = new LanguageApi();
        //necessary applets array
        $this->languageBatchBo = new LanguageBatchBo();
    }

    /**
     * @param $function
     * @param $language
     * @return array
     */
    private function formatAsResultHelper($function, $language): array
    {
        return ApiCall::call(
            $this->SYSTEM_API,
            $this->LANGUAGE_API,
            [
                $this->SYSTEM => $this->LANGUAGE_FILES,
                $this->ACTION => $function
            ],
            $language
        );
    }

    /**
     * @test
     */
    public function getLanguageFileTest()
    {
        //fake application and language
        $application = $this->faker->domainWord;
        $language = $this->faker->languageCode;

        $getLanguageFile = $this->languageApi->getLanguageFile($application, $language);
        $formatAsResult = $this->formatAsResultHelper('getLanguageFile', $language);

        $this->assertNotEmpty($getLanguageFile);
        $this->assertInternalType('string', $getLanguageFile);
        $this->assertEquals($formatAsResult['data'], $getLanguageFile);
    }

    /**
     * @test
     * Because the available language is en..
     */
    public function getAppletLanguagesTest()
    {
        $getAppletLanguages = $this->languageApi->getAppletLanguages('en');

        $this->assertNotEmpty($getAppletLanguages);
        $this->assertInternalType('array', $getAppletLanguages);
        $this->assertEquals($getAppletLanguages[0], 'en');

    }

    /**
     * @test
     * Because the available language is en..
     */
    public function getAppletLanguageFileTest()
    {
        $appletKey = key($this->languageBatchBo->applets);
        $getAppletLanguageFile = $this->languageApi->getAppletLanguageFile($appletKey, 'en');
        $formatAsResult = $this->formatAsResultHelper('getAppletLanguageFile', 'en');

        $this->assertNotEmpty($getAppletLanguageFile);
        $this->assertInternalType('string', $getAppletLanguageFile);
        $this->assertEquals($formatAsResult['data'], $getAppletLanguageFile);
    }
}