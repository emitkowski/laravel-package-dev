<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/*
 * This class defines Eloquent methods
 */

abstract class EloquentRepositoryAbstract extends Model implements RepositoryInterface
{

    protected $guarded = ['id'];

    public $timestamps = true;

    /**
     * Property to hold query while building
     *
     */
    protected $query;


    /**
     * Repository Abstract Constructor
     *
     */
    public function __construct()
    {
        $this->query = $this->newQuery();
    }


    /******************** Query Building and Result Functions *****************************/

    /**
     * Start New Query
     *
     * @return $this
     */
    public function startQuery()
    {
        $this->query = $this->newQuery();

        return $this;
    }

    /**
     * Select Columns for Query
     *
     * @param array $columns
     * @return $this
     */
    public function selectColumns(array $columns)
    {
        $this->query->select($columns);

        return $this;
    }

    /**
     *  Add Where Clause to Query
     *
     * @param $field
     * @param $value
     * @return $this
     */
    public function addWhere($field, $value)
    {
        $this->query->where($field, $value);

        return $this;
    }

    /**
     *  Add relations to query
     *
     * @param array $relations
     * @return $this
     */
    public function addRelations(array $relations)
    {
        $this->query->with($relations);

        return $this;
    }


    /**
     * Add sort to query
     *
     * @param $sort_column
     * @param null $sort_dir
     * @return $this
     */
    public function sort($sort_column, $sort_dir = null)
    {
        if (!is_null($sort_dir)) {
            $this->query->orderBy($sort_column, $sort_dir);
        } else {
            $this->query->orderBy($sort_column, 'ASC');
        }

        return $this;
    }

    /**
     * Add limit to query
     *
     * @param null $count
     * @return $this
     */
    public function limit($count = null)
    {
        if (!is_null($count)) {
            $this->query->take($count);
        }

        return $this;
    }

    /**
     * Get Query Results
     *
     * @param string $type
     * @return mixed
     */
    public function getResults($type = null)
    {
        $results = $this->query->get();

        if ($type == 'array') {
            $results = $results->toArray();
        } else {
            if ($type == 'json') {
                $results = $results->toJson();
            }
        }

        $this->query = $this->newQuery();

        return $results;
    }

    /**
     * Delete Query Results
     *
     * @return mixed affected rows
     */
    public function deleteResults()
    {
        $result = $this->query->delete();

        $this->query = $this->newQuery();

        return $result;
    }

    /******************** Repository Row Manipulation Functions *****************************/

    /**
     * Create row in repo
     *
     * @param $input
     * @return static
     */
    public function createRow($input)
    {
        return $this->create($input);
    }

    /**
     * Create Row in repo if row data does not exist
     *
     * @param $input
     * @return static
     */
    public function createRowOnlyIfNew($input)
    {
        return $this->firstOrCreate($input);
    }

    /**
     * Update row in repo
     *
     * @param $input
     * @return bool|int
     */
    public function updateRow($input)
    {
        return $this->update($input);
    }

    /**
     * Update repo row or create new row if row does not exist.
     *
     * @param $row_match_data
     * @param $input
     * @return static
     */
    public function updateRowOrCreate($row_match_data, $input)
    {
        return $this->updateOrCreate($row_match_data, $input);
    }

    /**
     * Delete row from repo
     *
     * @param $id
     * @return int
     */
    public function deleteRow($id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Get Total from Repo
     *
     * @return mixed
     */
    public function getTotal()
    {
        return $this->count();
    }


    /**
     * Find set of repo objects.
     *
     * @param null $sort_column
     * @param null $sort_dir
     * @param null $limit
     * @param array $include
     * @param null $query
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll($sort_column = null, $sort_dir = null, $limit = null, $include = [], $query = null)
    {
        // If null use query from model
        if (is_null($query)) {
            $query = $this;
        }

        if ($sort_column != null && $sort_dir != null) {
            $query = $query->orderBy($sort_column, $sort_dir);
        }

        if ($limit != null) {
            $query = $query->take($limit);
        }

        if (!empty($include)) {
            $query = $query->with($include);
        }

        $items = $query->get();

        return $items;
    }

    /**
     * Get repo data by id.
     *
     * @param $id
     * @param bool $fail
     * @param array $include
     * @return Model|\Illuminate\Database\Eloquent\Collection|Model|\Illuminate\Support\Collection|null|static
     */
    public function findById($id, $fail = false, $include = [])
    {

        $query = $this;

        if (!empty($include)) {
            $query = $query->with($include);
        }

        if ($fail == true) {
            return $query->findOrFail($id);
        }

        return $query->find($id);
    }

    /**
     * Find repo data by field.
     *
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findByField($field, $value)
    {
        return $this->where($field, $value)->get();
    }

    /**
     * Get formatted created_at field
     *
     * @return bool|string
     */
    public function getFormattedCreatedAttribute()
    {
        if ($this->offsetExists('created_at')) {
            return date('m/d/Y g:i a', strtotime($this->getAttribute('created_at')));
        }
    }

    /**
     * Get formatted updated_dat field.
     *
     * @return bool|string
     */
    public function getFormattedModifiedAttribute()
    {
        if ($this->offsetExists('updated_at')) {
            return date('m/d/Y g:i a', strtotime($this->getAttribute('updated_at')));
        }
    }
}