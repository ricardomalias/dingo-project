<?php

namespace App\Repository;

interface BaseRepositoryContract
{
    public function save(array $values);

    public function get(array $where);

    public function first(array $where);

    public function update(array $values, array $where);

    public function delete(array $where);
}
