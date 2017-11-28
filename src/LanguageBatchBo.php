<?php
namespace Language;

use Monolog\Logger;
use Language\Config;
use Language\Helper\Storage;
use Language\Helper\LanguageApi;
use Monolog\Handler\StreamHandler;

/**
 * Business logic related to generating language files.
 */
class LanguageBatchBo
{

    private $log;
    private $applets;
    private $languageApi;
    private $applications;

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
        echo "Generating language files -> " . "[** APPLICATION: " . key($this->applications) . " **]<br>";
        array_walk_recursive($this->applications, function ($language) {
            echo "[** LANGUAGE: " . $language . " **]<br>";
            $this->getStorage()->storeCacheFile(key($this->applications), $language)
                ->storeFile(
                    $this->
                    getLanguageApi()->
                    getLanguageFile(key($this->applications), $language)
                );
        });
        echo "Language files have been generated successfully.<br>";
        $this->log->info("Language files have been generated successfully.");
    }


    /**
     * Gets the language files for the applet and puts them into the cache.
     */
    public function generateAppletLanguageXmlFiles()
    {
        echo "Getting applet language XMLs...<br>";
        array_walk_recursive($this->applets, function ($appletLanguageId, $appletDirectory) {
            echo "** Getting " . $appletLanguageId . " -> " . $appletDirectory . " language XMLs**<br>";
            $languages = $this->getLanguageApi()->getAppletLanguages($appletLanguageId);
            if (!$languages) {
                throw new \Exception('There is no available languages for the ' . $appletLanguageId . ' applet.');
            }
            echo '** Available languages: [' . join(', ', $languages) . ']**<br>';

            foreach ($languages as $language) {
                $this->getStorage()->storeAppletCacheFile($language)
                    ->storeFile(
                        $this->
                        getLanguageApi()->
                        getAppletLanguageFile($appletLanguageId, $language)
                    );
                echo "** Language xml cached successfully." . $appletLanguageId . "->" . $appletDirectory . "**<br>";
            }
        });

        echo "Applet language XML has been generated.<br>";
    }


    /**
     * @return Storage
     */
    private function getStorage()
    {
        return $this->storage;
    }

    /**
     * @return LanguageApi
     */
    private function getLanguageApi()
    {
        return $this->languageApi;
    }
}
