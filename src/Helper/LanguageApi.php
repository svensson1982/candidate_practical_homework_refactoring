<?php
namespace Language\Helper;

use Monolog\Logger;
use ReflectionClass;
use Language\ApiCall;
use Monolog\Handler\StreamHandler;
use Language\Helper\ApiErrorResult;

class LanguageApi
{
    use Constant;

    private $apiError;
    private $apiCallInstance;

    /**
     * LanguageApi constructor.
     */
    public function __construct()
    {
        //api errors
        $this->apiError = new ApiErrorResult();
        //ApiCall without static
        $reflection = new ReflectionClass(ApiCall::class);
        $this->apiCallInstance = $reflection->newInstanceWithoutConstructor();
        //error log
        $this->log = new Logger('language_api');
        $this->log->pushHandler(new StreamHandler(dirname(dirname(__DIR__)) . '/Log/error_language_api.log', Logger::ERROR));
    }

    /**
     * @param $application
     * @param $language
     * @return string
     * @throws \Exception
     */
    public function getLanguageFile(string $application, string $language): string
    {
        try {
            return $this->callApi(__FUNCTION__, [$this->LANGUAGE => $language]);
        } catch (\Exception $e) {
            echo sprintf($this->GET_LANG_FILE_ERROR, $application, $language) . " -> " . $e->getMessage();
            $this->log->error(sprintf($this->GET_LANG_FILE_ERROR, $application, $language));
        }
    }


    /**
     * @param string $applet
     * @return array
     */
    public function getAppletLanguages(string $applet): array
    {
        try {
            return $this->callApi(__FUNCTION__, [$this->APPLET => $applet]);
        } catch (\Exception $e) {
            echo sprintf($this->GET_APP_LANG_ERROR, $applet, $e->getMessage());
            $this->log->error(sprintf($this->GET_APP_LANG_ERROR, $applet, $e->getMessage()));
        }
    }

    /**
     * @param $applet
     * @param $language
     * @return string
     * @throws \Exception
     */
    public function getAppletLanguageFile(string $applet, string $language): string
    {
        try {
            return $this->callApi(__FUNCTION__, [
                $this->APPLET => $applet,
                $this->LANGUAGE => $language,
            ]);
        } catch (\Exception $e) {
            echo sprintf($this->GET_APP_FILE_ERROR, $applet, $language, $e->getMessage());
            $this->log->error(sprintf($this->GET_APP_FILE_ERROR, $applet, $language, $e->getMessage()));
        }
    }

    /**
     * @param string $function
     * @param array $language
     * @return mixed
     * @throws \Exception
     */
    private function callApi(string $function, array $language)
    {
        $result = $this->apiCallInstance->call(
            $this->SYSTEM_API,
            $this->LANGUAGE_API,
            [
                $this->SYSTEM => $this->LANGUAGE_FILES,
                $this->ACTION => $function
            ],
            $language
        );

        //error handling
        $this->apiError->checkForApiErrorResult($result);

        return $result['data'];
    }
}
