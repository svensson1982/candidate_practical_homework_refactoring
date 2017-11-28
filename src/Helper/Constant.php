<?php
namespace Language\Helper;

trait Constant
{
    //it looks like constants but no-no :)

    //LanguageApi
    protected $DATA = 'data';
    protected $ACTION = 'action';
    protected $SYSTEM = 'system';
    protected $APPLET = 'applet';
    protected $STATUS = 'status';
    protected $LANGUAGE = 'language';
    protected $SYSTEM_API = 'system_api';
    protected $LANGUAGE_API = 'language_api';
    protected $LANGUAGE_FILES = 'LanguageFiles';

    ////LanguageApi errors
    protected $GET_APP_LANG_ERROR = 'Getting languages for applet %s was unsuccessful %s!';
    protected $GET_APP_FILE_ERROR = 'Getting language xml for applet: (%s) on language: (%s) was unsuccessful: %s';
    protected $GET_LANG_FILE_ERROR = 'ERROR: Error occurred while get language files-> applications: %s language: %s';

    //StoreFile errors
    protected $CREATE_FILE_ERROR = "ERROR: error appears while writing %s";
    protected $STORE_FILE_ERROR = "ERROR: error appears while writing %s to %s directory";

    //Storage path
    protected $PHP_FILE = './cache/%s/%s.php';
    protected $XML_FILE = './cache/flash/lang_%s.xml';
}