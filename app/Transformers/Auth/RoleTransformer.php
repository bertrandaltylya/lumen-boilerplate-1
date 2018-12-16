<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/24/18
 * Time: 3:31 PM
 */

namespace App\Transformers\Auth;

use App\Models\Auth\Role\Role;
use App\Transformers\BaseTransformer;

class RoleTransformer extends BaseTransformer
{
    /**
     * @var  array
     */
    protected $availableIncludes = [
    ];

    /**
     * A Fractal transformer.
     *
     * @param Role $role
     *
     * @return array
     */
    public function transform(Role $role)
    {
        return [
            'id' => $role->getHashedId(),
            'name' => $role->name,
        ];
    }
}
