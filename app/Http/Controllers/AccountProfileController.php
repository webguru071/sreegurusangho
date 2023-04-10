<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AccountProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware(['auth.user.role.check:Admin']);
        $this->middleware(['password.confirm'])->only('update');
    }


    public function index()
    {
        return view('account profile.index');
    }

    public function edit()
    {
        return view('account profile.edit');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'email|required',
                'password' => 'required',
            ],
            [
                'password.required' => 'This field is required',
                'name.required' => 'This field is required',
                'email.required' => 'This field is required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
            $saveStatus = array(
                "status" => "errors",
                "message" => "error",
            );
            try {

                DB::beginTransaction();
                $user = User::where('id',Auth::user()->id)->firstOrFail();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->updated_at = now();
                $user->update();
                DB::commit();

                $saveStatus["status"] = "status";
                $saveStatus["message"] = "Successfully update";
            }
            catch (Exception $ex) {
                DB::rollback();

                $saveStatus["status"] = "errors";
                $saveStatus["message"] = "Fail to update.".$ex->getMessage();
            }

            return redirect()->route("account.profile.index")->with([ $saveStatus["status"] =>  $saveStatus["message"]]);
    }
}
