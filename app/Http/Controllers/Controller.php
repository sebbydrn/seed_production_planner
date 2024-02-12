<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Station;
use App\UserRoleSystem;
use App\Role;
use Browser, Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Browser name for logs
    public function browser() {
    	return Browser::browserName();
    }

    // Device for logs
    public function device() {
    	if (Browser::isMobile()) {
    		if (Browser::deviceModel() != "Unknown") {
    			return Browser::deviceModel();
    		} else {
    			return "Mobile";
    		}
    	} else if (Browser::isTablet()) {
    		if (Browser::deviceModel() != "Unknown") {
    			return Browser::deviceModel();
    		} else {
    			return "Tablet";
    		}
    	} else if (Browser::isDesktop()) {
    		return "Desktop";
    	}
    }

    // OS name for logs
    public function operating_system() {
        return Browser::platformName();
    }

    // Get all stations
    public function stations() {
        $stations = Station::orderBy('name', 'asc')->pluck('name', 'philrice_station_id')->toArray();
        return $stations;
    }

    // Get logged in user's role
    public function role() {
        if (!Auth::guest()) {
            $userID = Auth::user()->user_id;

            $userRoleSystem = UserRoleSystem::select('role_id')->where('user_id', '=', $userID)->where('system_id', '=', 15)->first();
            
            $roleID = $userRoleSystem->role_id;
            $role = Role::select('display_name')->where('role_id', '=', $roleID)->first();

            return $role->display_name;
        } else {
            return 'test';
        }
    }
    
}
