<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DataImporterServiceProvider extends ServiceProvider {

    /**
     * Register the bindings
     *
     * @return void
     */
    public function register()
    {
        // Register sessions for data event counts
        session()->put('data_import_created_count', 0);
        session()->put('data_import_updated_count', 0);
        session()->put('data_import_deleted_count', 0);
    }

}