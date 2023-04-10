<?php

namespace App\Utilities;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SystemConstant
{
    public static function settingsCollectToArray($settings){
        $settingArray = array();
        foreach($settings as $perSetting){
            $settingArray[$perSetting->field] = $perSetting->value;
        }

        return $settingArray;
    }

    public static function generateFileName($fileName,$fileExtention,$maxLength){
        if (Str::of($fileName)->length() > 200) {
            $limitFileName = Str::of($fileName)->limit($maxLength);
            $fileName = $limitFileName;
        }

        if($fileName == null){
            $fileName == "File";
        }

        $fileNameGenerate = (str_replace(' ', '-',str_replace('.', '',Str::studly($fileName)))).'-'.Str::random(5).'-'.date('Ymdhis');
        if (Auth::check() == true) {
            $fileNameGenerateAfterAuth = $fileNameGenerate.'-u'.Auth::user()->id;
            $fileNameGenerate = $fileNameGenerateAfterAuth;
        }
        return $fileNameGenerate.'.'.$fileExtention;
    }

    public static function allDivision(){
        return array("Barisal","Chittagong","Dhaka","Khulna","Mymensingh","Rangpur","Rajshahi","Sylhet");
    }


    public static function pageShowOn(){
        return array("Ashram & Mondir","Contact","Guru Sangha","Home","Link","Service");
    }

    public static function pageSection(){
        return array(
            "Ashram & Mondir" => array("Barisal","Chittagong","Dhaka","Khulna","Mymensingh","Rangpur","Rajshahi","Sylhet"),
            "Contact" => array("Main"),
            "Guru Sangha" => array("108 Names of Sri Guru","Biography of  Sri Guru","Miracles of Sri Guru","Sri Guru Philosophy"),
            "Home" => array("About Us"),
            "Link" => array("Main"),
            "Service" => array("Guest House","Library","Medical Service","Prosad","Religious Event"),
        );
    }

    public static function generateCalender($current_Month, $year){
        $date = mktime(12, 0, 0, $current_Month, 1, $year);
        $numberOfDays =cal_days_in_month(CAL_GREGORIAN,$current_Month, $year);
        $offset = date("w", $date);
        $row_number = 1;
        $html = "";
        $html = $html . "<table style='width:auto; height:auto;'><br/>";
        $html = $html . "<tr><td>Sun</td><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td></tr> <tr>";

        for($i = 1; $i <= $offset; $i++){
            $html = $html . "<td></td>";
        }

        for($day = 1; $day <= $numberOfDays; $day++)
        {
            if( ($day + $offset - 1) % 7 == 0 && $day != 1){
                $html = $html ."</tr> <tr>";
                $row_number++;
            }
            echo "<td>" . $day . "</td>";
        }
        while( ($day + $offset) <= $row_number * 7)
        {
            $html = $html . "<td></td>";
            $day++;
        }
        $html = $html .  "</tr>";

        $html = $html .  "</table>";

        return $html;
    }

}
