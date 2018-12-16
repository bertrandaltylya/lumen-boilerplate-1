<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/16/18
 * Time: 11:08 AM
 */

namespace App\Models\Auth\Permission;

use App\Traits\Hashable;
use App\Traits\HasResourceKeyTrait;

class Permission extends \Spatie\Permission\Models\Permission
{
    use Hashable;
    use HasResourceKeyTrait;

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected $resourceKey = 'permissions';
}