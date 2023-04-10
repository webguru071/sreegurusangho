<?php

namespace App\Http\Controllers;

use Str;
use Image;
use Exception;
use App\Models\DynamicPage;
use Illuminate\Http\Request;
use App\Utilities\SystemConstant;
use App\Models\DynamicPageSection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DynamicPageController extends Controller
{
    private $stroageLink = "images/dynamicpage/";

    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware(['auth.user.role.check:Admin']);
    }

    public function index()
    {
        $dynamicPages = DynamicPage::orderBy("id","desc");

        $dynamicPages = $dynamicPages->paginate(100);
        return view('dynamic page.index',compact('dynamicPages'));
    }

    public function add()
    {
        $templateList = array(
            "Home" => "Home",
            "Event" => "Event",
            "Contact" => "Contact",
            "Service" => "Service",
            "ImageGallary" => "Image Gallary",
            "VideoGallary" => "Video Gallary",
            "SriGuruSangha" => "Sri Guru Sangha",
            "AshramAndMondir" => "Ashram & Mondir",
            "GoverningCouncil" => "Governing Council",
            "VariousBranchesForBoardOfDirectors" => "Various branches (Board Of Directors)",

            "BoardOfDirectorsOfVariousBranches" => "Board of Directors of various branches",
        );
        return view('dynamic page.create',compact("templateList"));
    }

    public function edit($id)
    {
        $dynamicPage = DynamicPage::where("id",$id)->firstOrFail();
        $templateList = array(
            "Home" => "Home",
            "Event" => "Event",
            "Contact" => "Contact",
            "Service" => "Service",
            "ImageGallary" => "Image Gallary",
            "VideoGallary" => "Video Gallary",
            "SriGuruSangha" => "Sri Guru Sangha",
            "AshramAndMondir" => "Ashram & Mondir",
            "GoverningCouncil" => "Governing Council",
            "VariousBranchesForBoardOfDirectors" => "Various branches (Board Of Directors)",

            "BoardOfDirectorsOfVariousBranches" => "Board of Directors of various branches",
        );
        return view('dynamic page.edit', compact('dynamicPage',"templateList"));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:255|unique:dynamic_pages,name',

                'title_en' => 'required',
                'title_bn' => 'required',

                'text_en' => 'nullable',
                'text_bn' => 'nullable',

                'image' => 'nullable',
            ],
            [
                'name.required' => 'Name (EN) is required.',
            ]
        );

        $validator->after(function ($validator) {
            $afterValidatorData = $validator->getData();
            $dynamicPageCount = DynamicPage::where("template",$afterValidatorData["template"])->count();

            if($dynamicPageCount > 0 ){
                $validator->errors()->add(
                    'template', "Page for selected template already exit."
                );
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $status = array(
            "status" => "errors",
            "message" => "error",
        );

        try {
            $newImageName = null;

            if( $request->file("image") ){
                $newImageName = SystemConstant::generateFileName("image",$request->file("image")->getClientOriginalExtension(),200);
            }

            DB::beginTransaction();
                $dynamicpage = new DynamicPage();

                $dynamicpage->name = $request->name;
                $dynamicpage->template = $request->template;
                $dynamicpage->slug = Str::slug($request->name);

                $dynamicpage->title_en = $request->title_en;
                $dynamicpage->title_bn = $request->title_bn;

                $dynamicpage->sub_title_en = $request->sub_title_en;
                $dynamicpage->sub_title_bn = $request->sub_title_bn;

                $dynamicpage->text_en = $request->text_en;
                $dynamicpage->text_bn = $request->text_bn;

                $dynamicpage->created_at = now();
                $dynamicpage->updated_at = null;
                $dynamicpage->image = $newImageName;

                $dynamicpage->created_by_id = Auth::user()->id;


                $dynamicpage->save();

                if( $request->file("image")){
                    $request->image->move(public_path($this->stroageLink), $newImageName);
                }
            DB::commit();

            $status["status"] = "status";
            $status["message"] = "Successfully update";
        }
        catch (Exception $ex) {
            DB::rollback();

            $status["status"] = "errors";
            $status["message"] = "Fail to update.".$ex->getMessage();
        }

        return redirect()->route("dynamic.page.index")->with([$status["status"] => $status["message"]]);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:255|unique:dynamic_pages,name,'.$id,

                'title_en' => 'nullable',
                'title_bn' => 'nullable',

                'text_en' => 'nullable',
                'text_bn' => 'nullable',

                'image' => 'nullable',
            ],
            [
                'name_en.required' => 'Name (EN) is required.',
                'has_section.in' => 'Must be one out of [Yes,No].',

                'section_name_en.required_if' => 'This field is required.',
                'section_name_bn.required_if' => 'This field is required.',

                'section_text_en.required_if' => 'This field is required.',
                'section_text_bn.required_if' => 'This field is required.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $status = array(
            "status" => "errors",
            "message" => "error",
        );

        $dynamicPageCount = DynamicPage::where("template",$request->template)->where("id",'!=',$id)->count();

        if($dynamicPageCount == 0 ){
            try {
                $newImageName = null;
                $oldImageName = DynamicPage::where("id",$id)->firstOrFail()->image;

                $newImageName = $oldImageName;

                if( $request->file("image") ){
                    $newImageName = SystemConstant::generateFileName("image",$request->file("image")->getClientOriginalExtension(),200);
                }

                DB::beginTransaction();
                    $dynamicpage = DynamicPage::where('id',$id)->firstOrFail();

                    $dynamicpage->name = $request->name;
                    $dynamicpage->template = $request->template;
                    $dynamicpage->slug = Str::slug($request->name);

                    $dynamicpage->title_en = $request->title_en;
                    $dynamicpage->title_bn = $request->title_bn;

                    $dynamicpage->sub_title_en = $request->sub_title_en;
                    $dynamicpage->sub_title_bn = $request->sub_title_bn;

                    $dynamicpage->text_en = $request->text_en;
                    $dynamicpage->text_bn = $request->text_bn;

                    $dynamicpage->image = $newImageName;
                    $dynamicpage->updated_at = now();

                    $dynamicpage->update();

                    if( $request->hasFile('image') &&  !($newImageName == null)){
                        if(file_exists(public_path($this->stroageLink.$oldImageName))){
                            unlink(public_path($this->stroageLink.$oldImageName));
                        }
                        $request->image->move(public_path($this->stroageLink), $newImageName);
                    }
                DB::commit();

                $status["status"] = "status";
                $status["message"] = "Successfully update";
            }
            catch (Exception $ex) {
                DB::rollback();

                $status["status"] = "errors";
                $status["message"] = "Fail to update.".$ex->getMessage();
            }
        }
        else{
            $status["message"] = "Page for selected template already exit.";
        }

        return redirect()->route("dynamic.page.index")->with([$status["status"] => $status["message"]]);
    }

    public function delete($id){
        $status = array(
            "status" => "errors",
            "message" => "error",
        );

        $oldImageName = DynamicPage::where("id",$id)->firstOrFail()->image;

        try{
            DB::beginTransaction();
            $dynamicPage = DynamicPage::where("id",$id)->firstOrFail();
            if($dynamicPage->section->count()>0){
                foreach($dynamicPage->section as $perSection){
                    $perSection->delete();
                }
            }
            $dynamicPage->delete();
            DB::commit();
            $status["status"] = "status";
            $status["message"] = "Successfully delete.";

            if(file_exists(public_path($this->stroageLink.$oldImageName))){
                unlink(public_path($this->stroageLink.$oldImageName));
            }
        }
        catch (Exception $ex) {
            DB::rollback();

            $status["status"] = "errors";
            $status["message"] = "Fail to delete.".$ex->getMessage();
        }
        return redirect()->route("dynamic.page.index")->with([$status["status"] => $status["message"]]);
    }

    public function sectionIndex($id)
    {
        $dynamicPage = DynamicPage::where("id",$id)->firstOrFail();
        $dynamicPageSections = DynamicPageSection::orderBy("id","desc")->where('dynamic_page_id',$id);

        $dynamicPageSections = $dynamicPageSections->paginate(100);
        return view('dynamic page.section.index',compact('dynamicPage','dynamicPageSections'));
    }

    public function sectionAdd($id)
    {
        $moduleList = array();
        $dynamicPage = DynamicPage::where("id",$id)->firstOrFail();
        // $moduleList = array(
        //     "Event" => "Event",
        //     "AshramAndMondir" => "Ashram & Mondir",
        //     "ImageGallary" => "Image Gallary",
        //     "VideoGallary" => "Video Gallary",
        //     "MedicalService" => "Medical service",
        //     "HonorableAdvisoryCouncil" => "Honorable advisory council",
        //     "HonorableExecutiveCouncil" => "Honorable executive council",
        //     "AttendantAssociationCouncil" => "Attendant association council",
        //     "VariousBranchesForBoardOfDirectors" => "Various branches (Board Of Directors)",
        // );
        if($dynamicPage->template == "GoverningCouncil"){
            $moduleList["AttendantAssociationCouncil"] = "Attendant association council" ;
            $moduleList["HonorableAdvisoryCouncil"] = "Honorable executive council" ;
        }

        if($dynamicPage->template == "Event"){
            $moduleList["Event"] = "Event" ;
        }
        if($dynamicPage->template == "Service"){
            $moduleList["MedicalService"] = "Medical service" ;
        }

        if($dynamicPage->template == "AshramAndMondir"){
            $moduleList["AshramAndMondir"] = "Ashram & Mondir" ;
        }

        if($dynamicPage->template == "VariousBranchesForBoardOfDirectors"){
            $moduleList["VariousBranchesForBoardOfDirectors"] = "Various branches (Board Of Directors)";
        }

        if($dynamicPage->template == "BoardOfDirectorsOfVariousBranches"){
            $moduleList["HonorableExecutiveCouncil"] = "Honorable executive council" ;
            $moduleList["HonorableAdvisoryCouncil"] = "Honorable executive council" ;
        }

        return view('dynamic page.section.create',compact('dynamicPage','moduleList'));
    }

    public function sectionEdit($id,$sid)
    {
        // $moduleList = array(
        //     "Event" => "Event",
        //     "AshramAndMondir" => "Ashram & Mondir",
        //     "ImageGallary" => "Image Gallary",
        //     "VideoGallary" => "Video Gallary",
        //     "MedicalService" => "Medical service",
        //     "HonorableAdvisoryCouncil" => "Honorable advisory council",
        //     "HonorableExecutiveCouncil" => "Honorable executive council",
        //     "AttendantAssociationCouncil" => "Attendant association council",
        //     "VariousBranchesForBoardOfDirectors" => "Various branches (Board Of Directors)",
        // );
        $moduleList = array();

        $dynamicPage = DynamicPage::where("id",$id)->firstOrFail();
        $dynamicPageSection = DynamicPageSection::where("id",$sid)->firstOrFail();

        if($dynamicPage->template == "GoverningCouncil"){
            $moduleList["AttendantAssociationCouncil"] = "Attendant association council" ;
            $moduleList["HonorableAdvisoryCouncil"] = "Honorable executive council" ;
        }

        if($dynamicPage->template == "Event"){
            $moduleList["Event"] = "Event" ;
        }
        if($dynamicPage->template == "Service"){
            $moduleList["MedicalService"] = "Medical service" ;
        }

        if($dynamicPage->template == "AshramAndMondir"){
            $moduleList["AshramAndMondir"] = "Ashram & Mondir" ;
        }

        if($dynamicPage->template == "VariousBranchesForBoardOfDirectors"){
            $moduleList["VariousBranchesForBoardOfDirectors"] = "Various branches (Board Of Directors)";
        }

        if($dynamicPage->template == "BoardOfDirectorsOfVariousBranches"){
            $moduleList["HonorableExecutiveCouncil"] = "Honorable executive council" ;
            $moduleList["HonorableAdvisoryCouncil"] = "Honorable advisory council" ;
        }

        return view('dynamic page.section.edit', compact('dynamicPage','dynamicPageSection','moduleList'));
    }

    public function sectionSave(Request $request,$id)
    {
        $validator = Validator::make($request->all(),
            [
                'name_en' => 'required',
                'name_bn' => 'required',

                'text_en' => 'nullable|required_if:type,Text',
                'text_bn' => 'nullable|required_if:type,Text',

                'type' => 'required|in:Text,Module',
                'module'=> 'nullable|required_if:type,Module',

                'image' => 'nullable',
            ],
            [
                'name.required' => 'Name (EN) is required.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $status = array(
            "status" => "errors",
            "message" => "error",
        );

        try {
            $dublicateSectionCount = 0;
            if( ($request->type == "Module") && !($request->module == null)){
                $dublicateSectionCount = DynamicPageSection::where("dynamic_page_id",$id)->where("module",$request->module)->count();
            }

            if($dublicateSectionCount == 0){
                $newImageName = null;

                if( $request->file("image") ){
                    $newImageName = SystemConstant::generateFileName("image",$request->file("image")->getClientOriginalExtension(),200);
                }

                DB::beginTransaction();
                    $dynamicpageS = new DynamicPageSection();

                    $dynamicpageS->name_en = $request->name_en;
                    $dynamicpageS->name_bn = $request->name_bn;
                    $dynamicpageS->module = $request->module;
                    $dynamicpageS->type = $request->type;

                    $dynamicpageS->dynamic_page_id = $id;

                    $dynamicpageS->text_en = $request->text_en;
                    $dynamicpageS->text_bn = $request->text_bn;

                    $dynamicpageS->created_at = now();
                    $dynamicpageS->updated_at = null;
                    $dynamicpageS->image = $newImageName;

                    $dynamicpageS->created_by_id = Auth::user()->id;

                    $dynamicpageS->save();

                    if( $request->file("image")){
                        //$request->image->move(public_path($this->stroageLink), $newImageName);

                        $image = $request->file('image');

                        $destinationPath = public_path($this->stroageLink);
                        $imgFile = Image::make($image->path());
                        $imgFile->fit(510, 582, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($destinationPath.'/'.$newImageName);
                    }
                DB::commit();

                $status["status"] = "status";
                $status["message"] = "Successfully save";
            }
            else{
                $status["status"] = "errors";
                $status["message"] = "Section already exit. Duplicate sections.";
            }
        }
        catch (Exception $ex) {
            DB::rollback();

            $status["status"] = "errors";
            $status["message"] = "Fail to update.".$ex->getMessage();
        }

        return redirect()->route("dynamic.page.section.index",["id"=>$id])->with([$status["status"] => $status["message"]]);
    }

    public function sectionUpdate(Request $request,$id,$sid)
    {
        $validator = Validator::make($request->all(),
            [
                'name_en' => 'required',
                'name_bn' => 'required',

                'text_en' => 'nullable|required_if:type,Text',
                'text_bn' => 'nullable|required_if:type,Text',

                'type' => 'required|in:Text,Module',
                'module'=> 'nullable|required_if:type,Module',
            ],
            [
                'name.required' => 'Name (EN) is required.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $status = array(
            "status" => "errors",
            "message" => "error",
        );

        try {
            $dublicateSectionCount = 0;
            if( ($request->type == "Module") && !($request->module == null)){
                $dublicateSectionCount = DynamicPageSection::where("dynamic_page_id",$id)->where("module",$request->module)->where('id','!=',$sid)->count();
            }

            if($dublicateSectionCount == 0){
                $newImageName = null;
                $oldImageName = DynamicPageSection::where("id",$sid)->firstOrFail()->image;

                $newImageName = $oldImageName;

                if( $request->file("image") ){
                    $newImageName = SystemConstant::generateFileName("image",$request->file("image")->getClientOriginalExtension(),200);
                }

                DB::beginTransaction();
                    $dynamicpageS = DynamicPageSection::where('id',$sid)->firstOrFail();

                    $dynamicpageS->name_en = $request->name_en;
                    $dynamicpageS->name_bn = $request->name_bn;
                    $dynamicpageS->module = $request->module;
                    $dynamicpageS->type = $request->type;

                    $dynamicpageS->dynamic_page_id = $id;

                    $dynamicpageS->text_en = $request->text_en;
                    $dynamicpageS->text_bn = $request->text_bn;

                    $dynamicpageS->image = $newImageName;
                    $dynamicpageS->updated_at = now();

                    $dynamicpageS->update();

                    if( $request->hasFile('image') &&  !($newImageName == null)){
                        if(!($oldImageName == null)){
                            if(file_exists(public_path($this->stroageLink.$oldImageName))){
                                unlink(public_path($this->stroageLink.$oldImageName));
                            }
                        }
                        //$request->image->move(public_path($this->stroageLink), $newImageName);

                        $image = $request->file('image');

                        $destinationPath = public_path($this->stroageLink);
                        $imgFile = Image::make($image->path());
                        $imgFile->fit(510, 582, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($destinationPath.'/'.$newImageName);
                    }
                DB::commit();

                $status["status"] = "status";
                $status["message"] = "Successfully update";
            }
            else{
                $status["status"] = "errors";
                $status["message"] = "Section already exit. Duplicate sections.";
            }
        }
        catch (Exception $ex) {
            DB::rollback();

            $status["status"] = "errors";
            $status["message"] = "Fail to update.".$ex->getMessage();
        }

        return redirect()->route("dynamic.page.section.index",["id"=>$id])->with([$status["status"] => $status["message"]]);
    }

    public function sectionDelete($id,$sid){
        $status = array(
            "status" => "errors",
            "message" => "error",
        );

        $oldImageName = DynamicPageSection::where("id",$sid)->firstOrFail()->image;

        try{
            DB::beginTransaction();
            $dps = DynamicPageSection::where("id",$sid)->firstOrFail();
            $dps->delete();
            DB::commit();
            $status["status"] = "status";
            $status["message"] = "Successfully delete.";

            if(!($oldImageName == null)){
                if(file_exists(public_path($this->stroageLink.$oldImageName))){
                    unlink(public_path($this->stroageLink.$oldImageName));
                }
            }
        }
        catch (Exception $ex) {
            DB::rollback();

            $status["status"] = "errors";
            $status["message"] = "Fail to delete.".$ex->getMessage();
        }
        return redirect()->route("dynamic.page.section.index",["id"=>$id])->with([$status["status"] => $status["message"]]);
    }
}
