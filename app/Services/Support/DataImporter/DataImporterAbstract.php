<?php namespace App\Services\Support\DataImporter;

use App\Services\Support\Alert\AlertTrait;
use App\Services\Support\Logger\LoggerTrait;

/**
 *
 * Abstract class for Data Importing.
 *
 */
abstract class DataImporterAbstract
{
    use AlertTrait, LoggerTrait;

    // Service Settings
    protected $service_type = 'support';
    protected $import_data_processed = 0; // Import Type data
    protected $is_created = true;
    protected $is_updated = true;
    protected $is_deleted = false;

    /**
     * Abstract Function for Processing the data being imported
     *
     * @return mixed
     */
    abstract protected function processData();

    /**
     * Data Importer Abstract Constructor
     *
     */
    public function __construct()
    {}

    /**
     * Import Data from source to repository
     *
     * @return bool
     */
    public function importData()
    {
        // Gather Import Data
        $result = $this->processData();

        // Alert Webops import has failed
        if ($result === false) {
            $this->logError($this->service_name.' Failure: The '.$this->service_name.' process did not complete.');
            $this->webopsAlert($this->service_name.' Failure', 'The '.$this->service_name.' process did not complete. Please check the Magento API connection and Data Importer logs to detect the issue.');
            return false;
        }

        // Log Import Stats
        $this->logStats();

        return true;
    }

    /**
     * Map the API Request Fields to Repository Fields
     *
     * @param $data
     * @return array
     */
    protected function mapImportData($data)
    {
        $mapped_data = array();
        foreach ($this->import_map as $api_field => $repo_field) {
            if (isset($data[$api_field])) {
                $mapped_data[$repo_field] = $data[$api_field];

//                if ($repo_field == 'name') {
//                    $mapped_data[$repo_field] = 'NAME UPDATE';
//                }

            } else {
                $mapped_data[$repo_field] = null;
            }
        }

        return $mapped_data;
    }

    /**
     * Log Import Statistics
     *
     * @return bool
     */
    private function logStats()
    {
        $stat_log = 'Data Processed #: '.$this->import_data_processed;

        // Log activity
        if($this->is_created && session()->get('data_import_created_count') > 0) {
            $stat_log .= ' | Created #: ' . session()->get('data_import_created_count');
        }

        if($this->is_updated && session()->get('data_import_updated_count') > 0) {
            $stat_log .= ' | Updated #: ' . session()->get('data_import_updated_count');
        }

        if($this->is_deleted && session()->get('data_import_deleted_count') > 0) {
            $stat_log .= ' | Deleted #: ' . session()->get('data_import_deleted_count');
        }

        $this->logInfo($stat_log);

        return true;
    }
}