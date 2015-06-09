<?php

namespace App\Observers\Models;

/**
 * Class DataImportModelObserver
 *
 *  This observer is used for keep count of eloquent model events using session variables
 *
 * @package App\Observers\Models
 */
class DataImportModelObserver
{
    private $print_enabled = true;

    /**
     * Created Event
     *
     * @param $model
     */
    public function created($model)
    {
        session()->put('data_import_created_count', session()->get('data_import_created_count') + 1);

        $this->printEvent($model);
    }

    /**
     * Updated Event
     *
     * @param $model
     */
    public function updated($model)
    {
        session()->put('data_import_updated_count', session()->get('data_import_updated_count') + 1);

        $this->printEvent($model);
    }

    /**
     * Deleted Event
     *
     * @param $model
     */
    public function deleted($model)
    {
        session()->put('data_import_deleted_count', session()->get('data_import_deleted_count') + 1);

        $this->printEvent($model);
    }


    /**
     * Print Out Model Event
     *
     * @param $model
     */
    private function printEvent($model)
    {
        if ($this->print_enabled) {
            if ($model->getAttribute('id')) {
                xr('ID#: ' . $model->getAttribute('id'));
            }
        }
    }
}