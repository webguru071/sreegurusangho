<?php

namespace App\Http\Controllers;

use Image;
use Exception;
use App\Models\CountryArea;
use Illuminate\Http\Request;
use App\Models\CouncilMember;
use App\Utilities\SystemConstant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CouncilMemberController extends Controller
{
    private $stroageLink = "images/council-member/";

    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware(['auth.user.role.check:Admin']);
    }

    public function index()
    {
        $councilMembers = CouncilMember::orderBy("id","desc");

        $councilMembers = $councilMembers->paginate(50);
        return view('council member.index',compact("councilMembers"));
    }

    public function add()
    {
        $branches = CountryArea::tree()->get()->toTree();;
        return view('council member.add',compact("branches"));
    }

    public function edit($id)
    {
        $branches = CountryArea::tree()->get()->toTree();
        $councilMember = CouncilMember::where("id",$id)->firstOrFail();
        return view('council member.edit',compact("councilMember","branches"));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name_en' => 'required|string',
            'name_bn' => 'required|string',

            'branch' => 'required_if:council,Board of director',

            'council' => 'required|in:Honorable governing council,Board of director',

            'membership_type' => 'required|in:Honorable advisory council,Attendant association council,Honorable executive council',
            'member_position' => 'nullable',
            'member_position_bn' => 'nullable',

            'short_description_en' => 'nullable',
            'short_description_bn' => 'nullable',

            'description_en' => 'nullable',
            'description_bn' => 'nullable',

            'image' => 'nullable',
        ],
        [
            'name_en.required' => 'Name (EN) is required.',
            'name_bn.required' => 'Name (BN) is required.',

            'branch.required_if' => 'Branch is required',

            'council.required' => 'Council is required.',
            'membership_type.required' => 'Membership type is required.',
            'member_position.required' => 'Member position is required.',

            'short_description_en.required' => 'Short description (En) is required.',
            'short_description_bn.required' => 'Short description (Bn) is required.',

            'description_en.required' => 'Description (En) is required.',
            'description_bn.required' => 'Description (Bn) is required.',
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

            $councilMember = new CouncilMember();

            $councilMember->name_en = $request->name_en;
            $councilMember->name_bn = $request->name_bn;

            $councilMember->short_description_en = $request->short_description_en;
            $councilMember->short_description_bn = $request->short_description_bn;

            $councilMember->description_en = $request->description_en;
            $councilMember->description_bn = $request->description_bn;

            $councilMember->membership_type = $request->membership_type;
            $councilMember->member_position = $request->member_position;
            $councilMember->member_position_bn = $request->member_position_bn;

            $councilMember->council = $request->council;
            $councilMember->branch = $request->branch;

            $councilMember->image = $newImageName;
            $councilMember->created_by_id = Auth::user()->id;

            $councilMember->save();

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

        return redirect()->route("council.member.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }

    public function update(Request $request,$id){
        $validator = Validator::make($request->all(),
        [
            'name_en' => 'required|string',
            'name_bn' => 'required|string',

            'branch' => 'required_if:council,Board of director',

            'council' => 'required|in:Honorable governing council,Board of director',

            'membership_type' => 'required|in:Honorable advisory council,Attendant association council,Honorable executive council',
            'member_position' => 'nullable',
            'member_position_bn' => 'nullable',

            'short_description_en' => 'nullable',
            'short_description_bn' => 'nullable',

            'description_en' => 'nullable',
            'description_bn' => 'nullable',

            'image' => 'nullable',
        ],
        [
            'name_en.required' => 'Name (EN) is required.',
            'name_bn.required' => 'Name (BN) is required.',

            'branch.required_if' => 'Branch is required',

            'council.required' => 'Council is required.',
            'membership_type.required' => 'Membership type is required.',
            'member_position.required' => 'Member position is required.',

            'short_description_en.required' => 'Short description (En) is required.',
            'short_description_bn.required' => 'Short description (Bn) is required.',

            'description_en.required' => 'Description (En) is required.',
            'description_bn.required' => 'Description (Bn) is required.',
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
            $oldImageName = CouncilMember::where("id",$id)->firstOrFail()->image;
            $newImageName = $oldImageName;
            if($request->hasFile('image')){
                $newImageName = SystemConstant::generateFileName("image",$request->image->getClientOriginalExtension(),200);
            }

            $councilMember = CouncilMember::where("id",$id)->firstOrFail();

            $councilMember->name_en = $request->name_en;
            $councilMember->name_bn = $request->name_bn;

            $councilMember->short_description_en = $request->short_description_en;
            $councilMember->short_description_bn = $request->short_description_bn;

            $councilMember->description_en = $request->description_en;
            $councilMember->description_bn = $request->description_bn;

            $councilMember->membership_type = $request->membership_type;
            $councilMember->member_position = $request->member_position;
            $councilMember->member_position_bn = $request->member_position_bn;

            $councilMember->council = $request->council;
            $councilMember->branch = $request->branch;

            $councilMember->image = $newImageName;
            $councilMember->created_by_id = Auth::user()->id;

            $councilMember->update();

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

        return redirect()->route("council.member.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }

    public function delete($id){
        $updateStatus = array(
            "status" => "errors",
            "message" => array(),
        );

        $oldImageName = CouncilMember::where("id",$id)->firstOrFail()->image;

        try{
            DB::beginTransaction();
            $councilmember = CouncilMember::where("id",$id)->firstOrFail();
            $councilmember->delete();
            DB::commit();
            $updateStatus["status"] = "status";
            $updateStatus["message"] = "Successfully delete.";

            if(file_exists(public_path($this->stroageLink.$oldImageName))){
                unlink(public_path($this->stroageLink.$oldImageName));
            }
        }
        catch (Exception $ex) {
            DB::rollback();

            $updateStatus["status"] = "errors";
            $updateStatus["message"] = "Fail to delete.".$ex->getMessage();
        }
        return redirect()->route("council.member.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }
}
