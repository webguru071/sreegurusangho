<?php

namespace App\Http\Controllers;

use Image;
use Exception;
use App\Models\HomeSlider;
use Illuminate\Http\Request;
use App\Utilities\SystemConstant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeSliderController extends Controller
{
    private $stroageLink = "images/home-slider/";

    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware(['auth.user.role.check:Admin']);
    }

    public function index()
    {
        $homeSliders = HomeSlider::orderBy("created_at","desc");

        $homeSliders = $homeSliders->paginate(50);
        return view('home slider.index',compact("homeSliders"));
    }

    public function add()
    {
        return view('home slider.add');
    }

    public function edit($id)
    {
        $homeSlider = HomeSlider::where("id",$id)->firstOrFail();
        return view('home slider.edit',compact("homeSlider"));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'alt_text' => 'required|string',
                'image' => 'nullable',
            ],
            [
                'alt_text.required' => 'Alt_text is required.',

                'image.mimes' => 'Image must be image(jpg,jpeg,png)',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $saveStatus = array(
            "status" => "errors",
            "message" => "error",
        );
        $newImageName = null;
        if( $request->file("image") ){
            $newImageName = SystemConstant::generateFileName("image",$request->file("image")->getClientOriginalExtension(),200);
        }

        try {

            DB::beginTransaction();
                $homeslider = new HomeSlider();

                $homeslider->alt_text= $request->alt_text;
                $homeslider->created_by_id = Auth::user()->id;

                $homeslider->image = $newImageName;

                $homeslider->save();

                if( $request->file("image")){
                    //$request->image->move(public_path($this->stroageLink), $newImageName);
                    $image = $request->file('image');
                    $destinationPath = public_path($this->stroageLink);
                    $imgFile = Image::make($image->path());
                    $imgFile->fit(1200, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.'/'.$newImageName);
                }
            DB::commit();

            $saveStatus["status"] = "status";
            $saveStatus["message"] = "Successfully save.";
        }
        catch (Exception $ex) {
            DB::rollback();

            $saveStatus["status"] = "errors";
            $saveStatus["status"] = "Fail to save.".$ex->getMessage();
        }

        return redirect()->route("home.slider.index")->with([$saveStatus["status"] => $saveStatus["message"]]);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),
            [
                'alt_text' => 'required|string|max:200',
                'image' => 'nullable',
            ],
            [
                'alt_text.required' => 'Alt_text is required.',

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

        $oldImageName= HomeSlider::where("id",$id)->firstOrFail()->image;

        try {
            $newImageName= $oldImageName;

            if( ($request->hasFile('image')) ){
                $newImageName= SystemConstant::generateFileName("image",$request->file("image")->getClientOriginalExtension(),200);
            }

            DB::beginTransaction();
                $homeSlider = HomeSlider::where("id",$id)->firstOrFail();
                $homeSlider->alt_text= $request->alt_text;

                $homeSlider->image = $newImageName;
                $homeSlider->update();

                if( $request->hasFile('image') &&  !($newImageName== null)){
                    if(file_exists(public_path($this->stroageLink.$oldImageName))){
                        unlink(public_path($this->stroageLink.$oldImageName));
                    }
                    //$request->image->move(public_path($this->stroageLink), $newImageName);
                    $image = $request->file('image');
                    $destinationPath = public_path($this->stroageLink);
                    $imgFile = Image::make($image->path());
                    $imgFile->fit(1200, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.'/'.$newImageName);
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

        return redirect()->route("home.slider.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }

    public function delete($id){
        $updateStatus = array(
            "status" => "errors",
            "message" => array(),
        );

        $oldImageName = HomeSlider::where("id",$id)->firstOrFail()->image;

        try{
            DB::beginTransaction();
            $homeSlider = HomeSlider::where("id",$id)->firstOrFail();
            $homeSlider->delete();
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
        return redirect()->route("home.slider.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }
}
