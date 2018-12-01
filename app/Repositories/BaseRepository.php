<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/24/18
 * Time: 3:25 PM
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository as BaseRepo;
use Prettus\Repository\Traits\CacheableRepository;

abstract class BaseRepository extends BaseRepo implements CacheableInterface
{
    use CacheableRepository;

    public function firstOrFailedByHashedId(string $key = 'id', $columns = ['*'])
    {
        // https://github.com/laravel/lumen-framework/issues/685#issuecomment-350376018
        // https://github.com/laravel/lumen-framework/issues/685#issuecomment-443393222
        $hashedId = app('request')->route()[2][$key];

        $entity = parent::find(app('hashids')->decode($hashedId), $columns)->first();
        if (is_null($entity)) {
            throw  new ModelNotFoundException;
        }

        return $entity;
    }
}