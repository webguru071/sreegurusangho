<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\CountryArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CountryAreaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware(['auth.user.role.check:Admin']);
    }

    public function index(Request $request){
        $pagination = 50;

        $countryAreas = CountryArea::orderby("created_at","desc");

        $countryAreas = $countryAreas->paginate($pagination);

        return view('country area.index',compact("countryAreas"));
    }

    public function add(){
        $countryAreas = CountryArea::where('parent_id',null)->get();
        return view('country area.add',compact("countryAreas"));
    }

    public function edit($id){
        $countryAreas = CountryArea::where('parent_id',null)->get();
        $countryArea = CountryArea::where("id",$id)->firstOrFail();
        return view('country area.edit',compact("countryAreas","countryArea"));

    }


    public function save(Request $request){
        $validator = Validator::make($request->all(),
            [
                'name_en' => 'required|max:200',
                'name_bn' => 'required',
                'has_a_parent' => 'required|string|in:Yes,No',
                'parent' => 'nullable|required_if:has_a_parent,Yes',
            ],
            [
                'name.required' => 'Name is required.',
                'name.max' => 'Name length can not greater then 200 chars.',

                'has_a_parent.required' => 'Has a parent contract category is required.',
                'has_a_parent.string' => 'Has a parent contract category must be a string.',
                'has_a_parent.in' => 'Has a parent contract category must be one out of [Yes,No].',

                'parent.required_if' => 'Parent must is required.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $statusInformation = array("status" => "errors","message" =>"error");

            DB::beginTransaction();
            try {
                $countryArea = new CountryArea();
                $countryArea->name_en = $request->name_en;
                $countryArea->name_bn = $request->name_bn;
                $countryArea->parent_id = ($request->has_a_parent=="No") ? null : $request->parent;
                $countryArea->created_at = now();
                $countryArea->created_by_id = Auth::user()->id;
                $countryArea->updated_at = null;
                $countryArea->save();
                DB::commit();

                $statusInformation["status"] = "status";
                $statusInformation["message"] = "Successfully save.";
            } catch (Exception $ex) {
                DB::rollback();

                $statusInformation["status"] = "errors";
                $statusInformation["message"] = "Fail to delete.".$ex->getMessage();
            }

        return redirect()->route("country.area.index")->with([$statusInformation["status"] => $statusInformation["message"]]);
    }

    public function update(Request $request,$id){
        $validator = Validator::make($request->all(),
            [
                'name_en' => 'required|max:200',
                'name_bn' => 'required',
                'has_a_parent' => 'required|string|in:Yes,No',
                'parent' => 'nullable|required_if:has_a_parent,Yes',
            ],
            [
                'name.required' => 'Name is required.',
                'name.max' => 'Name length can not greater then 200 chars.',

                'parent.required_if' => 'Parent must is required.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $statusInformation = array("status" => "errors","message" =>"error");

        DB::beginTransaction();
        try {
            $countryArea = CountryArea::where("id",$id)->firstOrFail();
            $countryArea->name_en = $request->name_en;
            $countryArea->name_bn = $request->name_bn;
            $countryArea->parent_id = ($request->has_a_parent=="No") ? null : $request->parent;
            $countryArea->created_by_id = Auth::user()->id;
            $countryArea->updated_at = now();
            $countryArea->update();
            DB::commit();

            $statusInformation["status"] = "status";
            $statusInformation["message"] = "Successfully update.";
        } catch (Exception $ex) {
            DB::rollback();

            $statusInformation["status"] = "errors";
            $statusInformation["message"] = "Fail to delete.".$ex->getMessage();
        }

        return redirect()->route("country.area.index")->with([$statusInformation["status"] => $statusInformation["message"]]);
    }

    public function delete($id){
        $statusInformation = array("status" => "errors","message" =>"error");
        DB::beginTransaction();
        try {
            $countryArea = CountryArea::where("id",$id)->firstOrFail();
            $countryAreaTreeIds =  $countryArea->countryAreas()->pluck("id")->toArray();
            $councilMembers =  $countryArea->councilMembers()->pluck("id")->toArray();
            if((count($countryAreaTreeIds) == 0) && (count($councilMembers) == 0)){
                $countryArea->delete();

                $statusInformation["status"] = "status";
                $statusInformation["message"] = "Successfully delete.";
                DB::commit();
            }
            else{
                $statusInformation["message"] = "Fail to delete.Contain dependency record.";
            }

        } catch (Exception $ex) {
            DB::rollback();

            $statusInformation["status"] = "errors";
            $statusInformation["message"] = "Fail to delete.".$ex->getMessage();
        }

        return redirect()->route("country.area.index")->with([$statusInformation["status"] => $statusInformation["message"]]);
    }
}
