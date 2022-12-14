<?php

namespace Hakimasrori\Repository\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryContract
{
  public function all(): Collection;

  public function findWhere(array $attributes): Model;

  public function getWhere(array $attributes): Collection;

  public function create(array $attributes): Model;

  public function update(array $attributes, int $id): Model;

  public function delete(int $id): bool;

  public function find(int $id): ?Model;
}
