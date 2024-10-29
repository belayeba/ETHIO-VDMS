<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification\NotificationModel;
use App\Models\User;
use App\Models\User\UserModel;
use App\Notifications\CustomMessageNotification;
use Exception;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    function clear_all_notifications()
        {
            NotificationModel::where('user_id', Auth::id())->delete();
            return response()->json("success",200);         
        }
    function get_all_notifications()
        {
            $my_notification = NotificationModel::where('user_id', Auth::id())->latest()->get();
            return response()->json(["notifications"=> $my_notification]);        
        }

    function delete_notification(Request $request)
        {
            NotificationModel::where('user_id', Auth::id())->where("notification_id",$request->notification_id)->delete();
            return response()->json("success",200);         
        }
    function read_all_notifications(Request $request)
        {
            NotificationModel::where('user_id', Auth::id())->update([
                "is_read"=>1
            ]);
            return response()->json("success",200);         
        }
    function get_new_message_count(Request $request)
        {
            return response()->json(["new_notification"=>NotificationModel::where('user_id', Auth::id())->where("is_read",0)->count()],200);   
        }
    function check_notify()
        {
            $id = Auth::id();
            $user = User::find($id);
            $message = "Notification works very well";
            $subject = "CHECKING";
            $url = "facebook.com";
            $user->NotifyUser($message,$subject,$url);
        }
}

