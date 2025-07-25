<?php

namespace App\Repository;

class BaseRepository
{
    public function all($model, $relations = [], $orderBy = [], $where = [])
    {
        return $model::query()
            ->where($where)
            ->with($relations)
            ->orderBy($orderBy)
            ->get();
    }

    public function show($model, $relations = [], $id)
    {
        if (!empty($relations)) {
            return $model::query()
                ->where('id', $id)
                ->with($relations)
                ->first();
        }
        return $model::query()
            ->find($id);
    }



    public function create($model, $data)
    {
        return $model::query()
            ->create($data);
    }

    public function update($item, $data)
    {
        $item =  $item->update($data);
        return $item->fresh();
    }

    public function delete($item)
    {
        return $item->delete();
    }
}
