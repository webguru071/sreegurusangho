<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SiteMenu;
use App\Models\DynamicPage;
use Illuminate\Http\Request;
use App\Utilities\SystemConstant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class SiteMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware(['auth.user.role.check:Admin']);
    }

    public function index()
    {
        $siteMenus = SiteMenu::orderBy("created_at","desc");

        $siteMenus = $siteMenus->paginate(50);
        return view('site menu.index',compact("siteMenus"));
    }

    public function add()
    {
        $dynamicPages = DynamicPage::orderBy("created_at","desc")->get();
        $siteMenus = SiteMenu::orderBy("created_at","desc")->where("parent_id",null)->get();
        return view('site menu.add',compact("siteMenus","dynamicPages"));
    }

    public function edit($id)
    {
        $siteMenu = SiteMenu::where("id",$id)->firstOrFail();
        $dynamicPages = DynamicPage::orderBy("created_at","desc")->get();
        $siteMenus = SiteMenu::orderBy("created_at","desc")->where("parent_id",null)->get();

        return view('site menu.edit',compact("siteMenu","siteMenus","dynamicPages"));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name_en' => 'required|string',
                'name_bn' => 'required|string',

                'page_id' => 'nullable',
                'parent_id' => 'nullable',
            ],
            [
                'name_en.required' => 'Name (EN) is required.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateStatus = array(
            "status" => "errors",
            "message" => "error",
        );
        try {

            DB::beginTransaction();
                $sitemenu = new SiteMenu();

                $sitemenu->name_en = $request->name_en;

                $sitemenu->name_bn = $request->name_bn;

                $sitemenu->page_id = $request->page_id;
                $sitemenu->parent_id = $request->parent_id;
                $sitemenu->created_by_id = Auth::user()->id;

                $sitemenu->save();
            DB::commit();

            $updateStatus["status"] = "status";
            $updateStatus["message"] = "Successfully save";
        }
        catch (Exception $ex) {
            DB::rollback();

            $updateStatus["status"] = "errors";
            $updateStatus["message"] = "Fail to update.".$ex->getMessage();
        }

        return redirect()->route("site.menu.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),
            [
                'name_en' => 'required|string',
                'name_bn' => 'required|string',

                'page_id' => 'nullable',
                'parent_id' => 'nullable',
            ],
            [
                'name_en.required' => 'Name (EN) is required.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateStatus = array(
            "status" => "errors",
            "message" => "error",
        );
        try {

            DB::beginTransaction();
                $sitemenu = SiteMenu::where("id",$id)->firstOrFail();

                $sitemenu->name_en = $request->name_en;

                $sitemenu->name_bn = $request->name_bn;

                $sitemenu->page_id = $request->page_id;
                $sitemenu->parent_id = $request->parent_id;

                $sitemenu->update();
            DB::commit();

            $updateStatus["status"] = "status";
            $updateStatus["message"] = "Successfully update";
        }
        catch (Exception $ex) {
            DB::rollback();

            $updateStatus["status"] = "errors";
            $updateStatus["message"] = "Fail to update.".$ex->getMessage();
        }

        return redirect()->route("site.menu.index")->with([$updateStatus["status"] => $updateStatus["message"]]);
    }

    public function delete($id){
        $statusInformation = array("status" => "errors","message" =>"error");

        DB::beginTransaction();
        try {
            $siteMenu = SiteMenu::where("id",$id)->firstOrFail();
            $siteMenuTreeIds =  $siteMenu->siteMenus()->pluck("id")->toArray();
            if((count($siteMenuTreeIds) == 0)){
                $siteMenu->delete();

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

        return redirect()->route("site.menu.index")->with([$statusInformation["status"] => $statusInformation["message"]]);
    }

}
