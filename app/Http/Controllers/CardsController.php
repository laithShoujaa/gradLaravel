<?php

namespace App\Http\Controllers;


use App\Models\Cards;
use App\Models\Users;
//use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
class CardsController extends Controller
{
    public function create_account(Request $request){
        $create= $request->all();
        $validator=Validator::make( $create,[
            "name"=> "required",
            "birthDate"=>"required",
            "gender"=> "required",
            "phone"=> "required",
            "location"=> "required",
            "typeCard"=> "required",
            "blood"=> "required",
            //    "userID" => Auth::id()

//typeCard	name	birthDate	gender	location	blood	phone	passcode	macAddress	picId

        ]);

        $prodect=Cards::create([
            "name"=> $create["name"],
            "birthDate"=> $create["birthDate"],
            "gender"=> $create["gender"],
            "phone"=> $create["phone"],
            "location"=> $create["location"],
            "typeCard"=> $create["typeCard"],
            "blood"=> $request->blood,
            "passcode"=> rand(1000000000,9999999999),
            "userID"=> Auth::id()

        ]);
        if(Auth::user()['cardId']==null){
            Users::where('id',Auth::id())->update([
                "cardId"=> $prodect["id"]
            ]);
        }
        return $prodect;
        }
    }




?>
