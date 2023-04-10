<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\DonateAccount;
use Illuminate\Http\Request;
use App\Utilities\SystemConstant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DonateAccountController extends Controller
{
    private $stroageLink = "images/donate-account/";

    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware(['auth.user.role.check:Admin']);
    }

    public function index()
    {
        $donateAccounts = DonateAccount::orderBy("id","desc");

        $donateAccounts = $donateAccounts->paginate(50);
        return view('donate account.index',compact("donateAccounts"));
    }

    public function add()
    {
        return view('donate account.add');
    }

    public function edit($id)
    {
        $donateAccount = DonateAccount::where("id",$id)->firstOrFail();
        return view('donate account.edit',compact("donateAccount"));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name_en' => 'required|string',
                'name_bn' => 'required|string',

                'account_en' => 'required',
                'account_bn' => 'required',

                'image' => 'nullable',
            ],
            [
                'name_en.required' => 'Name (EN) is required.',
                'name_bn.required' => 'Name (BN) is required.',

                'account_en.required' => 'Account (EN) is required.',
                'account_bn.required' => 'Account (BN) is required.',

                'image.mimes' => 'Image must be image(jpg,jpeg,png)',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateStatus = array(
            "status" => "errors",
            "message" => "error",
        );
        $newImageName = null;
        if( $request->file("image") ){
            $newImageName = SystemConstant::generateFileName("image",$request->file("image")->getClientOriginalExtension(),200);
        }
        try {

            DB::beginTransaction();
                $donateAccount = new DonateAccount();

                $donateAccount->name_en = $request->name_en;
                $donateAccount->name_bn = $request->name_bn;
                $donateAccount->account_en = $request->account_en;
                $donateAccount->account_bn = $request->account_bn;

                $donateAccount->created_by_id = Auth::user()->id;

                $donateAccount->image = $newImageName;

                $donateAccount->save();

                if( $request->file("image")){
                    $request->image->move(public_path($this->stroageLink), $newImageName);
                }
            DB::commit();

            $updateStatus["status"] = "status";
            $updateStatus["message"] = "Successfully update";
        }
        catch (Exception $ex) {
            DB::rollback();

            $updateStatus["status"] = "errors";
            $updateStatus["message"] = "Fail to update.".$ex->getMessage();
        }

        return redirect()->route("donate.account.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }


    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),
            [
                'name_en' => 'required|string',
                'name_bn' => 'required|string',

                'account_en' => 'required',
                'account_bn' => 'required',

                'image' => 'nullable',
            ],
            [
                'name_en.required' => 'Name (EN) is required.',
                'name_bn.required' => 'Name (BN) is required.',

                'account_en.required' => 'Account (EN) is required.',
                'account_bn.required' => 'Account (BN) is required.',

                'image.mimes' => 'Image must be image(jpg,jpeg,png)',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateStatus = array(
            "status" => "errors",
            "message" => "error",
        );

        $oldImageName = DonateAccount::where("id",$id)->firstOrFail()->image;

        try {
            $newImageName = $oldImageName;

            if( ($request->hasFile('image')) ){
                $newImageName = SystemConstant::generateFileName("image",$request->file("image")->getClientOriginalExtension(),200);
            }

            DB::beginTransaction();
                $donateAccount = DonateAccount::where("id",$id)->firstOrFail();
                $donateAccount->name_en = $request->name_en;
                $donateAccount->name_bn = $request->name_bn;
                $donateAccount->account_en = $request->account_en;
                $donateAccount->account_bn = $request->account_bn;
                $donateAccount->image = $newImageName;
                $donateAccount->update();

                if( $request->hasFile('image') &&  !($newImageName == null)){
                    if(!($oldImageName == null)){
                        if(file_exists(public_path($this->stroageLink.$oldImageName))){
                            unlink(public_path($this->stroageLink.$oldImageName));
                        }
                    }
                    $request->image->move(public_path($this->stroageLink), $newImageName);
                }
            DB::commit();

            $updateStatus["status"] = "status";
            $updateStatus["message"] = "Successfully update.";
        }
        catch (Exception $ex) {
            DB::rollback();

            $updateStatus["status"] = "errors";
            $updateStatus["message"] = "Fail to update.".$ex->getMessage();
        }

        return redirect()->route("donate.account.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }

    public function delete($id){
        $updateStatus = array(
            "status" => "errors",
            "message" => array(),
        );

        $oldImageName = DonateAccount::where("id",$id)->firstOrFail()->image;

        try{
            DB::beginTransaction();
            $donateAccount = DonateAccount::where("id",$id)->firstOrFail();
            $donateAccount->delete();
            DB::commit();
            $updateStatus["status"] = "status";
            $updateStatus["message"] = "Successfully delete.";

            if(!($oldImageName == null)){
                if(file_exists(public_path($this->stroageLink.$oldImageName))){
                    unlink(public_path($this->stroageLink.$oldImageName));
                }
            }
        }
        catch (Exception $ex) {
            DB::rollback();

            $updateStatus["status"] = "errors";
            $updateStatus["message"] = "Fail to delete.".$ex->getMessage();
        }
        return redirect()->route("donate.account.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }
}
