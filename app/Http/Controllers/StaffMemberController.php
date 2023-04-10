<?php

namespace App\Http\Controllers;

use Image;
use Exception;
use App\Models\CountryArea;
use Illuminate\Http\Request;
use App\Models\StaffMember;
use App\Utilities\SystemConstant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StaffMemberController extends Controller
{
    private $stroageLink = "images/staff-member/";

    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware(['auth.user.role.check:Admin']);
    }

    public function index()
    {
        $staffMembers = StaffMember::orderBy("id","desc");

        $staffMembers = $staffMembers->paginate(50);
        return view('staff member.index',compact("staffMembers"));
    }

    public function add()
    {
        $branches = CountryArea::tree()->get()->toTree();;
        return view('staff member.add');
    }

    public function edit($id)
    {
        $staffMember = StaffMember::where("id",$id)->firstOrFail();
        return view('staff member.edit',compact("staffMember"));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name_en' => 'required|string',
            'name_bn' => 'required',

            'short_text_en' => 'nullable',
            'short_text_bn' => 'nullable',

            'text_en' => 'nullable',
            'text_en' => 'nullable',

            'image' => 'nullable',
        ],
        [
            'name_en.required' => 'Name (EN) is required.',
            'name_bn.required' => 'Name (BN) is required.',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateStatus = array(
            "status" => "errors",
            "message" => "error",
        );
        DB::beginTransaction();

        try{

            $newImageName = null;
            if($request->hasFile('image')){
                $newImageName = SystemConstant::generateFileName("image",$request->image->getClientOriginalExtension(),200);
            }

            $staffMember = new StaffMember();

            $staffMember->name_en = $request->name_en;
            $staffMember->name_bn = $request->name_bn;

            $staffMember->short_text_en = $request->short_text_en;
            $staffMember->short_text_bn = $request->short_text_bn;

            $staffMember->text_en = $request->text_en;
            $staffMember->text_bn = $request->text_bn;

            $staffMember->type = "MedicineService";

            $staffMember->image = $newImageName;
            $staffMember->created_by_id = Auth::user()->id;

            $staffMember->save();

            if($request->hasFile('image')){
                //$request->image->move(public_path($this->stroageLink), $newImageName);
                $image = $request->file('image');

                $destinationPath = public_path($this->stroageLink);
                $imgFile = Image::make($image->path());
                $imgFile->fit(508, 330, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$newImageName);
            }

            DB::commit();

            $updateStatus["status"] = "status";
            $updateStatus["message"] = "Successfully save.";

        }
        catch (Exception $ex) {
            DB::rollback();

            $saveStatus["status"] = "errors";
            $saveStatus["message"] = "Fail to add.".$ex->getMessage();
        }

        return redirect()->route("staff.member.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }

    public function update(Request $request,$id){
        $validator = Validator::make($request->all(),
        [
            'name_en' => 'required|string',
            'name_bn' => 'required',

            'short_text_en' => 'nullable',
            'short_text_bn' => 'nullable',

            'text_en' => 'nullable',
            'text_en' => 'nullable',

            'image' => 'nullable',
        ],
        [
            'name_en.required' => 'Name (EN) is required.',
            'name_bn.required' => 'Name (BN) is required.',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateStatus = array(
            "status" => "errors",
            "message" => "error",
        );
        DB::beginTransaction();

        try{
            $oldImageName = StaffMember::where("id",$id)->firstOrFail()->image;
            $newImageName = $oldImageName;
            if($request->hasFile('image')){
                $newImageName = SystemConstant::generateFileName("image",$request->image->getClientOriginalExtension(),200);
            }

            $staffMember = StaffMember::where("id",$id)->firstOrFail();

            $staffMember->name_en = $request->name_en;
            $staffMember->name_bn = $request->name_bn;

            $staffMember->short_text_en = $request->short_text_en;
            $staffMember->short_text_bn = $request->short_text_bn;

            $staffMember->text_en = $request->text_en;
            $staffMember->text_bn = $request->text_bn;

            $staffMember->image = $newImageName;
            $staffMember->created_by_id = Auth::user()->id;

            $staffMember->update();

            if($request->hasFile('image')){
                if(!($oldImageName == null)){
                    if(file_exists(public_path($this->stroageLink.$oldImageName))){
                        unlink(public_path($this->stroageLink.$oldImageName));
                    }
                }
                //$request->image->move(public_path($this->stroageLink), $newImageName);

                $image = $request->file('image');

                $destinationPath = public_path($this->stroageLink);
                $imgFile = Image::make($image->path());
                $imgFile->fit(508, 330, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$newImageName);
            }

            DB::commit();

            $updateStatus["status"] = "status";
            $updateStatus["message"] = "Successfully save.";

        }
        catch (Exception $ex) {
            DB::rollback();

            $saveStatus["status"] = "errors";
            $saveStatus["message"] = "Fail to add.".$ex->getMessage();
        }

        return redirect()->route("staff.member.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }

    public function delete($id){
        $updateStatus = array(
            "status" => "errors",
            "message" => array(),
        );

        $oldImageName = StaffMember::where("id",$id)->firstOrFail()->image;

        try{
            DB::beginTransaction();
            $staffmember = StaffMember::where("id",$id)->firstOrFail();
            $staffmember->delete();
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
        return redirect()->route("staff.member.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }
}
