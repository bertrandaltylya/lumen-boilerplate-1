<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/9/18
 * Time: 8:31 PM
 */

namespace App\Traits;

use Illuminate\Support\Pluralizer;
use ReflectionClass;

trait HasResourceKeyTrait
{
    /**
     * @return string
     * @throws \ReflectionException
     */
    public function getResourceKey()
    {
        if (isset($this->resourceKey)) {
            $resourceKey = $this->resourceKey;
        } else {
            $reflect = new ReflectionClass($this);
            $resourceKey = strtolower(Pluralizer::plural($reflect->getShortName()));
        }

        return $resourceKey;
    }

}