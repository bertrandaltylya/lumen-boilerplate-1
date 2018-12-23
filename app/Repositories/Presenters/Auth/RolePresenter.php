<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/23/18
 * Time: 9:49 AM
 */

namespace App\Repositories\Presenters\Auth;

use App\Repositories\Presenters\BasePresenter;
use App\Transformers\Auth\RoleTransformer;

class RolePresenter extends BasePresenter
{

    public function __construct()
    {
        parent::__construct();
        $this->resourceKeyItem =
        $this->resourceKeyCollection = 'roles';

    }

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RoleTransformer;
    }
}