<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 11/24/18
 * Time: 3:31 PM
 */

namespace App\Transformers;

use App\Models\Auth\User\User;

class UserTransformer extends BaseTransformer
{
    /**
     * A Fractal transformer.
     *
     * @param \App\Models\Auth\User\User $user
     * @return array
     */
    public function transform(User $user)
    {
        $response = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
        ];

        return $this->addTimesHumanReadable($user, $response);
    }
}
