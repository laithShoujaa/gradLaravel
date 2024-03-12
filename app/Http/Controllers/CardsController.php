<?php

namespace App\Http\Controllers;


use App\Models\Cards;
use App\Models\Files;
use App\Models\Users;
use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

//use Validator;
class CardsController extends Controller
{
    public function counts()
    {
        try {
            $id = Auth::id();
            $nfcCount = Cards::where('userID', $id)->where('typeCard', 'nfc')->count();
            $smartHomeCount = Cards::where('userID', $id)->where('typeCard', 'smartHome')->count();
            return response()->json([
                "state" => true,
                "data" => [
                    "nfcCount" => $nfcCount,
                    "smartHomeCount" => $smartHomeCount
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                "state" => false,
                "data" => $e->getMessage()
            ]);
        }
    }
    public function usersCards()
    {
        try {
            $user = Auth::user();
            $cards = Cards::where('userID', $user['id'])->where('typeCard', 'nfc')->get(['name', 'passcode', 'picId']);
            return response()->json([
                "state" => true,
                "data" => [
                    "id" => $user["userID"],
                    "cards" => $cards
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                "state" => false,
                "data" => $e->getMessage()
            ]);
        }
    }

    public function cardData(Request $request)
    {
        try {
            $userId = Users::where('userID', $request->userID)->value('id');
            $card = Cards::where('userId', $userId)->where('passcode', $request->passcode)->first([
                'name', 'passcode', 'picId', 'gender', 'birthDate', 'blood', 'location', 'phone'
            ]);
            if ($card != null) {
                return response()->json([
                    "state" => true,
                    "data" => [
                        "card" => $card
                    ]
                ]);
            } else {
                return response()->json([
                    "state" => false,

                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "state" => false,
                "data" => $e->getMessage()
            ]);
        }
    }

    public function userCard()
    {
        try {
            $user = Auth::user();
            $id = $user["cardId"];
            $cards = Cards::where('id', $id)->where('typeCard', 'nfc')->first([
                'name', 'passcode', 'picId', 'gender', 'birthDate', 'blood', 'location', 'phone'
            ]);
            return response()->json([
                "state" => true,
                "data" => [
                    "card" => $cards
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                "state" => false,
                "data" => $e->getMessage()
            ]);
        }
    }

    public function addCard(Request $request)
    {
        try {
            $create = $request->all();
            $validator = $request->validate([
                "name" => "required",
                "birthDate" => "required",
                "gender" => "required",
                "phone" => "required",
                "location" => "required",
                "typeCard" => "required",
                "blood" => "required",
            ]);

            $prodect = Cards::create([
                "name" => $create["name"],
                "birthDate" => $create["birthDate"],
                "gender" => $create["gender"],
                "phone" => $create["phone"],
                "location" => $create["location"],
                "typeCard" => $create["typeCard"],
                "blood" => $request->blood,
                "passcode" => $create["typeCard"] == 'nfc' ? rand(1000000000, 9999999999) : null,
                "userID" => Auth::id()

            ]);

            $file = $request->file('cardPic');
            $filePath = time() . $file->getClientOriginalName();
            $fileType = $file->guessClientExtension();
            //return 1;
            Storage::disk('public')->put($filePath, File::get($file));
            $f = Files::create([
                'cardId' => $prodect['id'],
                'filePath' => $filePath,
                'fileType' => $fileType,
                'type' => 'personal'
            ]);

            Cards::where('id', $prodect['id'])->update([
                'picId' => $f['id']
            ]);

            if (Auth::user()['cardId'] == null) {
                Users::where('id', Auth::id())->update([
                    "cardId" => $prodect["id"]
                ]);
            }
            return response()->json(["state" => true], 200);
        } catch (Exception $e) {
            return response()->json([
                "state" => false,
                "data" => $e->getMessage()
            ]);
        }
    }

    public function editCard(Request $request)
    {
        try {
            $id = Auth::id();
            $request->validate([
                'name' => 'required',
                'passcode' => 'required',
                'gender' => 'required',
                'phone' => 'required',
                'birthDate' => 'required',
                'blood' => 'required',
                'location' => 'required'
            ]);
            $newCard = Cards::where('userID', $id)->where('passcode', $request['passcode'])->update([
                'name' => $request['name'],
                'gender' => $request['gender'],
                'phone' => $request['phone'],
                'birthDate' => $request['birthDate'],
                'blood' => $request['blood'],
                'location' => $request['location']
            ]);

            return response()->json([
                'state' => true,
                'data' => Cards::where('userId', $id)->where('passcode', $request->passcode)->first([
                    'name', 'passcode', 'picId', 'gender', 'birthDate', 'blood', 'location', 'phone'
                ])
            ]);
        } catch (Exception $e) {
            return response()->json([
                "state" => false,
                "data" => $e->getMessage()
            ]);
        }
    }
}
