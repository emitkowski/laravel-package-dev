<?php

namespace App\Services\Support\FileOrganizer;

use App\Services\Support\Alert\AlertTrait;
use App\Services\Support\Logger\LoggerTrait;

/**
 *
 * Abstract class for File Organization
 *
 */
abstract class FileOrganizerAbstract
{
    use AlertTrait, LoggerTrait;

    // Default Directories
    private $default_archive_dir = 'archive';
    private $default_current_dir = 'current';
    private $default_working_dir = 'working';
    private $default_failed_dir = 'failed';
    private $default_transfer_retry_dir = 'transfer_retry';

    // Storage Dir Paths
    protected $storage_root; // Main Root of File Type
    protected $storage_specific_dir; // Main Root of Deliverable Type

    // Constructed Paths
    protected $storage_main_path;
    protected $archive_path;
    protected $current_path;
    protected $working_path;
    protected $failed_path;
    protected $transfer_retry_path;

    private $archive_timestamp_format = 'Y-m-d_H-i-s';
    private $failed_timestamp_format = 'Y-m-d_H-i-s';


    /**
     * File Organizer Constructor
     *
     */
    public function __construct()
    {
        // Build File Paths in Storage
        $this->storage_main_path = storage_path() . '/app/' . $this->storage_root . '/' . $this->storage_specific_dir;
        $this->archive_path = $this->storage_main_path . '/' . $this->default_archive_dir . '/';
        $this->current_path = $this->storage_main_path . '/' . $this->default_current_dir . '/';
        $this->working_path = $this->storage_main_path . '/' . $this->default_working_dir . '/';
        $this->failed_path = $this->storage_main_path . '/' . $this->default_failed_dir . '/';
        $this->transfer_retry_path = $this->storage_main_path . '/' . $this->default_transfer_retry_dir . '/';
    }

    /**
     * Clean file by removing all passed string instances
     *
     * @param $filename
     * @param $string
     * @return bool
     */
    protected function cleanFile($filename, $string)
    {
        $data = file_get_contents($this->working_path . $filename);
        $data = preg_replace('/' . $string . '/', '$1', $data);

        if (file_put_contents($this->working_path . $filename, $data) === false) {
            return false;
        }

        return true;
    }

    /**
     * Move the file to the archive dir and date stamp it
     *
     * @param $file
     * @return bool
     */
    protected function archiveFile($file)
    {
        if (!file_exists($this->working_path . $file)) {
            return false;
        }

        return rename($this->working_path . $file,
            $this->archive_path . $file . '_' . date($this->archive_timestamp_format));
    }

    /**
     * Move the file to the failed dir and date stamp it
     *
     * @param $file
     * @return bool
     */
    protected function failFile($file)
    {
        if (file_exists($this->working_path . $file)) {
            return rename($this->working_path . $file,
                $this->failed_path . $file . '_' . date($this->failed_timestamp_format));
        }

        return true;
    }

    /**
     * Copy the file to the current dir which will be available for use
     *
     * @param $file
     * @return bool
     */
    protected function publicizeFile($file)
    {
        if (!file_exists($this->working_path . $file)) {
            return false;
        }

        // If retry folder has same file, erase it
        if (isset($this->transfer_type) && $this->transfer_type == 'FTP') {
            if (file_exists($this->transfer_retry_path . $file)) {
                unlink($this->transfer_retry_path . $file);
            }
        }

        return copy($this->working_path . $file, $this->current_path . $file);
    }

    /**
     * Build File Directories
     *
     */
    protected function buildFileDirStructure()
    {
        // Make Main Dir
        $this->makeDir($this->storage_main_path);

        // Make Sub Dirs
        $this->makeDir($this->archive_path);
        $this->makeDir($this->current_path);
        $this->makeDir($this->working_path);
        $this->makeDir($this->failed_path);

        // Make retry path only if FTP
        if (isset($this->transfer_type) && $this->transfer_type == 'FTP') {
            $this->makeDir($this->transfer_retry_path);
        }
    }

    /**
     * Make Dir
     *
     * @param $path
     */
    private function makeDir($path)
    {
        if (!is_dir($path)) {
            mkdir($path, $mode = 0775, true);
        }
    }

    /**
     * Finalize Files by running all required finalization methods on each file
     *
     * @param $mappers
     * @return bool
     */
    protected function finalizeFiles($mappers)
    {
        if (is_array($mappers)) {
            foreach ($mappers as $mapper) {
                if (!$this->finalizeFile($mapper)) {
                    return false;
                }
            }
        } else {
            return $this->finalizeFile($mappers);
        }

        return true;
    }

    /**
     * Finalize file with finalization methods
     *
     * @param $mapper
     * @return bool
     */
    private function finalizeFile($mapper)
    {
        // Clean File
        foreach ($mapper->strings_to_clean as $string) {
            if (!$this->cleanFile($mapper->file_name, $string)) {
                $this->logError($mapper->file_name . ': Failed to Clean');

                return false;
            }
        }

        // Publicize File
        if (!$this->publicizeFile($mapper->file_name)) {
            $this->logError($mapper->file_name . ': Failed to Publicize');

            return false;
        }

        // Archive File
        if (!$this->archiveFile($mapper->file_name)) {
            $this->logError($mapper->file_name . ': Failed to Archive');

            return false;
        }

        return true;
    }


    /**
     * Error Files
     *
     * @param $mappers
     * @return bool
     */
    protected function errorFiles($mappers)
    {
        if (is_array($mappers)) {
            foreach ($mappers as $mapper) {
                if (!$this->errorFile($mapper)) {
                    return false;
                }
            }
        } else {
            return $this->errorFile($mappers);
        }

        return true;
    }

    /**
     * Error Individual File
     *
     * @param $mapper
     * @return bool
     */
    private function errorFile($mapper)
    {
        // Error File
        if (!$this->failFile($mapper->file_name)) {
            $this->logError($mapper->file_name . ': Failed to Error');

            return false;
        }

        return true;
    }
}