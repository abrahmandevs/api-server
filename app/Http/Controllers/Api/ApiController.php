<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\apiResponses;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use apiResponses;

    protected $policyClass;
    //
    public function include(string $relationship) :bool {
        $param = request()->get('include');

        if (!isset($param)) {
            return false;
        }

        $includeValues = explode(',', strtolower($param));
        return in_array(strtolower($relationship), $includeValues);
    }

    public function isAble($ability, $targetModel){
        $this->authorize($ability, [$targetModel, $this->policyClass]);
    }
}
