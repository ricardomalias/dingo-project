<?php

namespace Core\Repository;


abstract class BaseRepository implements BaseRepositoryContract
{
    protected $model;
    protected $searcher;

    /**
     * @var fields to select
     */
    protected $select_model;

    /**
     * @var fields to insert
     */
    protected $required;

    /**
     * @var number of items per page
     */
    protected $perPage = 20;

    /**
     * @var set pagination
     */
    public $pagination = true;

    /**
     * @var set ignore empty fields to return
     */
    protected $ignoreEmptyFields = false;

    /**
     * @var set order
     */
    protected $orderBy;

    function __construct()
    {
        $this->utils = new \Core\Utils();

        if(empty($this->searcher) && empty($this->model))
        {
            throw new BadRequestException(__('system.check_repository'));
        }
    }

    public function getSearcher()
    {
        try{
            return new $this->searcher();
        } catch(\Exception $e) {
            return false;
        }
    }

    public function save(array $values)
    {
        if (!empty($this->required))
        {
            $model = new $this->model();

            foreach ($this->required as $field)
            {
                if (!array_key_exists($field, $values))
                {
                    return false;
                }
            }

            foreach ($this->required as $field)
            {
                if (array_key_exists($field, $values))
                {
                    $model->$field = $values[$field];
                }
            }

            if ($model->save())
            {
                return true;
            }

            return false;
        }

        return null;
    }

    public function update(array $values, array $where)
    {
        if (!empty($this->required))
        {
            foreach ($values as $field => $value)
            {
                if (!in_array($field, $this->required))
                {
                    return false;
                }
            }

            $model = (new $this->model())
                ->where($where)
                ->first();

            if (empty($model))
            {
                return false;
            }

            foreach ($this->required as $field)
            {
                if (array_key_exists($field, $values))
                {
                    $model->$field = $values[$field];
                }
            }

            if ($model->save())
            {
                return true;
            }

            return false;
        }

        return null;
    }

    public function get(array $where)
    {
        $response = array();

        if(!empty($this->searcher))
        {
            $response = $this->getSearch($where);
        }

        if(empty($response) && !empty($this->model))
        {
            $response = $this->getModel($where);
        }

        return $response;
    }

    private function getSearch(array $where)
    {
        $response = array();

        $searcher = new $this->searcher;

        foreach ($where as $key => $value)
        {
            if(!empty($value))
            {
                $searcher->where($key, $value);
            }
        }

        if(!empty($this->orderBy))
        {
            $searcher->orderBy($this->orderBy);
        }

        if($this->pagination === true)
        {
            $searcher->limit($this->perPage)->paginate();
        }

        $result = $searcher->get();

        if($this->pagination === true)
        {
            $response = Pagination::make($result, $this->perPage);
        }
        else
        {
            $response = $result->toArray();
        }

        return $response;
    }

    private function getModel(array $where)
    {
        $response = array();

        $model = new $this->model;
        $select = $this->select_model;

        $model = $model->select(array_keys($this->select_model));

        $where = $this->utils->withFields(array_flip($select), $where, true);

        foreach ($where as $key => $value)
        {
            if(!empty($value) && !is_array($value))
            {
                $model = $model->where($key, $value);
            }
            else if(!empty($value) && is_array($value))
            {
                $model = $model->whereIn($key, $value);
            }
        }

        if(!empty($this->orderBy) && array_key_exists('field', $this->orderBy) && array_key_exists('sort', $this->orderBy))
        {
            $model->orderBy($this->orderBy['field'], $this->orderBy['sort']);
        }
        else if(!empty($this->orderBy) && array_key_exists(0, $this->orderBy) && array_key_exists(1, $this->orderBy))
        {
            $model->orderBy($this->orderBy[0], $this->orderBy[1]);
        }

        if($this->pagination === true)
        {
            Pagination::$forcePagination = true;
            $result = Pagination::make($model, $this->perPage);
        }
        else
        {
            $result = $model->get();
        }

        foreach ($result as $value)
        {
            $response[] = $this->utils->withFields($select, $value->toArray(), $this->ignoreEmptyFields);
        }

        return $response;
    }

}
