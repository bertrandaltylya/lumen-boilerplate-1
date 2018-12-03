<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 4:27 PM
 */

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

trait Hashable
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param string $keyColumn
     * @return int
     */
    public function decodeId(Request $request, string $keyColumn = 'id'): int
    {
        // https://github.com/laravel/lumen-framework/issues/685#issuecomment-350376018
        // https://github.com/laravel/lumen-framework/issues/685#issuecomment-443393222
        $hashedKey = $request->route()[2][$keyColumn];

        $keyColumnValue = app('hashids')->decode($hashedKey);

        if (empty($keyColumnValue)) {
            throw new ModelNotFoundException;
        }

        return $keyColumnValue[0];
    }

    /**
     * @param string $key
     * @return string
     */
    public function getHashedId(string $key = 'id')
    {
        return app('hashids')->encode($this->{$key});
    }
}