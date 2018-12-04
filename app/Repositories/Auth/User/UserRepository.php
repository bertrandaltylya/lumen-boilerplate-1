<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/24/18
 * Time: 3:23 PM
 */

namespace App\Repositories\Auth\User;

use App\Criterion\Eloquent\OnlyTrashedCriteria;
use App\Models\Auth\User\User;
use App\Repositories\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityUpdated;

class UserRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'first_name' => 'like',
        'last_name' => 'like',
        'email' => 'like',
    ];


    /**
     * @param int $id
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function restore(int $id)
    {
        $this->pushCriteria(new OnlyTrashedCriteria);
        $user = $this->find($id);

        $user->restore();

        event(new RepositoryEntityUpdated($this, $user));
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function create(array $attributes)
    {
        $attributes['password'] = app('hash')->make($attributes['password']);

        return parent::create($attributes);
    }
}