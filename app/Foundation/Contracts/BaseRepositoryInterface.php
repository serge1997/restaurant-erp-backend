<?php
namespace App\Foundation\Contracts;

use App\Foundation\Base\BaseModel;
use App\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

interface BaseRepositoryInterface
{
    public function save(array $data): BaseModel|Model|Authenticatable;
    public function findAll(PaginateRequest $paginate);

    public function find($id);
    public function findByIds(array $ids);
    public function findBy(array $columns, mixed ...$values);
    public function findFirstBy(array $columns, array $values, string $direction = 'DESC', string $oderBy = 'id'): BaseModel|Model|Authenticatable|null;
    public function existBy(string $column, mixed $value): bool;

    public function update(BaseModel|Model|Authenticatable $model, array $data);

    public function delete(BaseModel|Model|Authenticatable $baseModel);

    public function saveMany(array $payload, bool $timestamps = true): void;
}

