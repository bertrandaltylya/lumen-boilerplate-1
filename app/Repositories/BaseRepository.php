<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/24/18
 * Time: 3:25 PM
 */

namespace App\Repositories;

use App\Criterion\Eloquent\ThisWhereEqualsCriteria;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository as BaseRepo;
use Prettus\Repository\Traits\CacheableRepository;

abstract class BaseRepository extends BaseRepo implements CacheableInterface
{
    use CacheableRepository;

    /**
     * @param string $keyColumn
     * @param array $columns
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function firstOrFailedByHashedId(string $keyColumn = 'id', $columns = ['*'])
    {

        $this->pushCriteria(new ThisWhereEqualsCriteria($keyColumn, $this->_decodeHashedKeyFromRequest($keyColumn)));

        $entity = $this->first($columns);
        if (is_null($entity)) {
            throw new ModelNotFoundException;
        }

        return $entity;
    }

    /**
     * @param $keyColumn
     * @return mixed
     */
    private function _decodeHashedKeyFromRequest($keyColumn)
    {
        // https://github.com/laravel/lumen-framework/issues/685#issuecomment-350376018
        // https://github.com/laravel/lumen-framework/issues/685#issuecomment-443393222
        $hashedKey = app('request')->route()[2][$keyColumn];

        $keyColumnValue = app('hashids')->decode($hashedKey);

        if (empty($keyColumnValue)) {
            throw new ModelNotFoundException;
        }

        return $keyColumnValue[0];
    }

    /**
     * @param array $newData
     * @param string $keyColumn
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateByHashedId(array $newData, string $keyColumn = 'id')
    {
        return $this->update($newData, $this->_decodeHashedKeyFromRequest($keyColumn));
    }
}