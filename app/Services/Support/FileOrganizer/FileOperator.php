<?php

namespace App\Services\Support\FileOrganizer;

/**
 * Abstract Class for File Operator
 *
 */
abstract class FileOperator
{
    // File Name
    public $file_name;

    // Strings to clean from file
    public $strings_to_clean = [];


    /**
     * File Name Setter
     *
     * @param $file_name
     */
    public function setFileName($file_name)
    {
        $this->file_name = $file_name;
    }

    /**
     * File Name Getter
     *
     * @return array
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * Strings To Clean Setter
     *
     * @param $strings
     */
    public function setStringsToClean($strings)
    {
        $this->strings_to_clean = $strings;
    }

    /**
     * Strings To Clean Getter
     *
     * @return array
     */
    public function getStringsToClean()
    {
        return $this->strings_to_clean;
    }
}