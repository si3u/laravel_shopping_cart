<?php

namespace App\Http\Controllers;

use App\ActiveLocalization;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $active_local;
    protected $active_local_id;
    protected $count_active_local;
    protected $route_name;

    public function __construct() {
        $this->active_local = ActiveLocalization::GetActive();
        $this->route_name = \Route::currentRouteName();
        $this->count_active_local = count($this->active_local);
        $i = 0;
        while ($i < $this->count_active_local) {
            $this->active_local_id[] = $this->active_local[$i]->id;
            $i++;
        }
    }
}
