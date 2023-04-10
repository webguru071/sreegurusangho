<?php

namespace App\Http\Controllers;

use Image;
use Exception;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Utilities\SystemConstant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    private $stroageLink = "images/gallery/";

    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware(['auth.user.role.check:Admin']);
    }

    public function index()
    {
        $galleries = Gallery::orderBy("created_at","desc");
        $galleries = $galleries->paginate(50);
        return view('gallery.index',compact("galleries"));
    }

    public function add()
    {
        return view('gallery.add');
    }

    public function edit($id)
    {
        $gallery = Gallery::where("id",$id)->firstOrFail();
        return view('gallery.edit',compact('gallery'));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'title_en' => 'required|string',
            'title_bn' => 'required|string',

            'type' => 'required|in:Image,Video',
            'video_url' => 'nullable|required_if:type,Video',
            'image' => 'nullable|required_if:type,Image',
        ],
        [
            'title_en.required' => 'Title (EN) is required.',

            'title_bn.required' => 'Title (BN) is required.',

            'type.in' => 'Type must be one out of (Image,Video).',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $saveStatus = array(
            "status" => "errors",
            "message" => "error",
        );

        DB::beginTransaction();
        try {
            $videoUrl = null;
            $newImageName = null;

            if($request->file('image')){
                $newImageName = SystemConstant::generateFileName("image",$request->image->getClientOriginalExtension(),200);
            }

            if($request->has('video_url')){
                $videoUrl = $request->video_url;
            }

            $gallary = new Gallery();
            $gallary->title_en = $request->title_en;
            $gallary->title_bn = $request->title_bn;
            $gallary->type = $request->type;
            $gallary->image = $newImageName;
            $gallary->video_url = $videoUrl;
            $gallary->created_by_id = Auth::user()->id;
            $gallary->save();

            if($request->file('image')){
                $image = $request->file('image');

                $destinationPath = public_path($this->stroageLink);
                $imgFile = Image::make($image->path());
                $imgFile->fit(375, 340, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$newImageName);
                //$destinationPath =  public_path($this->stroageLink);
                //$image->move($destinationPath, $newImageName);
                //$request->image->move(public_path($this->stroageLink), $newImageName);
            }

            DB::commit();

            $saveStatus["status"] = "status";
            $saveStatus["message"] = "Successfully saved";
        }
        catch (Exception $ex) {
            DB::rollback();

            $saveStatus["status"] = "errors";
            $saveStatus["message"] = "Fail to create.".$ex->getMessage();
        }

        return redirect()->route("gallery.index")->with([$saveStatus["status"] => $saveStatus["message"]]);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),
        [
            'title_en' => 'required|string',
            'title_bn' => 'required|string',

            'type' => 'required|in:Image,Video',
            'video_url' => 'nullable|required_if:type,Video',
            'image' => 'nullable|required_if:type,Image',
        ],
        [
            'title_en.required' => 'Title (EN) is required.',

            'title_bn.required' => 'Title (BN) is required.',

            'type.in' => 'Type must be one out of (Image,Video).',
        ]);

        $saveStatus = array(
            "status" => "errors",
            "message" => "error",
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {

            $videoUrl = null;
            $newImageName = null;

            $oldImageName = Gallery::where("id",$id)->firstOrFail()->image;
            $newImageName =  $oldImageName;

            if(($request->type == "Image") && $request->file('image')){
                $newImageName = SystemConstant::generateFileName("image",$request->image->getClientOriginalExtension(),200);
            }

            if(($request->type == "Video") && ($request->has('video_url'))){
                $videoUrl = $request->video_url;
            }

            $gallary = Gallery::where("id",$id)->firstOrFail();
            $gallary->title_en = $request->title_en;
            $gallary->title_bn = $request->title_bn;

            $gallary->type = $request->type;
            $gallary->image = $newImageName;
            $gallary->video_url = $videoUrl;
            $gallary->created_by_id = Auth::user()->id;
            $gallary->update();

            if(($request->type == "Image") && $request->file('image')){
                if( ($request->type == "Image") && !($oldImageName == null) ){
                    if(file_exists(public_path($this->stroageLink.$oldImageName))){
                        unlink(public_path($this->stroageLink.$oldImageName));
                    }
                }
                $image = $request->file('image');

                $destinationPath = public_path($this->stroageLink);
                $imgFile = Image::make($image->getRealPath());
                $imgFile->fit(375, 340, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$newImageName);
                // $destinationPath =  public_path($this->stroageLink);
                // $image->move($destinationPath, $newImageName);
                //$request->image->move(public_path($this->stroageLink), $newImageName);
            }

            DB::commit();

            $saveStatus["status"] = "status";
            $saveStatus["message"] = "Successfully updated.";
        }
        catch (Exception $ex) {
            DB::rollback();

            $saveStatus["status"] = "errors";
            $saveStatus["message"] = "Fail to update.".$ex->getMessage();
        }

        return redirect()->route("gallery.index")->with([$saveStatus["status"] => $saveStatus["message"]]);
    }

    public function delete($id){
        $updateStatus = array(
            "status" => "errors",
            "message" => array(),
        );



        try{
            DB::beginTransaction();


            $gallery = Gallery::where("id",$id)->firstOrFail();
            $oldImageName = Gallery::where("id",$id)->firstOrFail()->image;

            if( ($gallery->type == "Image") && !($oldImageName == null) ){
                if(file_exists(public_path($this->stroageLink.$oldImageName))){
                    unlink(public_path($this->stroageLink.$oldImageName));
                }
            }
            $gallery->delete();
            DB::commit();
            $updateStatus["status"] = "status";
            $updateStatus["message"] = "Successfully delete.";
        }
        catch (Exception $ex) {
            DB::rollback();

            $updateStatus["status"] = "errors";
            $updateStatus["message"] = "Fail to delete.".$ex->getMessage();
        }
        return redirect()->route("gallery.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }
}
