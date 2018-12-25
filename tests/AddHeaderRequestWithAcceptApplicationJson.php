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

    /**
     * {@inheritdoc}
     */
    public function get($uri, array $headers = [])
    {
        return parent::get($uri, $this->appendHeader($headers));
    }

    /**
     * @param array $headers
     *
     * @return array
     */
    private function appendHeader(array $headers)
    {
        return array_merge([
            'Accept' => 'application/json',
        ], $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($uri, array $data = [], array $headers = [])
    {
        return parent::delete($uri, $data, $this->appendHeader($headers));
    }

    /**
     * {@inheritdoc}
     */
    public function put($uri, array $data = [], array $headers = [])
    {
        return parent::put($uri, $data, $this->appendHeader($headers));
    }

    /**
     * {@inheritdoc}
     */
    public function post($uri, array $data = [], array $headers = [])
    {
        return parent::post($uri, $data, $this->appendHeader($headers));
    }
}