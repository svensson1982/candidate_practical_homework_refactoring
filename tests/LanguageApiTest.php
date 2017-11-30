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
     * @group langapi
     */
    public function setUp()
    {
        $this->faker = Faker\Factory::create();
        $this->languageApi = new LanguageApi();
        //necessary applets array
        $this->languageBatchBo = new LanguageBatchBo();
    }

    /**
     * @return array
     * @param $function
     * @param $language
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
     * @group langapi
     */
    public function getLanguageFileTest()
    {
        //fake application and language
        $application = $this->faker->domainWord;
        $language = $this->faker->languageCode;

        $formatAsResult = $this->formatAsResultHelper('getLanguageFile', $language);
        $getLanguageFile = $this->languageApi->getLanguageFile($application, $language);

        $this->assertNotEmpty($getLanguageFile);
        $this->assertInternalType('string', $getLanguageFile);
        $this->assertEquals($formatAsResult['data'], $getLanguageFile);
    }

    /**
     * @test
     * @group langapi
     * Because the available language is en..
     */
    public function getAppletLanguagesTest()
    {
        $getAppletLanguages = $this->languageApi->getAppletLanguages('en');

        $this->assertNotEmpty($getAppletLanguages);
        $this->assertEquals($getAppletLanguages[0], 'en');
        $this->assertInternalType('array', $getAppletLanguages);
    }

    /**
     * @test
     * @group langapi
     * Because the available language is en..
     */
    public function getAppletLanguageFileTest()
    {
        $appletKey = key($this->languageBatchBo->applets);
        $formatAsResult = $this->formatAsResultHelper('getAppletLanguageFile', 'en');
        $getAppletLanguageFile = $this->languageApi->getAppletLanguageFile($appletKey, 'en');

        $this->assertNotEmpty($getAppletLanguageFile);
        $this->assertInternalType('string', $getAppletLanguageFile);
        $this->assertEquals($formatAsResult['data'], $getAppletLanguageFile);
    }
}