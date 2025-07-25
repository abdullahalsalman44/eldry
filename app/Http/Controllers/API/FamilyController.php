<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ElderlyPerson;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Hash;

class FamilyController extends Controller
{
    public function myElderly(Request $request)
    {
        $user = $request->user();

        $elderly = $user->elderlyPeople()->with('room')->get();

        return response()->json($elderly);
    }

    public function showDailyReports(Request $request, $elderlyId)
    {
        $user = $request->user();

        if (! $user->elderlyPeople->contains('id', $elderlyId)) {
            return response()->json(['message' => 'غير مصرح'], 403);
        }

        $elderly = ElderlyPerson::with('dailyReports')->findOrFail($elderlyId);

        return response()->json($elderly->dailyReports);
    }




    public function sendInquiry(Request $request)
    {
        $request->validate([
            'elderly_id' => 'nullable|exists:elderly_people,id',
            'message' => 'required|string|min:5',
        ]);

        $user = $request->user();


        if ($request->elderly_id) {
            if (! $user->elderlyPeople->contains('id', $request->elderly_id)) {
                return response()->json(['message' => 'غير مصرح بإرسال استفسار لهذا المقيم'], 403);
            }
        }


        $inquiry = Inquiry::create([
            'user_id'    => $user->id,
            'elderly_id' => $request->elderly_id, // قد تكون null
            'message'    => $request->message,
        ]);

        return response()->json([
            'message' => 'تم إرسال الاستفسار بنجاح',
            'inquiry' => $inquiry,
        ], 201);
    }




    public function myInquiries(Request $request)
    {
        $user = $request->user();

        $inquiries = Inquiry::with(['elderly:id,full_name', 'responder:id,name'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($inquiries);
    }


    public function myNotifications(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->orderBy('sent_at', 'desc')
            ->get();

        return response()->json($notifications);
    }


    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'sometimes|string|max:100',
            'phone' => 'sometimes|string|max:20',
        ]);

        $user->update($request->only('name', 'phone'));

        return response()->json([
            'message' => 'تم تحديث الملف الشخصي بنجاح',
            'user' => $user
        ]);
    }



    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'كلمة المرور الحالية غير صحيحة'], 403);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(['message' => 'تم تغيير كلمة المرور بنجاح']);
    }
}
