<?php
namespace Language\Helper;

trait Constant
{
    //it looks like constants but no-no :)

    //LanguageApi
    public $DATA = 'data';
    public $ACTION = 'action';
    public $SYSTEM = 'system';
    public $APPLET = 'applet';
    public $STATUS = 'status';
    public $LANGUAGE = 'language';
    public $SYSTEM_API = 'system_api';
    public $LANGUAGE_API = 'language_api';
    public $LANGUAGE_FILES = 'LanguageFiles';

    ////LanguageApi errors
    public $GET_APP_LANG_ERROR = 'Getting languages for applet %s was unsuccessful %s!';
    public $GET_APP_FILE_ERROR = 'Getting language xml for applet: (%s) on language: (%s) was unsuccessful: %s';
    public $GET_LANG_FILE_ERROR = 'ERROR: Error occurred while get language files-> applications: %s language: %s';

    //StoreFile errors
    public $CREATE_FILE_ERROR = 'ERROR: error appears while writing %s';
    public $STORE_FILE_ERROR = 'ERROR: error appears while writing %s to %s directory';

    //Storage path
    public $PHP_FILE = './cache/%s/%s.php';
    public $XML_FILE = './cache/flash/lang_%s.xml';

    //LanguageBatchBo
    public $GENERATE_LANG_FILES = "[** LANGUAGE: %s **]<br>";
    public $GENERATE_LANG_FILES_END = "Language files have been generated successfully.<br>";
    public $GENERATE_LANG_FILES_START = "Generating language files -> [** APPLICATION: %s **]<br>";

    public $GENERATE_APP_FILES_START = "Getting applet language XMLs...<br>";
    public $GENERATE_APP_GET_FILES = "** Getting %s -> %s language XMLs**<br>";
    public $GENERATE_APP_AVAILABLE_LANG = "** Available languages: [%s]**<br>";
    public $GENERATE_APP_FILES_END = "Applet language XML has been generated.<br>";
    public $GENERATE_APP_LANG_EXCEPTION = "There is no available languages for the %s applet!";
    public $GENERATE_APP_SUCCESSFUL_LANG = "** Language xml cached successfully %s -> %s **<br>";
}
