<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/4/18
 * Time: 8:15 PM
 */

namespace App\Repositories\Traits;

use App\Criterion\Eloquent\OnlyTrashedCriteria;
use Prettus\Repository\Events\RepositoryEntityUpdated;

trait SoftDeletable
{
    /**
     * @param int $id
     * @return mixed
     */
    public function restore(int $id)
    {
        $this->pushCriteria(new OnlyTrashedCriteria);
        $user = $this->find($id);

        $user->restore();

        event(new RepositoryEntityUpdated($this, $user));
        return $user;
    }

    public function forceDelete(int $id)
    {
        $this->pushCriteria(new OnlyTrashedCriteria);
        $user = $this->find($id);

        $user->forceDelete();

        event(new RepositoryEntityUpdated($this, $user));
    }
}