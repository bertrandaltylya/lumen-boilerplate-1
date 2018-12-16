<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/9/18
 * Time: 8:04 PM
 */

namespace App\Models\Auth\Role;

use App\Traits\Hashable;
use App\Traits\HasResourceKeyTrait;

class Role extends \Spatie\Permission\Models\Role
{
    use Hashable;
    use HasResourceKeyTrait;

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected $resourceKey = 'roles';

    /**
     * all permissions
     *
     * name => value
     */
    const PERMISSIONS = [
        'index' => 'role index',
        'create' => 'role store',
        'show' => 'role show',
        'update' => 'role update',
        'destroy' => 'role destroy',
    ];
}