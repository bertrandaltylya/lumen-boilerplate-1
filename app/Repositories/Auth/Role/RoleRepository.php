<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/16/18
 * Time: 11:28 AM
 */

namespace App\Repositories\Auth\Role;

use App\Repositories\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Validator\Contracts\ValidatorInterface;

class RoleRepository extends BaseRepository
{
    /**
     * Specify Validator Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|string',
        ],
    ];

    public function create(array $attributes)
    {
        $this->validate($attributes, ValidatorInterface::RULE_CREATE);

        $role = $this->model()::create($attributes);
        event(new RepositoryEntityUpdated($this, $role));
        return $this->parserResult($role);
    }

    private function validate(array $attributes, $rule)
    {
        $attributes = $this->model->newInstance()->forceFill($attributes)->makeVisible($this->model->getHidden())->toArray();
        $this->validator->with($attributes)->passesOrFail($rule);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return config('permission.models.role');
    }
}