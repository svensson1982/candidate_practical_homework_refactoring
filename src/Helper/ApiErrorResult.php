<?php
namespace Language\Helper;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ApiErrorResult
{


    public function __construct()
    {
        //logger
        $this->log = new Logger('api_error_result');
        $this->log->pushHandler(new StreamHandler(dirname(dirname(__DIR__)) . '/Log/error_api_error_result.log', Logger::ERROR));
    }

    /**
     * Checks the api call result.
     * @param $result
     * @throws \Exception
     */
    public function checkForApiErrorResult($result)
    {
        // Error during the api call.
        if ($result === false || !isset($result['status'])) {
            $this->log->error('Error during the api call');
            throw new \Exception('Error during the api call!');
        }

        // Wrong response.
        if ($result['status'] != 'OK') {
            $this->log->error('Wrong response');
            throw new \Exception('Wrong response: '
                . (!empty($result['error_type']) ? 'Type(' . $result['error_type'] . ') ' : '')
                . (!empty($result['error_code']) ? 'Code(' . $result['error_code'] . ') ' : '')
                . ((string)$result['data']));
        }

        // Wrong content.
        if ($result['data'] === false) {
            $this->log->error('Wrong content!');
            throw new \Exception('Wrong content!');
        }
    }

    /**
     * ↓↓ If we have further error handling functions, we will put them here. ↓↓
     */
}