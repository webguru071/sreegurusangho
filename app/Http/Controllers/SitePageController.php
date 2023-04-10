<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Event;
use App\Models\Setting;
use App\Models\Gallery;
use App\Models\CountryArea;
use App\Mail\ConactUsMail;
use App\Models\HomeSlider;
use App\Models\StaffMember;
use App\Models\DynamicPage;
use App\Models\CouncilMember;
use Illuminate\Http\Request;
use App\Models\MondirAndAshram;
use App\Utilities\SystemConstant;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;

class SitePageController extends Controller
{
    public function homePage(){
        $pageInfo = DynamicPage::where("template","Home")->firstOrFail();
        $homeSliders = HomeSlider::orderBy("id","asc")->get();

        $todayEvents = Event::orderBy("id","desc")->whereDate('date_en',now())->get();
        $pastEvents = Event::orderBy("date_en","desc")->whereDate('date_en','<',now())->get();
        $upcomingEvents = Event::orderBy("date_en","desc")->whereDate('date_en','>',now())->get();

        $homePageSections = $pageInfo->sections;
        $galleryImageItems = Gallery::where("type","Image")->take(6)->get();

        return view('site page.dynamic page.home page.index',compact("homeSliders","todayEvents","pastEvents","upcomingEvents","homePageSections","galleryImageItems"));
    }

    public function dynamicPage($slug){
        $pageInfo = DynamicPage::where("slug",$slug)->firstOrFail();
        $settings = SystemConstant::settingsCollectToArray(Setting::orderBy("id","desc")->get());

        if($pageInfo->template == "Home"){
            $homeSliders = HomeSlider::orderBy("id","asc")->get();

            $todayEvents = Event::orderBy("id","desc")->whereDate('date_en',now())->get();
            $pastEvents = Event::orderBy("date_en","desc")->whereDate('date_en','<',now())->get();
            $upcomingEvents = Event::orderBy("date_en","desc")->whereDate('date_en','>',now())->get();

            $homePageSections = $pageInfo->sections;
            $galleryImageItems = Gallery::where("type","Image")->take(6)->get();

            return view('site page.dynamic page.home page.index',compact("homeSliders","todayEvents","pastEvents","upcomingEvents","homePageSections","galleryImageItems"));
        }

        if($pageInfo->template == "GoverningCouncil"){
            $honorableAdvisoryCouncils = CouncilMember::orderBy("id","desc")->where("council","Honorable governing council")->where("membership_type","Honorable advisory council")->get();
            $attendantAssociationCouncils = CouncilMember::orderBy("id","desc")->where("council","Honorable governing council")->where("membership_type","Attendant association council")->get();
            return view('site page.dynamic page.council member.governing council',compact("pageInfo","honorableAdvisoryCouncils","attendantAssociationCouncils","settings"));
        }

        if($pageInfo->template == "VariousBranchesForBoardOfDirectors"){
            $countryAreas = CountryArea::where('parent_id',null)->get();

            return view('site page.dynamic page.council member.attendant council',compact("pageInfo","countryAreas","settings"));
        }

        if($pageInfo->template == "SriGuruSangha"){
            return view('site page.dynamic page.sri guru.index',compact("pageInfo","settings"));
        }

        if($pageInfo->template == "AshramAndMondir"){
            $aamList = array();
            $aamCountryAreas = CountryArea::where('parent_id',null)->get();

            foreach($aamCountryAreas as $perCA){
                $aamList[$perCA->id] = MondirAndAshram::orderBy("id","asc")->where('branch',$perCA->id)->get();
            }

            return view('site page.dynamic page.ashram and mondir.index',compact("pageInfo","settings","aamList","aamCountryAreas"));
        }

        if($pageInfo->template == "Event"){
            $events = Event::orderBy("id","desc")->get();

            return view('site page.dynamic page.event.index',compact("pageInfo","events","settings"));
        }

        if($pageInfo->template == "ImageGallary"){
            $enablePaginationIG = 1;
            $paginationIG = 20;
            $gallerySkipIG = 20;

            $totalGallaryIG = Gallery::orderBy("id","asc");
            $galleryItemsIG = Gallery::orderBy("id","asc");

            $totalGallaryIG = $totalGallaryIG->where("type","Image");
            $galleryItemsIG = $galleryItemsIG->where("type","Image");

            $totalGallaryIG = $totalGallaryIG->count();
            $galleryItemsIG =  $galleryItemsIG->take($paginationIG)->get();

            if($galleryItemsIG->count() == $totalGallaryIG){
                $enablePaginationIG = 0;
            }

            return view('site page.dynamic page.gallery.image index',compact("pageInfo","galleryItemsIG","gallerySkipIG","settings","enablePaginationIG"));
        }


        if($pageInfo->template == "VideoGallary"){
            $enablePaginationVG = 1;
            $paginationVG = 20;
            $gallerySkipVG = 20;

            $totalGallaryVG = Gallery::orderBy("id","asc");
            $galleryItemsVG = Gallery::orderBy("id","asc");

            $totalGallaryVG = $totalGallaryVG->where("type","Video");
            $galleryItemsVG = $galleryItemsVG->where("type","Video");

            $totalGallaryVG = $totalGallaryVG->count();
            $galleryItemsVG =  $galleryItemsVG->take($paginationVG)->get();

            if($galleryItemsVG->count() == $totalGallaryVG){
                $enablePaginationVG = 0;
            }

            return view('site page.dynamic page.gallery.video index',compact("pageInfo","galleryItemsVG","gallerySkipVG","settings","enablePaginationVG"));
        }

        if($pageInfo->template == "Service"){
            $medicalServiceSections = StaffMember::orderBy("id","asc")->get();
            return view('site page.dynamic page.service.index',compact("medicalServiceSections","pageInfo","settings"));
        }
        if($pageInfo->template == "Contact"){
            return view('site page.dynamic page.contact.index',compact("pageInfo","settings"));
        }
    }

    public function memberDynamicPage($template,$branch){
        $pageInfo = DynamicPage::where("template",$template)->firstOrFail();
        $settings = SystemConstant::settingsCollectToArray(Setting::orderBy("id","desc")->get());

        if($pageInfo->template == "BoardOfDirectorsOfVariousBranches"){
            $honorableAdvisoryCouncils = CouncilMember::orderBy("id","desc")->where("council","Board of director")->where("membership_type","Honorable advisory council")->where("branch",$branch)->get();
            $honorableExecutiveCouncils = CouncilMember::orderBy("id","desc")->where("council","Board of director")->where("membership_type","Honorable executive council")->where("branch",$branch)->get();

            return view('site page.dynamic page.council member.attendant council list',compact("pageInfo","honorableAdvisoryCouncils","honorableExecutiveCouncils","settings"));
        }
    }

    public function councilMemberInfoPage($id){
        $settings = SystemConstant::settingsCollectToArray(Setting::orderBy("id","desc")->get());

        $member = CouncilMember::where("id",$id)->firstOrFail();

        return view('site page.dynamic page.council member.member info',compact("member","settings"));
    }

    public function imageGalleryPage(Request $request){
        $enablePagination = 1;
        $pagination = 20;
        $gallerySkip = 20;

        $settings = SystemConstant::settingsCollectToArray(Setting::orderBy("id","desc")->get());

        $totalGallary = Gallery::orderBy("id","asc")->where("type","Image")->count();
        $galleryItems = Gallery::orderBy("id","asc")->where("type","Image");

        if(count($request->input()) > 0){
            $gallerySkip = $request->gallery_skip;
            $galleryItems =  $galleryItems->skip($gallerySkip)->take($pagination)->get();

            return array(
                "galleries" =>  $galleryItems,
                "gallery_total" => $totalGallary,
            );
        }

        $galleryItems =  $galleryItems->take($pagination)->get();

        if($galleryItems->count() == $totalGallary){
            $enablePagination = 0;
        }
        return view('site page.gallery.image index',compact("galleryItems","gallerySkip","settings","enablePagination"));
    }

    public function videoGalleryPage(Request $request){
        $enablePagination = 1;
        $pagination = 20;
        $gallerySkip = 20;

        $settings = SystemConstant::settingsCollectToArray(Setting::orderBy("id","desc")->get());

        $totalGallary = Gallery::orderBy("id","asc")->where("type","Video")->count();
        $galleryItems = Gallery::orderBy("id","asc")->where("type","Video");

        if(count($request->input()) > 0){
            $gallerySkip = $request->gallery_skip;
            $galleryItems =  $galleryItems->skip($gallerySkip)->take($pagination)->get();

            return array(
                "galleries" =>  $galleryItems,
                "gallery_total" => $totalGallary,
            );
        }

        $galleryItems =  $galleryItems->take($pagination)->get();
        if($galleryItems->count() == $totalGallary){
            $enablePagination = 0;
        }
        return view('site page.gallery.video index',compact("galleryItems","gallerySkip","settings","enablePagination"));
    }

    public function medicalServiceDetails($id){
        $settings = SystemConstant::settingsCollectToArray(Setting::orderBy("id","desc")->get());
        $staffMember = StaffMember::where('id',$id)->firstOrFail();
        return  view('site page.dynamic page.service.medical service details',compact("staffMember","settings"));
    }

    public function sendEmail(Request $request){

        $updateStatus = array(
            "status" => "errors",
            "message" => "errors",
        );

        $data = array(
            "name" => $request->first_name.' '.$request->first_last,
            "email" => $request->email,
            "subject" => $request->subject,
            "message" => $request->body,
        );

        try {
// return $request;
            Mail::to("tfarzan007@gmail.com")->send(new ConactUsMail($data));

            $updateStatus["status"] = "status";
            $updateStatus["message"] = "Successfully send.";
        } catch (Exception $ex) {
            $updateStatus["status"] = "errors";
            $updateStatus["message"] = "Fail to send.".$ex->getMessage();
        }

        return redirect()->back()->with([$updateStatus["status"] => $updateStatus["message"]]);
    }

    public function calenderGenerate(Request $request){
        $html = '';

        $monthBnList = array(
            "01" => 'পৌষ',
            "02" => 'মাঘ',
            "03" => 'ফাল্গুন',
            "04" => 'চৈত্র',
            "05" => 'বৈশাখ',
            "06" => 'জ্যৈষ্ঠ',
            "07" => 'আষাঢ়',
            "08" => 'শ্রাবণ',
            "09" => 'ভাদ্র',
            "10" => 'আশ্বিন',
            "11" => 'কার্তিক',
            "12" => 'অগ্রহায়ণ',
        );

        $monthEnList = array(
            "01" => 'Jan',
            "02" => 'Feb',
            "03" => 'Mar',
            "04" => 'Apr',
            "05" => 'May',
            "06" => 'Jun',
            "07" => 'Jul',
            "08" => 'Aug',
            "09" => 'Sep',
            "10" => 'Oct',
            "11" => 'Nov',
            "12" => 'Dec',
        );

        $daysBn = array(
            "1" => "১","2" => "২",
            "3" => "৩","4" => "৪",
            "5" => "৫","6" => "৬",
            "7" => "৭","8" => "৮",
            "9" => "৯","10" => "১০",
            "11" => "১১","12" => "১২",
            "13" => "১৩","14" => "১৪",
            "15" => "১৫","16" => "১৬",
            "17" => "১৭","18" => "১৮",
            "19" => "১৯","20" => "২০",
            "21" => "২১","22" => "২২",
            "23" => "২৩","24" => "২৪",
            "25" => "২৫","26" => "২৬",
            "27" => "২৭","28" => "২৮",
            "29" => "২৯","30" => "৩০",
            "31" => "৩১",
        );
        $nextMonth = $request->month +1;
        $nextYear =$request->year;
        $priviousMonth = $request->month -1;
        $priviousYear = $request->year;

        if($request->month == 12){
            $nextMonth = 1;
            $nextYear = $request->year + 1;
        }

        if($request->month == 1){
            $priviousMonth = 12;
            $priviousYear = $request->year - 1;
        }

        $nextMonth = sprintf("%02d", $nextMonth);
        $priviousMonth = sprintf("%02d",  $priviousMonth);
        $date = mktime(12, 0, 0, $request->month, 1, $request->year);
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN,$request->month, $request->year);
        $offset = date("w", $date);
        $row_number = 1;

        $html = $html .'<div class=" d-flex justify-content-center mb-2">';
        $html = $html .'<span>' .$monthEnList[$request->month].'-'.$request->year. '/ </span> <span id="banglaYearMonthSpan">'.$monthBnList[$request->month].'-'.$request->year.'</span>';
        $html = $html."</div>";
        $html = $html .'<div class="table-responsive">';
        $html = $html . "<table class='table table-bordered' width='100%'>";
        $html = $html. '<tr>
                <td style="width: 10%;">

                    <input type="text" hidden id="priviousMonthInput" value="'.$priviousMonth.'-'.$priviousYear.'" readonly>
                    <button type="button" class="btn btn-default btn_theme" id="priviousMonthButton"><i class="fas fa-arrow-circle-left"></i></button>
                </td>
                <td colspan=5></td>
                <td style="width: 10%;">
                    <input type="text" hidden id="nextMonthInput" value="'.$nextMonth.'-'.$nextYear.'" readonly>
                    <button type="button"  class="btn btn-default btn_theme" id="nextMonthButton"><i class="fas fa-arrow-circle-right"></i></button>
                </td>
            </tr>'.'<tr>
                <td style="width: 10%;">রবি</td>
                <td style="width: 10%;">সোম</td>
                <td style="width: 10%;">মঙ্গল</td>
                <td style="width: 10%;">বুধ</td>
                <td style="width: 10%;">বৃহস্পতি</td>
                <td style="width: 10%;">শুক্র</td>
                <td style="width: 10%;">শনি</td>
            </tr>
            <tr>';
            for($i = 1; $i <= $offset; $i++)
            {
                $html = $html. "<td></td>";
            }

            for($day = 1; $day <= $numberOfDays; $day++)
            {
                if( ($day + $offset - 1) % 7 == 0 && $day != 1)
                {
                    $html = $html."</tr> <tr>";
                    $row_number++;
                }
                $html = $html. "<td>" . $daysBn[$day] . "</td>";
            }

        while( ($day + $offset) <= $row_number * 7)
        {
            $html = $html."<td></td>";
            $day++;
        }
        $html = $html."</tr></table>";
        $html = $html."</div>";


        return  json_encode($html);
    }

    public function layoutCalenderGenerate(Request $request){
        $html = '';

        $monthBnList = array(
            "01" => 'পৌষ',
            "02" => 'মাঘ',
            "03" => 'ফাল্গুন',
            "04" => 'চৈত্র',
            "05" => 'বৈশাখ',
            "06" => 'জ্যৈষ্ঠ',
            "07" => 'আষাঢ়',
            "08" => 'শ্রাবণ',
            "09" => 'ভাদ্র',
            "10" => 'আশ্বিন',
            "11" => 'কার্তিক',
            "12" => 'অগ্রহায়ণ',
        );

        $monthEnList = array(
            "01" => 'Jan',
            "02" => 'Feb',
            "03" => 'Mar',
            "04" => 'Apr',
            "05" => 'May',
            "06" => 'Jun',
            "07" => 'Jul',
            "08" => 'Aug',
            "09" => 'Sep',
            "10" => 'Oct',
            "11" => 'Nov',
            "12" => 'Dec',
        );

        $daysBn = array(
            "1" => "১","2" => "২",
            "3" => "৩","4" => "৪",
            "5" => "৫","6" => "৬",
            "7" => "৭","8" => "৮",
            "9" => "৯","10" => "১০",
            "11" => "১১","12" => "১২",
            "13" => "১৩","14" => "১৪",
            "15" => "১৫","16" => "১৬",
            "17" => "১৭","18" => "১৮",
            "19" => "১৯","20" => "২০",
            "21" => "২১","22" => "২২",
            "23" => "২৩","24" => "২৪",
            "25" => "২৫","26" => "২৬",
            "27" => "২৭","28" => "২৮",
            "29" => "২৯","30" => "৩০",
            "31" => "৩১",
        );
        $nextMonth = $request->month +1;
        $nextYear =$request->year;
        $priviousMonth = $request->month -1;
        $priviousYear = $request->year;

        if($request->month == 12){
            $nextMonth = 1;
            $nextYear = $request->year + 1;
        }

        if($request->month == 1){
            $priviousMonth = 12;
            $priviousYear = $request->year - 1;
        }

        $nextMonth = sprintf("%02d", $nextMonth);
        $priviousMonth = sprintf("%02d",  $priviousMonth);
        $date = mktime(12, 0, 0, $request->month, 1, $request->year);
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN,$request->month, $request->year);
        $offset = date("w", $date);
        $row_number = 1;

        $html = $html .'<div class=" d-flex justify-content-center mb-2">';
        $html = $html .'<span>' .$monthEnList[$request->month].'-'.$request->year. '/ </span> <span id="layoutBanglaYearMonthSpan">'.$monthBnList[$request->month].'-'.$request->year.'</span>';
        $html = $html."</div>";
        $html = $html .'<div class="table-responsive">';
        $html = $html . "<table class='table table-bordered' width='100%'>";
        $html = $html. '<tr>
                <td style="width: 10%;">

                    <input type="text" hidden id="layoutPriviousMonthInput" value="'.$priviousMonth.'-'.$priviousYear.'" readonly>
                    <button type="button" class="btn btn-default btn_theme" id="layoutPriviousMonthButton"><i class="fas fa-arrow-circle-left"></i></button>
                </td>
                <td colspan=5></td>
                <td style="width: 10%;">
                    <input type="text" hidden id="layoutNextMonthInput" value="'.$nextMonth.'-'.$nextYear.'" readonly>
                    <button type="button"  class="btn btn-default btn_theme" id="layoutNextMonthButton"><i class="fas fa-arrow-circle-right"></i></button>
                </td>
            </tr>'.'<tr>
                <td style="width: 10%;">রবি</td>
                <td style="width: 10%;">সোম</td>
                <td style="width: 10%;">মঙ্গল</td>
                <td style="width: 10%;">বুধ</td>
                <td style="width: 10%;">বৃহস্পতি</td>
                <td style="width: 10%;">শুক্র</td>
                <td style="width: 10%;">শনি</td>
            </tr>
            <tr>';
            for($i = 1; $i <= $offset; $i++)
            {
                $html = $html. "<td></td>";
            }

            for($day = 1; $day <= $numberOfDays; $day++)
            {
                if( ($day + $offset - 1) % 7 == 0 && $day != 1)
                {
                    $html = $html."</tr> <tr>";
                    $row_number++;
                }
                $html = $html. "<td>" . $daysBn[$day] . "</td>";
            }

        while( ($day + $offset) <= $row_number * 7)
        {
            $html = $html."<td></td>";
            $day++;
        }
        $html = $html."</tr></table>";
        $html = $html."</div>";


        return  json_encode($html);
    }
}
