<?php

/**
 * Created by PhpStorm.
 * User: Tj
 * Date: 6/29/2016
 * Time: 3:11 PM
 */

namespace App\Helpers;

use App\Models\AuditTrail;
use App\Models\MemberTag;
use App\Models\Member;

use App\Models\Setting;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class GeneralHelper
{
    public static function memberKeysToKeyValue($keysArray){
        $pairs = [];
        foreach($keysArray as $key){
            $pairs[$key] = $key;
        }

        return $pairs;
    }

    public static function time_ago($eventTime)
    {
        $totaldelay = time() - strtotime($eventTime);
        if ($totaldelay <= 0) {
            return '';
        } else {
            if ($days = floor($totaldelay / 86400)) {
                $totaldelay = $totaldelay % 86400;
                return $days . ' days ago';
            }
            if ($hours = floor($totaldelay / 3600)) {
                $totaldelay = $totaldelay % 3600;
                return $hours . ' hours ago';
            }
            if ($minutes = floor($totaldelay / 60)) {
                $totaldelay = $totaldelay % 60;
                return $minutes . ' minutes ago';
            }
            if ($seconds = floor($totaldelay / 1)) {
                $totaldelay = $totaldelay % 1;
                return $seconds . ' seconds ago';
            }
        }
    }


    public static function audit_trail($notes)
    {   
        $audit_trail = new AuditTrail();
        if(Sentinel::getUser()){
            $audit_trail->user_id = Sentinel::getUser()->id;
            $audit_trail->user = Sentinel::getUser()->first_name . ' ' . Sentinel::getUser()->last_name;
        }else{
            $audit_trail->user_id = Member::all()->first()->member_id || 1;
            $audit_trail->user = 'System SelfRegister';
        }
        $audit_trail->notes = $notes;
        $audit_trail->save();

    }


    public static function createTreeView($parent, $menu, $selected = '')
    {
        if (empty($selected)) {
            $html = "";
            if (isset($menu['parents'][$parent])) {
                $html .= '<ul>';
                foreach ($menu['parents'][$parent] as $itemId) {
                    if (!isset($menu['parents'][$itemId])) {
                        $html .= '<li id="' . $itemId . '">' . $menu['items'][$itemId]['name'] . ' (' . MemberTag::where('tag_id',
                                $itemId)->count() . ' ' . trans_choice('general.people', 2) . ')</li>';
                    }
                    if (isset($menu['parents'][$itemId])) {
                        $html .= '
             <li id="' . $itemId . '">' . $menu['items'][$itemId]['name'] . " (" . MemberTag::where('tag_id',
                                $itemId)->count() . " " . trans_choice('general.people', 2) . ")";
                        $html .= GeneralHelper::createTreeView($itemId, $menu);
                        $html .= "</li>";
                    }
                }
                $html .= "</ul>";
            }
            return $html;
        } else {
            $html = "";
            if (isset($menu['parents'][$parent])) {
                $html .= '<ul>';
                foreach ($menu['parents'][$parent] as $itemId) {

                    if (!isset($menu['parents'][$itemId])) {
                        if (in_array($itemId, $selected)) {
                            $ext = "data-jstree='{\"selected\":true}'";
                        } else {
                            $ext = '';
                        }
                        $html .= '<li id="' . $itemId . '" ' . $ext . '> ' . $menu['items'][$itemId]['name'] . '</li>';
                    }
                    if (isset($menu['parents'][$itemId])) {
                        if (in_array($itemId, $selected)) {
                            $ext = "data-jstree='{\"selected\":true,\"open\":true}'";
                        } else {
                            $ext = '';
                        }
                        $html .= '<li id="' . $itemId . '"  ' . $ext . ' >' . $menu['items'][$itemId]['name'];
                        $html .= GeneralHelper::createTreeView($itemId, $menu, $selected);
                        $html .= "</li>";
                    }
                }
                $html .= "</ul>";
            }
            return $html;
        }
    }
}