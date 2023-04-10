<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUserRoleCheck
{
    public function handle(Request $request, Closure $next,...$requiredUserRoles)
    {
        if($this->checkUserRole($requiredUserRoles) == true){
            return $next($request);
        }
        else{
            return redirect("home")->with(['warning'=>'You are not authorise to access this.']);
        }
    }

    private function checkUserRole($requiredUserRoles){
        $userHasUserPermission = false;

        foreach($requiredUserRoles as $perRequiredUserRole){
            if(Auth::user()->user_role == $perRequiredUserRole){
                $userHasUserPermission=true;
            }
        }

        return $userHasUserPermission;
    }
}
