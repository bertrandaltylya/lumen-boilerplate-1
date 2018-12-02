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

class UserAccessController extends Controller
{
    /**
     * @return \Spatie\Fractalistic\Fractal
     * @throws \ReflectionException
     */
    public function profile()
    {
        return $this->transform(app('auth')->user(), new UserTransformer);
    }
}