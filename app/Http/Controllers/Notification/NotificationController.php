<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\UserModel;
use App\Notifications\CustomMessageNotification;
use Exception;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller {
    function clear_all_notifications() {
        NotificationModel::where( 'user_id', Auth::id() )->delete();
        return response()->json( 'success', 200 );

    }

    function get_all_notifications() {
        $my_notification = NotificationModel::where( 'user_id', Auth::id() )->latest()->get();
        return response()->json( [ 'notifications'=> $my_notification ] );

    }

    function delete_notification( Request $request ) {
        NotificationModel::where( 'user_id', Auth::id() )->where( 'notification_id', $request->notification_id )->delete();
        return response()->json( 'success', 200 );

    }

    function read_all_notifications( Request $request ) {
        NotificationModel::where( 'user_id', Auth::id() )->update( [
            'is_read'=>1
        ] );
        return response()->json( 'success', 200 );

    }

    function get_new_message_count( Request $request ) {
        $my_notification = NotificationModel::select( 'url', 'message', 'subject', 'notification_id' )->where( 'user_id', Auth::id() )->latest()->get();
        return response()->json( [ 'new_notification'=>NotificationModel::where( 'user_id', Auth::id() )->where( 'is_read', 0 )->count(), 'data'=>$my_notification ], 200 );

    }

    function redirect_to_intended( Request $request ) {
        // Validate incoming request data
        $validator = Validator::make( $request->all(), [
            'notification_id' => 'required|uuid|exists:notifications,notification_id',
            'route' => 'required|string|max:100|url',
        ] );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        // Retrieve the notification and verify it exists
        $notification = NotificationModel::find( $request->notification_id );
        if ( !$notification ) {
            return redirect()->back()->with( 'error_message', 'Notification not found.' );
        }

        // Ensure that the notification is not already marked as read
        if ( $notification->is_read ) {
            return redirect()->back()->with( 'error_message', 'Notification is already marked as read.' );
        }

        // Try to mark the notification as read and handle potential issues
        try {
            $notification->is_read = 1;
            $notification->save();
        } catch ( \Exception $e ) {
            return redirect()->back()->with( 'error_message', 'Failed to update notification status.' );
        }
        // Perform the redirection if everything is valid
        return redirect( $request->route );
    }

}

