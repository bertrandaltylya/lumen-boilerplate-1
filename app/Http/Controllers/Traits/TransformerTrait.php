<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/1/18
 * Time: 1:13 PM
 */

namespace App\Http\Controllers\Traits;

use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;
use Spatie\Fractal\Fractal;

trait TransformerTrait
{
    /**
     * @param $data
     * @param TransformerAbstract $transformer
     * @return \Spatie\Fractalistic\Fractal
     */
    protected function transform($data, TransformerAbstract $transformer)
    {
        return Fractal::create($data, $transformer)
            ->withResourceName($this->_getResourceKey($data))
            ->addMeta([
                'include' => $transformer->getAvailableIncludes(),
            ]);
    }

    /**
     * @param $data
     * @return string|null
     */
    private function _getResourceKey($data)
    {
        if ($data instanceof AbstractPaginator) {
            $model = $data->getCollection()->first();
        } elseif ($data instanceof Collection) {
            $model = $data->first();
        } else {
            $model = $data;
        }
        if (empty($model)) {
            return null;
        }
        return $model->getResourceKey();
    }
}