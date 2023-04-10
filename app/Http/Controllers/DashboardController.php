<?php

namespace App\Http\Controllers;

use Image;
use Exception;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Utilities\SystemConstant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    private $stroageLink = "images/setting/app/";

    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware(['auth.user.role.check:Admin']);
    }

    public function index()
    {
        $appSetting = SystemConstant::settingsCollectToArray(Setting::get());
        return view('dashboard.index',compact("appSetting"));
    }

    public function edit($settingType)
    {
        $appSetting = SystemConstant::settingsCollectToArray(Setting::get());
        return view('dashboard.edit',compact("appSetting",'settingType'));
    }


    public function update(Request $request,$settingType){
        $validator = Validator::make($request->all(),
            [
                'site_name_en' => 'nullable|string|max:15',
                'site_name_bn' => 'nullable|string',
                'logo' => 'nullable|file|mimes:jpg,jpeg,png',
                'favicon' => 'nullable|file|mimes:jpg,jpeg,png,ico|dimensions:width=16,height=16',

                'topbar_title_en' => 'nullable',
                'topbar_title_bn' => 'nullable',

                'topbar_founder_en' => 'nullable',
                'topbar_founder_bn' => 'nullable',

                'footer_youtube_link' => 'nullable',
                'footer_fb_link' => 'nullable',

                'footer_twitter_link' => 'nullable',
                'footer_linkedin_link' => 'nullable',
            ],
            [
                'site_name_en.required' => 'Site name (EN) is required.',
                'site_name_en.string' => 'Site name (EN must be a string.',
                'site_name_en.max' => 'Site name (EN) length can not greater then 15 chars.',

                'site_name_bn.required' => 'Site name (BN) is required.',
                'site_name_bn.string' => 'Site name (BN) must be a string.',

                'logo.file' => 'Logo must be file.',
                'logo.mimes' => 'Logo must be image(jpg,jpeg,png)',

                'favicon.file' => 'Favicon must be file.',
                'favicon.mimes' => 'Favicon must be image(jpg,jpeg,png)',

                'topbar_title_bn.required' => 'Topbar sub title (BN) is required.',
                'topbar_title_en.required' => 'Topbar sub title (EN) is required.',

                'footer_fb_link.required' => 'Footer fb is required.',
                'footer_youtube_link.required' => 'Footer instagram is required.',

                'footer_linkedin_link.required' => 'Footer linkedin is required.',
                'footer_twitter_link.required' => 'Footer twitter is required.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateStatus = array(
            "status" => "errors",
            "message" => "errors",
        );

        try {

            DB::beginTransaction();

            $settings = Setting::get();
            foreach ($settings as $setting) {

                if($settingType == "Site"){
                    if( $setting->field == "site_name_en" ){
                        $this->updateSetting("App","site_name_en",$request->site_name_en);
                    }

                    if( $setting->field == "site_name_bn" ){
                        $this->updateSetting("App","site_name_bn",$request->site_name_bn);
                    }

                    if( ($setting->field == "logo") && $request->hasFile('logo') ){
                        $oldLogoName = $setting->value ;

                        $newLogoName = SystemConstant::generateFileName("current logo",$request->file("logo")->getClientOriginalExtension(),200);

                        $updateLogo = $this->updateSetting("App","logo",$newLogoName);

                        if($updateLogo == true){
                            if(!($oldLogoName == null) && !($oldLogoName == "default-logo.png")){

                                if( $request->hasFile('logo') &&  !($newLogoName == null)){
                                    if(file_exists(public_path($this->stroageLink.$oldLogoName))){
                                        unlink(public_path($this->stroageLink.$oldLogoName));
                                    }
                                }
                            }

                            $logoR = $request->logo;

                            $destinationLogoPathR = public_path($this->stroageLink);
                            $logoFileR = Image::make($logoR->path());
                            $logoFileR->fit(98, 118, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($destinationLogoPathR.'/'.$newLogoName);

                            //$request->logo->move(public_path($this->stroageLink), $newLogoName);
                        }

                    }

                    if( ($setting->field == "manubar_logo") && $request->hasFile('manubar_logo') ){
                        $oldManubarLogoName = $setting->value ;

                        $newMenubarLogoName = SystemConstant::generateFileName("current manubar logo",$request->file("manubar_logo")->getClientOriginalExtension(),200);

                        $updateMenubarLogo = $this->updateSetting("App","manubar_logo",$newMenubarLogoName);

                        if($updateMenubarLogo == true){
                            if(!($oldManubarLogoName == null) && !($oldManubarLogoName == "default-manubar-logo.png")){

                                if( $request->hasFile('manubar_logo') &&  !($newMenubarLogoName == null)){
                                    if(file_exists(public_path($this->stroageLink.$oldManubarLogoName))){
                                        unlink(public_path($this->stroageLink.$oldManubarLogoName));
                                    }
                                }
                            }
                            $manubarLogo = $request->manubar_logo;

                            $destinationManubarLogoPath = public_path($this->stroageLink);
                            $manubarLogoFileR = Image::make( $manubarLogo->path());
                            $manubarLogoFileR->fit(118, 134, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($destinationManubarLogoPath.'/'.$newMenubarLogoName);
                            //$request->manubar_logo->move(public_path($this->stroageLink), $newMenubarLogoName);
                        }

                    }

                    if( ($setting->field == "favicon") && $request->hasFile('favicon') ){
                        $oldFaviconName = $setting->value ;

                        $newFaviconName = SystemConstant::generateFileName("current favicon",$request->file("favicon")->getClientOriginalExtension(),200);

                        $updateFavicon = $this->updateSetting("App","favicon",$newFaviconName);

                        if($updateFavicon == true){
                            if(!($oldFaviconName == null) && !($oldFaviconName == "default-favicon.png")){

                                if( $request->hasFile('favicon') &&  !($newFaviconName == null)){
                                    if(file_exists(public_path($this->stroageLink.$oldFaviconName))){
                                        unlink(public_path($this->stroageLink.$oldFaviconName));
                                    }
                                }
                            }
                            $favicon = $request->favicon;

                            $destinationFaviconPath = public_path($this->stroageLink);
                            $faviconLogoFileR = Image::make( $favicon->path());
                            $faviconLogoFileR->fit(16, 16, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($destinationFaviconPath.'/'.$newFaviconName);
                            //$request->favicon->move(public_path($this->stroageLink), $newFaviconName);
                        }

                    }
                }

                if($settingType == "Footer"){
                    if( $setting->field == "footer_youtube_link" ){
                        $this->updateSetting("App","footer_youtube_link",$request->footer_youtube_link);
                    }

                    if( $setting->field == "footer_fb_link" ){
                        $this->updateSetting("App","footer_fb_link",$request->footer_fb_link);
                    }

                    if( $setting->field == "footer_twitter_link" ){
                        $this->updateSetting("App","footer_twitter_link",$request->footer_twitter_link);
                    }

                    if( $setting->field == "footer_linkedin_link" ){
                        $this->updateSetting("App","footer_linkedin_link",$request->footer_linkedin_link);
                    }

                    if( $setting->field == "footer_en" ){
                        $this->updateSetting("App","footer_en",$request->footer_en);
                    }

                    if( $setting->field == "footer_bn" ){
                        $this->updateSetting("App","footer_bn",$request->footer_bn);
                    }
                }

                if($settingType == "Topbar"){
                    if( $setting->field == "topbar_title_en" ){
                        $this->updateSetting("App","topbar_title_en",$request->topbar_title_en);
                    }

                    if( $setting->field == "topbar_title_bn" ){
                        $this->updateSetting("App","topbar_title_bn",$request->topbar_title_bn);
                    }

                    if( $setting->field == "topbar_founder_en" ){
                        $this->updateSetting("App","topbar_founder_en",$request->topbar_founder_en);
                    }

                    if( $setting->field == "topbar_founder_bn" ){
                        $this->updateSetting("App","topbar_founder_bn",$request->topbar_founder_bn);
                    }
                }

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

        return redirect()->route("dashboard.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }

    private function updateSetting($settingType,$field,$value){
        $updateStatus = false;

        $setting = Setting::where("type",$settingType)->where("field",$field)->firstOrFail();
        $setting->value = $value;
        $setting->updated_at = now();
        $settingUpdate = $setting->update();
        if($settingUpdate){
            $updateStatus = true;
        }

        return $updateStatus;
    }
}
