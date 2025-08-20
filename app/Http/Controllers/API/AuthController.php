<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    use ResponseTrait;

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'بيانات الدخول غير صحيحة'], 401);
        }


        // if ($user->role !== 'family') {
        //     return response()->json(['message' => 'غير مصرح لك بالدخول من هذا التطبيق'], 403);
        // }

        if (! $user->active) {
            return response()->json(['message' => 'تم تعطيل حسابك من قبل الإدارة'], 403);
        }

        $token = $user->createToken('family-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function me()
    {
        $user = Auth::user();
        return $this->successResponse($user);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return $this->messageSuccessResponse();
    }
}
