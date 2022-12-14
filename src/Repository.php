<?php

namespace Hakimasrori\Repository;

use Hakimasrori\Repository\Contracts\RepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryContract
{
  protected $model;

  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function all(): Collection
  {
    return $this->model->all();
  }

  public function findWhere(array $attributes): Model
  {
    return $this->model->where($attributes)->first();
  }

  public function getWhere(array $attributes): Collection
  {
    return $this->model->where($attributes)->get();
  }

  public function create(array $attributes): Model
  {
    return $this->model->create($attributes);
  }

  public function update(array $attributes, int $id): Model
  {
    $model = $this->find($id);
    $model->update($attributes);
    return $model;
  }

  public function delete(int $id): bool
  {
    $model = $this->find($id);
    return $model->delete();
  }

  public function find(int $id): ?Model
  {
    return $this->model->findOrFail($id);
  }
}
