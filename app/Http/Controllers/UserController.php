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

    public function edit($id)
    {
        $user = list_user::find($id);

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = list_user::find($id);
        $user->name = $request->input('name');
        $user->detail = $request->input('detail');
        $user->save();

        if($user)
        {
            return response()->json([
                'status' => 'TRUE',
                 'data' => $user,
                  'message' => 'Successfully update']);
        }

        else
        {
            return response()->json([
                    'status' => 'FALSE',
                    'message' => 'Error updating']);
        }
        

        


        
    }

    public function Notification(Request $request)
    {
        $notif = new tbl_notification;

        $notif->description = $request->description;
        $notif->save();

        // Return the ID of the created notification
        return response()->json(['notification_id' => $notif->id]);

    
    }

    public function listOfNotifLogs()
    {
        $notif = tbl_notification::all();

        return view('notif_logs', compact('notif'));
    }
}
