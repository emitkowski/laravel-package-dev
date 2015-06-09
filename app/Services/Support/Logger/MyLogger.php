<?php

namespace App\Services\Support\Logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;


/**
 * Class MyLogger
 * @package App\Services\Logger
 *
 * Log Class to write general individual log files
 *
 * 3 levels (info, warning, error)
 *
 */
class MyLogger implements LoggerInterface
{

    private $all_logs_enabled;
    private $global_error_log_enabled;


    /**
     * Logger Abstract Constructor
     *
     */
    public function __construct()
    {
        $this->all_logs_enabled = (bool) config('support.logger.enabled.all_logs');
        $this->global_error_log_enabled = (bool) config('support.logger.enabled.global_error_log');
    }

    /**
     * Log Message
     *
     * @param $message
     * @param $service_name
     * @param bool $is_support
     * @param string $level
     * @param null $log_name
     * @return bool
     */
    public function write($message, $service_name, $is_support=true, $level='info', $log_name=null)
    {
        if($this->all_logs_enabled) {

            $log_event = \App::make('log_event_time');

            $log_path = storage_path() . '/logs/';

            // Add support folder
            if ($is_support) {
                $log_path .= 'support/';
                $this->makeDir($log_path);
            }

            // Format service name for logs
            $service_name = strtolower(str_replace(' ', '_', $service_name));

            // Add service name
            $log_path .= $service_name . '/';
            $this->makeDir($log_path);

            // Add file name
            if ($log_name != null) {
                $log_path .= $log_name;
            } else {
                switch ($level) {
                    case 'info':
                        $log_path .= $service_name . '-info.log';
                        break;
                    case 'warning':
                        $log_path .= $service_name . '-warning.log';
                        break;
                    case 'error':
                        $log_path .= $service_name . '-error.log';
                        break;
                    default:
                        $log_path .= $service_name . '.log';
                }
            }

            // Write main log
            $service_log = new Logger($log_event);
            $service_log->pushHandler(new StreamHandler($log_path, Logger::INFO));
            $service_log->log($level, $message);

            // If error level log also write to master error log
            if ($level == 'error' && $this->global_error_log_enabled) {
                $error_log = new Logger($log_event . '-' . $service_name);
                $error_log->pushHandler(new StreamHandler(storage_path() . '/logs/all-errors.log', Logger::ERROR));
                $error_log->log($level, $message);
            }
        }

        return true;
    }

    /**
     * Make Dir
     *
     * @param $path
     */
    private function makeDir($path)
    {
        if (!is_dir($path)) {
            mkdir($path);
        }
    }
}