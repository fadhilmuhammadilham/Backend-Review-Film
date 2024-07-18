<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\GenerateOtpMail;
use App\Mail\RegisterMail;
use App\Models\OtpCode;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $roleUser = Role::where('name', 'user')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleUser->id
        ]);

        $user->generateOtp();

        Mail::to($user->email)->queue(new RegisterMail($user));

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Register berhasil',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function generateOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $userData = User::where('email', $request->email)->first();

        if (!$userData) {
            return response()->json([
                'message' => 'Pengguna dengan email tersebut tidak ditemukan'
            ], 404);
        } else {
            Mail::to($userData->email)->queue(new GenerateOtpMail($userData));
            $userData->generateOtp();
            return response()->json([
                'message' => 'Berhasil generate ulang OTP',
                'data' => $userData
            ]);
        }
    }

    public function verifikasi(Request $request)
    {
        $request->validate([
            'otp' => 'required|max:6'
        ]);

        $otp = OtpCode::where('otp', $request->otp)->first();

        if (!$otp) {
            return response()->json([
                'message' => 'Kode otp tidak di temukan atau belum di Generate'
            ]);
        }

        $now = Carbon::now();

        if ($now > $otp->valid_until) {
            return response()->json([
                'message' => 'Kode Otp anda kadaluarsa silahkan generate ulang'
            ]);
        }

        $user = User::find($otp->user_id);
        $user->email_verified_at = $now;

        $user->save();

        $otp->delete();

        return response()->json([
            'message' => 'Berhasil Verifikasi Akun'
        ]);
    }

    public function getUser()
    {
        $currentUser = auth()->user();

        return response()->json([
            'message' => 'Berhasil get user',
            'user' => $currentUser
        ]);
    }

    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!$user = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userData = User::where('email', $request['email'])->first();

        $token = JWTAuth::fromUser($userData);

        return response()->json([
            'user' => $userData,
            'token' => $token
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Logout berhasil']);
    }


    public function update(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'data tidak di temukan'
            ], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->name = $request['name'];
        $user->save();

        return response()->json([
            'message' => 'User berhasil di update',
        ]);
    }
}
