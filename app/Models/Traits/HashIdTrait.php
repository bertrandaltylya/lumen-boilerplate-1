<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/25/18
 * Time: 8:25 PM
 */

namespace App\Models\Traits;

trait HashIdTrait
{
    public function getHashedId()
    {
        return app('hashids')->encode($this->id);
    }
}