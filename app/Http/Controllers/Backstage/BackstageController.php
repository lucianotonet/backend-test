<?php

namespace App\Http\Controllers\Backstage;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class BackstageController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
