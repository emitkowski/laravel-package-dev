<?php

namespace App\Services\Support\Logger;

/**
 * Class LoggerTrait
 * @package App\Services\Logger
 *
 * Trait to add logging functionality to any class
 *
 * Requires class to have parameters of service_name and service_type
 *
 */
trait LoggerTrait
{
    /**
     * Write Info Log
     *
     * @param $message
     * @param null $log_name
     * @return bool
     */
    protected function logInfo($message, $log_name=null)
    {
        try {
            if ($this->getServiceType() == 'support') {
                \Logger::write($message, $this->getServiceName(), true, 'info', $log_name);
            } else {
                \Logger::write($message, $this->getServiceName(), false, 'info', $log_name);
            }

        } catch(\Exception $e) {
            \Logger::write('Logger Error:'.$e->getMessage(), 'logger', true, 'error');
        }

        return true;
    }

    /**
     * Write Warning Log
     *
     * @param $message
     * @param null $log_name
     * @return bool
     */
    protected function logWarning($message, $log_name=null)
    {
        try {
            if ($this->getServiceType() == 'support') {
                \Logger::write($message, $this->getServiceName(), true, 'warning', $log_name);
            } else {
                \Logger::write($message, $this->getServiceName(), false, 'warning', $log_name);
            }
        } catch(\Exception $e) {
            \Logger::write('Logger Error:'.$e->getMessage(), 'logger', true, 'error');
        }

        return true;
    }


    /**
     * Write Error Log
     *
     * @param $message
     * @param null $log_name
     * @return bool
     */
    protected function logError($message, $log_name=null)
    {
        try {
            if ($this->getServiceType() == 'support') {
                \Logger::write($message, $this->getServiceName(), true, 'error', $log_name);
            } else {
                \Logger::write($message, $this->getServiceName(), false, 'error', $log_name);
            }
        } catch(\Exception $e) {
            \Logger::write('Logger Error:'.$e->getMessage(), 'logger', true, 'error');
        }

        return true;
    }

    /**
     * Get Service Name
     *
     * @throws \Exception
     * @return mixed
     */
    protected function getServiceName()
    {
        if (!isset($this->service_name)){
            throw new \Exception("Service Name not set in class:". get_called_class());
        }
        return strtolower($this->service_name);
    }

    /**
     * Set Service Name
     *
     * @param $name
     */
    protected function setServiceName($name)
    {
        if (isset($this->service_name)) {
            $this->service_name = $name;
        }
    }


    /**
     * Get Service Type
     *
     * @throws \Exception
     * @return mixed
     */
    protected function getServiceType()
    {
        if (!isset($this->service_type)){
            throw new \Exception("Service Type not set in class:". get_called_class());
        }
        return strtolower($this->service_type);
    }

    /**
     * Set Service Type
     *
     * @param $type
     */
    protected function setServiceType($type)
    {
        if (isset($this->service_type)) {
            $this->service_type = $type;
        }
    }

}