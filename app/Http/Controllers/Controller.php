<?php

namespace App\Http\Controllers;

use App\Traits\Hashable;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use Traits\ResponseTrait;
    use Traits\TransformerTrait;
    use Hashable;
}
