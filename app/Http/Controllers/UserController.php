<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\list_user;
use App\Models\tbl_notification;

class UserController extends Controller
{
    public function index()
    {
        $list = list_user::all();
        
        return view('user_list', compact('list'));

    }
    public function create(Request $request)
    {
    
        $list = new list_user;

        $list->name = $request->name;
        $list->detail = $request->detail;
        $list->save();

        return response()->json(['success' => 'Item created successfully']);

    }

    public function Notification(Request $request)
    {
        $notif = new tbl_notification;

        $notif->description = $request->description;
        $notif->save();

        // Return the ID of the created notification
        return response()->json(['notification_id' => $notif->id]);

    
    }
}
