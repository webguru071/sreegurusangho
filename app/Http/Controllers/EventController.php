<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Utilities\SystemConstant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    private $stroageLink = "images/event/";

    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware(['auth.user.role.check:Admin']);
    }

    public function index()
    {
        $events = Event::orderBy("date_en","desc");

        $events = $events->paginate(15);
        return view('event.index',compact("events"));
    }

    public function add()
    {
        return view('event.add');
    }

    public function edit($id)
    {
        $event = Event::where("id",$id)->firstOrFail();
        return view('event.edit',compact("event"));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name_en' => 'required|string',
                'name_bn' => 'required|string',

                'date_en' => 'required',
                'date_bn' => 'required',

                'day_en' => 'required',
                'day_bn' => 'required',

                'details_en' => 'nullable',
                'details_bn' => 'nullable',

                'banner' => 'nullable',
            ],
            [
                'name_en.required' => 'Name (EN) is required.',

                'date_en.required' => 'Date (EN) is required.',

                'day_en.required' => 'Date (EN) is required.',

                'banner.mimes' => 'Banner must be image(jpg,jpeg,png)',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateStatus = array(
            "status" => "errors",
            "message" => "error",
        );
        $newBannerName = null;
        if( $request->file("banner") ){
            $newBannerName = SystemConstant::generateFileName("banner",$request->file("banner")->getClientOriginalExtension(),200);
        }
        try {

            DB::beginTransaction();
                $event = new Event();

                $event->name_en = $request->name_en;

                $event->name_bn = $request->name_bn;

                $event->day_bn = $request->day_bn;
                $event->day_en = $request->day_en;
                $event->date_en = $request->date_en;
                $event->date_bn = $request->date_bn;

                $event->details_en = $request->details_en;
                $event->details_bn = $request->details_bn;
                $event->created_by_id = Auth::user()->id;

                $event->banner = $newBannerName;

                $event->save();

                if( $request->file("banner")){
                    $request->banner->move(public_path($this->stroageLink), $newBannerName);
                }
            DB::commit();

            $updateStatus["status"] = "status";
            $updateStatus["status"] = "Successfully update";
        }
        catch (Exception $ex) {
            DB::rollback();

            $updateStatus["status"] = "errors";
            $updateStatus["status"] = "Fail to update.".$ex->getMessage();
        }

        return redirect()->route("event.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }


    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),
            [
                'name_en' => 'required|string',
                'name_bn' => 'required|string',

                'date_en' => 'required',
                'date_bn' => 'required',

                'day_en' => 'required',
                'day_bn' => 'required',

                'details_en' => 'nullable',
                'details_bn' => 'nullable',

                'banner' => 'nullable',
            ],
            [
                'name_en.required' => 'Name (EN) is required.',

                'date_en.required' => 'Date (EN) is required.',

                'day_en.required' => 'Date (EN) is required.',

                'banner.mimes' => 'Banner must be image(jpg,jpeg,png)',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateStatus = array(
            "status" => "errors",
            "message" => "error",
        );

        $oldBannerName = Event::where("id",$id)->firstOrFail()->banner;

        try {
            $newBannerName = $oldBannerName;

            if( ($request->hasFile('banner')) ){
                $newBannerName = SystemConstant::generateFileName("banner",$request->file("banner")->getClientOriginalExtension(),200);
            }

            DB::beginTransaction();
                $event = Event::where("id",$id)->firstOrFail();
                $event->name_en = $request->name_en;
                $event->name_bn = $request->name_bn;
                $event->day_bn = $request->day_bn;
                $event->day_en = $request->day_en;
                $event->date_bn = $request->date_bn;
                $event->date_en = $request->date_en;

                $event->details_en = $request->details_en;
                $event->details_bn = $request->details_bn;
                $event->banner = $newBannerName;
                $event->update();

                if( $request->hasFile('banner') &&  !($newBannerName == null)){
                    if(file_exists(public_path($this->stroageLink.$oldBannerName))){
                        unlink(public_path($this->stroageLink.$oldBannerName));
                    }
                    $request->banner->move(public_path($this->stroageLink), $newBannerName);
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

        return redirect()->route("event.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }

    public function delete($id){
        $updateStatus = array(
            "status" => "errors",
            "message" => array(),
        );

        $oldBannerName = Event::where("id",$id)->firstOrFail()->banner;

        try{
            DB::beginTransaction();
            $event = Event::where("id",$id)->firstOrFail();
            $event->delete();
            DB::commit();
            $updateStatus["status"] = "status";
            $updateStatus["message"] = "Successfully delete.";

            if(file_exists(public_path($this->stroageLink.$oldBannerName))){
                unlink(public_path($this->stroageLink.$oldBannerName));
            }
        }
        catch (Exception $ex) {
            DB::rollback();

            $updateStatus["status"] = "errors";
            $updateStatus["message"] = "Fail to delete.".$ex->getMessage();
        }
        return redirect()->route("event.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }
}
