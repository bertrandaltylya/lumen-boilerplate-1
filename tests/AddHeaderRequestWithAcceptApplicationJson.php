<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/25/18
 * Time: 2:39 PM
 */

namespace Tests;

trait AddHeaderRequestWithAcceptApplicationJson
{
    /**
     * {@inheritdoc}
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        $h = $this->transformHeadersToServerVars([
            'Accept' => 'application/json',
        ]);
        return parent::call($method, $uri, $parameters, $cookies, $files, array_merge($server, $h), $content);
    }
}