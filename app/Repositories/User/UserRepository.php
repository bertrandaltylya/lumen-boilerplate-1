<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/24/18
 * Time: 3:23 PM
 */

namespace App\Repositories\User;

use App\Models\User\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }
}