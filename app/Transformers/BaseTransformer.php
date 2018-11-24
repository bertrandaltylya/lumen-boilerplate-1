<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/25/18
 * Time: 12:50 AM
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
    /**
     * prepare human readable time with users timezone
     *
     * @param $entity
     * @param $responseData
     * @param array $columns
     * @return array
     * @author lloricode@gmail.com
     */
    public function addTimesHumanReadable($entity, $responseData, array $columns = []): array
    {

        $auth = app('auth');
        if (! $auth->check()) {
            return $responseData;
        }

        if (! $auth->user()->hasAnyRole(['admin', 'system'])) {
            return $responseData;
        }

        $return = [];

        $timeZone = $auth->check() ? $auth->user()->timezone : config('app.timezone');

        $readable = function ($column) use ($entity, $timeZone) {
            $at = $entity->{$column};

            return [
                $column => $at->format(config('settings.formats.datetime_12')),
                $column.'_readable' => $at->diffForHumans(),
                $column.'_tz' => $at->timezone($timeZone)->format(config('settings.formats.datetime_12')),
                $column.'_readable_tz' => $at->timezone($timeZone)->diffForHumans(),
            ];
        };

        if (count($columns) > 0) {
            foreach ($columns as $column) {
                $return = array_merge($return, $readable($column));
            }
        } else {
            foreach (['created_at', 'updated_at', 'deleted_at'] as $column) {
                $return = array_merge($return, (! is_null($entity->{$column})) ? array_merge($return, $readable($column)) : []);
            }
        }

        return array_merge($responseData, $return);
    }
}