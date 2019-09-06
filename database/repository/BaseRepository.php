<?php

namespace Core\Repository;

use App\Repository\BaseRepositoryContract;

abstract class BaseRepository implements BaseRepositoryContract
{
    protected $model;
    protected $searcher;

    /**
     * @var $select_model
     * fields to select
     */
    protected $select_model;

    /**
     * @var $required
     * fields to insert
     */
    protected $required;

    /**
     * @var $perPage
     * number of items per page
     */
    protected $perPage = 20;

    /**
     * @var $pagination
     * pagination
     */
    public $pagination = false;

    /**
     * @var $ignoreEmptyFields
     * set ignore empty fields to return
     */
    protected $ignoreEmptyFields = false;

    /**
     * @var $orderBy
     * set order
     */
    protected $orderBy = [
        'field' => 'created_at',
        'sort' => 'asc'
    ];

    function __construct()
    {
//        $this->utils = new \Core\Utils();

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
//        if (!empty($this->required))
        {
            $m = new $this->model();

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
                    $m->$field = $values[$field];
                }
            }

            if ($m->save())
            {
                return true;
            }
        }

        return false;
    }

    public function update(array $values, array $where)
    {
//        if (!empty($this->required))
        {
            foreach ($values as $field => $value)
            {
                if (!in_array($field, $this->required))
                {
                    return false;
                }
            }

            $m = (new $this->model())
                ->where($where)
                ->first();

            if (!empty($m))
            {
                foreach ($this->required as $field) {
                    if (array_key_exists($field, $values)) {
                        $m->$field = $values[$field];
                    }
                }

                return (bool)$m->save();
            }
        }

        return false;
    }

    public function first(array $where = []) {
        return $this->get($where)[0];
    }

    public function get(array $where = [])
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

        $s = new $this->searcher;

        foreach ($where as $key => $value)
        {
            if(!empty($value))
            {
                $s->where($key, $value);
            }
        }

        if(!empty($this->orderBy))
        {
            $s->orderBy($this->orderBy);
        }

        if($this->pagination === true)
        {
            $s->limit($this->perPage)->paginate();
        }

        $result = $s->get();

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

        if($this->select_model) {
            $model = $model->select(array_keys($this->select_model));
        }

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
            $model = $model->orderBy($this->orderBy['field'], $this->orderBy['sort']);
        }
        else if(!empty($this->orderBy) && array_key_exists(0, $this->orderBy) && array_key_exists(1, $this->orderBy))
        {
            $model = $model->orderBy($this->orderBy[0], $this->orderBy[1]);
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
            $response[] = $value->toArray();
        }

        return $response;
    }

}
