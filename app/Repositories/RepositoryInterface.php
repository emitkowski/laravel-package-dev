<?php

namespace App\Repositories;

/**
 * Interface RepositoryInterface
 * @package App\Repositories
 */
interface RepositoryInterface
{
    /**
     * Find set of repo objects.
     *
     * @param null $sort_column
     * @param null $sort_dir
     * @param null $limit
     * @param array $include
     * @param null $query
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll($sort_column, $sort_dir, $limit, $include, $query);

    /**
     * Get repo data by id.
     *
     * @param $id
     * @param bool $fail
     * @param array $include
     * @return \Illuminate\Database\Eloquent\Collection|Model|\Illuminate\Support\Collection|null|static
     */
    public function findById($id, $fail = false, $include = []);

    /**
     * Find repo data by field.
     *
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findByField($field, $value);

    /**
     * Create row in repo
     *
     * @param $input
     * @return static
     */
    public function createRow($input);

    /**
     * Create Row in repo if row data does not exist
     *
     * @param $input
     * @return static
     */
    public function createRowOnlyIfNew($input);

    /**
     * Update row in repo
     *
     * @param $input
     * @return bool|int
     */
    public function updateRow($input);

    /**
     * Update repo row or create new row if row does not exist.
     *
     * @param $row_match_data
     * @param $input
     * @return static
     */
    public function updateRowOrCreate($row_match_data, $input);

    /**
     * Delete row from repo
     *
     * @param $id
     * @return int
     */
    public function deleteRow($id);

    /**
     * Get Total from Repo
     *
     * @return mixed
     */
    public function getTotal();

    /**
     * Get formatted created_at field
     *
     * @return bool|string
     */
    public function getFormattedCreatedAttribute();

    /**
     * Get formatted updated_dat field.
     *
     * @return bool|string
     */
    public function getFormattedModifiedAttribute();

}