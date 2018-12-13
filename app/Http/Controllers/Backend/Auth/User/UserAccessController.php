<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 4:52 PM
 */

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;

/**
 * Class UserAccessController
 *
 * @package App\Http\Controllers\Backend\Auth\User
 * @group   User Management
 */
class UserAccessController extends Controller
{
    /**
     * Get current authenticated user.
     *
     * @return \Spatie\Fractalistic\Fractal
     * @authenticated
     * @response {
     * "data": {
     * "type": "users",
     * "id": "KY31NvmVPjeE0y6eBO4DwxRbzrGoJqnk",
     * "attributes": {
     * "first_name": "Dovie",
     * "last_name": "Homenick",
     * "email": "admin@admin.com"
     * }
     * },
     * "meta": {
     * "include": [
     * "roles"
     * ]
     * }
     * }
     */
    public function profile()
    {
        return $this->transform(app('auth')->user(), new UserTransformer);
    }
}