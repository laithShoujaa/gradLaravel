<?php

namespace App\Http\Controllers;

use App\Models\Cards;
use App\Models\Users;
use App\Notifications\VerfCode;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Exception;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class UsersController extends Controller
{

    public function userDetails(Request $request)
    {
        try {
            $user = Auth::user();
            $card = Cards::where('id', $user['cardId'])->first();
            return response()->json([
                "state" => true,
                "data" => [
                    "name" => $card["name"],
                    "passCode" => $card["passcode"],
                    "userID" => $user["userID"],
                    "picId" => $card["picId"]
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "state" => false,
                "data" => $e->getMessage()
            ]);
        }
    }

    public function verify(Request $request)
    {
        $user = Users::create([
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        $userId = $user->id * 100 + 20;
        $user = Users::where('email', $request->email)->update(['userId' => $userId]);
        $user = Users::where('email', $request->email)->first();
        Auth::login($user);
        $token = $user->createToken("api")->plainTextToken;
        return response()->json([
            'state' => true,
            'token' => $token
        ]);
    }

    public function register(Request $request)
    {

        $user = Users::where("email", $request->email)->first();
        if ($user == null) {
            $user=Users::create([
                'email'=>$request->email,
                "password" => Hash::make('123')
            ]);
            $verf = 0; //عملية توليد اربع ارقان عشوتئية
            for ($i = 0; $i < 4; $i++) {
                $verf *= 10;
                $verf += random_int(1, 9);
            }
            // $verf = "0000";
            $data = array('name' => $verf);
            $email = $request->email;

            /*Mail::send(['text'=>'mail'], $data, function($message,$add=$email) {
                $message->to($add, 'Tutorials Point')->subject
                ('Laravel Basic Testing Mail');
                $message->from('lethkings.2222@gmail.com','Virat Gandhi');
                });*/
                //email send here
            $message= new VerfCode($email,$verf);
            Notification::sendNow($user, $message);
            Users::where('email',$user['email'])->delete();
            return response()->json([
                'state' => true,
                'data' => strval($verf)
            ]);
        } else {
            return response()->json([
                'state' => false,
                'data' => "email already exist"
            ]);
        }
    }

    public function login(Request $request)
    {
        try {
            $validate = $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }


        try {
            $password = Users::where('email', $request->email)->value('password');
            if (Hash::check($request->password, $password)) {
                $user = Users::where('email', $request->email)->first();
                Auth::login($user);
                $token = $user->createToken("api")->plainTextToken;
                $userId = Users::where('email', $request->email)->value('id');
                return response()->json([
                    'state' => true,
                    'data' => $token,
                    'cardCount' => Cards::where('userID', $userId)->count()
                ]);
            } else {
                return response()->json([
                    'state' => false,
                    'data' => 'wrong email or password'
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function logout(Request $request)
    {
        DB::table('personal_access_tokens')->where('tokenable_id', Auth::id())->delete();
        return true;
    }
}
