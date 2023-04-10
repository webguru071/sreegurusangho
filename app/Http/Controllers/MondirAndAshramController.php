<?php

namespace App\Http\Controllers;

use Image;
use Exception;
use App\Models\CountryArea;
use Illuminate\Http\Request;
use App\Models\MondirAndAshram;
use App\Utilities\SystemConstant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MondirAndAshramController extends Controller
{
    private $stroageLink = "images/mondir-and-ashram/";

    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware(['auth.user.role.check:Admin']);
    }

    public function index()
    {
        $mondirAndAshrams = MondirAndAshram::orderBy("id","desc");

        $mondirAndAshrams = $mondirAndAshrams->paginate(50);
        return view('mondir and ashram.index',compact("mondirAndAshrams"));
    }

    public function add()
    {
        $branches = CountryArea::where("parent_id",null)->get();
        return view('mondir and ashram.add',compact("branches"));
    }

    public function edit($id)
    {
        $branches = CountryArea::where("parent_id",null)->get();
        $mondirAndAshram = MondirAndAshram::where("id",$id)->firstOrFail();
        return view('mondir and ashram.edit',compact("mondirAndAshram","branches"));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name_en' => 'required|string',
            'name_bn' => 'required|string',

            'branch' => 'required',

            'text_en' => 'nullable',
            'text_bn' => 'nullable',

            'image' => 'nullable',
        ],
        [
            'name_en.required' => 'Name (EN) is required.',
            'name_bn.required' => 'Name (BN) is required.',

            'branch.required_if' => 'Branch is required',

            'text_en.required' => 'Text (En) is required.',
            'text_bn.required' => 'Text (Bn) is required.',
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

            $mondirAndAshram = new MondirAndAshram();

            $mondirAndAshram->name_en = $request->name_en;
            $mondirAndAshram->name_bn = $request->name_bn;

            $mondirAndAshram->text_en = $request->text_en;
            $mondirAndAshram->text_bn = $request->text_bn;
            $mondirAndAshram->branch = $request->branch;

            $mondirAndAshram->image = $newImageName;
            $mondirAndAshram->created_by_id = Auth::user()->id;

            $mondirAndAshram->save();

            if($request->hasFile('image')){
                //$request->image->move(public_path($this->stroageLink), $newImageName);
                $image = $request->file('image');

                $destinationPath = public_path($this->stroageLink);
                $imgFile = Image::make($image->path());
                $imgFile->fit(375, 561, function ($constraint) {
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

        return redirect()->route("mondir.and.ashram.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }

    public function update(Request $request,$id){
        $validator = Validator::make($request->all(),
        [
            'name_en' => 'required|string',
            'name_bn' => 'required|string',

            'branch' => 'required',

            'text_en' => 'nullable',
            'text_bn' => 'nullable',

            'image' => 'nullable',
        ],
        [
            'name_en.required' => 'Name (EN) is required.',
            'name_bn.required' => 'Name (BN) is required.',

            'branch.required_if' => 'Branch is required',

            'text_en.required' => 'Text (En) is required.',
            'text_bn.required' => 'Text (Bn) is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateStatus = array(
            "status" => "errors",
            "message" => "error",
        );
        DB::beginTransaction();
// return $request;
        try{
            $oldImageName = MondirAndAshram::where("id",$id)->firstOrFail()->image;
            $newImageName = $oldImageName;
            if($request->hasFile('image')){
                $newImageName = SystemConstant::generateFileName("image",$request->image->getClientOriginalExtension(),200);
            }

            $mondirAndAshram = MondirAndAshram::where("id",$id)->firstOrFail();

            $mondirAndAshram->name_en = $request->name_en;
            $mondirAndAshram->name_bn = $request->name_bn;

            $mondirAndAshram->text_en = $request->text_en;
            $mondirAndAshram->text_bn = $request->text_bn;
            $mondirAndAshram->branch = $request->branch;

            $mondirAndAshram->image = $newImageName;
            $mondirAndAshram->created_by_id = Auth::user()->id;

            $mondirAndAshram->update();

            if($request->hasFile('image')){
                if(!($oldImageName == null)){
                    if(file_exists(public_path($this->stroageLink.$oldImageName))){
                        unlink(public_path($this->stroageLink.$oldImageName));
                    }
                }
                $image = $request->file('image');

                $destinationPath = public_path($this->stroageLink);
                $imgFile = Image::make($image->path());
                $imgFile->fit(375, 561, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$newImageName);
                //$request->image->move(public_path($this->stroageLink), $newImageName);
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

        return redirect()->route("mondir.and.ashram.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }

    public function delete($id){
        $updateStatus = array(
            "status" => "errors",
            "message" => array(),
        );

        $oldImageName = MondirAndAshram::where("id",$id)->firstOrFail()->image;

        try{
            DB::beginTransaction();
            $mondirandashram = MondirAndAshram::where("id",$id)->firstOrFail();
            $mondirandashram->delete();
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
        return redirect()->route("mondir.and.ashram.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }
}
