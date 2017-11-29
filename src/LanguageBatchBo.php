<?php
namespace Language;

use Monolog\Logger;
use Language\Config;
use Language\Helper\Storage;
use Language\Helper\Constant;
use Language\Helper\LanguageApi;
use Monolog\Handler\StreamHandler;

/**
 * Business logic related to generating language files.
 */
class LanguageBatchBo
{
    use Constant;

    private $log;
    public $applets;
    public $applications;
    private $languageApi;

    /**
     * LanguageBatchBo constructor.
     * @param Storage|null $storage
     * @param LanguageApi|null $languageApi
     */
    public function __construct(Storage $storage = null, LanguageApi $languageApi = null)
    {
        // List of the applets [directory => applet_id].
        $this->applets = ['memberapplet' => 'JSM2_MemberApplet'];
        $this->languageApi = $languageApi ?: new LanguageApi();
        $this->applications = Config::get('system.translated_applications');
        $this->storage = $storage ?: new Storage(Config::get('system.paths.root'));
        //logger
        $this->log = new Logger('language_batch_bo');
        $this->log->pushHandler(new StreamHandler(dirname(__DIR__) . '/Log/info_language_batch_bo.log', Logger::INFO));
        $this->log->pushHandler(new StreamHandler(dirname(__DIR__) . '/Log/error_language_batch_bo.log', Logger::ERROR));
    }

    /**
     * Starts the language file generation.
     */
    public function generateLanguageFiles()
    {
        echo sprintf($this->GENERATE_LANG_FILES_START, key($this->applications));

        array_walk_recursive($this->applications, function ($language) {
            echo sprintf($this->GENERATE_LANG_FILES, $language);
            $this->getStorage()->
            storeCacheFile(key($this->applications), $language)->
            storeFile(
                $this->
                getLanguageApi()->
                getLanguageFile(key($this->applications), $language)
            );
        });

        echo $this->GENERATE_LANG_FILES_END;
        $this->log->info($this->GENERATE_LANG_FILES_END);
    }

    /**
     * Gets the language files for the applet and puts them into the cache.
     */
    public function generateAppletLanguageXmlFiles()
    {
        echo $this->GENERATE_APP_FILES_START;

        array_walk_recursive($this->applets, function ($appletLanguageId, $appletDirectory) {
            echo sprintf($this->GENERATE_APP_GET_FILES, $appletLanguageId, $appletDirectory);

            $languages = $this->getLanguageApi()->getAppletLanguages($appletLanguageId);

            if (!$languages) {
                $this->log->error(sprintf($this->GENERATE_APP_LANG_EXCEPTION, $appletLanguageId));
                throw new \Exception(sprintf($this->GENERATE_APP_LANG_EXCEPTION, $appletLanguageId));
            }

            echo sprintf($this->GENERATE_APP_AVAILABLE_LANG, join(', ', $languages));

            foreach ($languages as $language) {
                $this->getStorage()->
                storeAppletCacheFile($language)->
                storeFile(
                    $this->
                    getLanguageApi()->
                    getAppletLanguageFile($appletLanguageId, $language)
                );

                echo sprintf($this->GENERATE_APP_SUCCESSFUL_LANG, $appletLanguageId, $appletDirectory);
            }
        });

        echo $this->GENERATE_APP_FILES_END;
        $this->log->info($this->GENERATE_APP_FILES_END);
    }


    /**
     * @return Storage
     */
    private function getStorage(): Storage
    {
        return $this->storage;
    }

    /**
     * @return LanguageApi
     */
    public function getLanguageApi(): LanguageApi
    {
        return $this->languageApi;
    }
}
