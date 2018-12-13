<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/24/18
 * Time: 3:23 PM
 */

namespace App\Repositories\Auth\User;

use App\Models\Auth\User\User;
use App\Repositories\BaseRepository;
use App\Repositories\Traits\SoftDeletable;
use Prettus\Validator\Contracts\ValidatorInterface;

class UserRepository extends BaseRepository
{
    use SoftDeletable;

    protected $fieldSearchable = [
        'first_name' => 'like',
        'last_name' => 'like',
        'email' => 'like',
    ];

    /**
     * Specify Validator Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'email|unique:users,email',
        ]
    ];


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