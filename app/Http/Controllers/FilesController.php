<?php

namespace App\Http\Controllers;

use App\Models\Cards;
use App\Models\Files;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
  public function getFile($id)
  {
    try {

      $file = Files::where('id', $id)->first();
      if ($file != null) {
        $responseFile = Storage::disk('public')->get($file['filePath']);
        return (new Response($responseFile, 200))->header('Content-Type', $file['fileType']);
      }
    } catch (Exception $e) {
      return response()->json([
        "state" => false,
        "data" => $e->getMessage()
      ]);
    }
  }

  public function getCardFile(Request $request)
  {
    try {
      $request->validate([
        'passcode' => 'required',
        'userId' => 'required'
      ]);
      $data = Files::where('userId', $request->userId)
        ->where('passcode', $request->passcode)
        ->where('drugSens', false)
        ->first(['id', 'detail', 'fileName', 'fileType']);
      return response()->json([
        'state' => true,
        'data' => $data
      ]);
    } catch (Exception $e) {
      return response()->json([
        "state" => false,
        "data" => $e->getMessage()
      ]);
    }
  }

  public function addCardFile(Request $request)
  {
    try {
      $request->validate([
        'passcode' => 'required',
        'detail' => 'required',
        'fileName' => 'required'
      ]);

      $cardId = Cards::where('passcode', $request['passcode'])->where('userId', Auth::id())->value('id');
      if ($cardId != null) {
        if ($request->file('file') != null) {
          $file = $request->file('file');
          $filePath = time() . $file->getClientOriginalName();
          $fileType = $file->guessClientExtension();
          //return 1;
          Storage::disk('public')->put($filePath, File::get($file));
          $f = Files::create([
            'cardId' => $cardId,
            'filePath' => $filePath,
            'fileType' => $fileType,
            'detail'=>$request['detaile'],
            'fileName' => $request['fileName'],
            'drugSens' => false
          ]);
          return response()->json([
            'state' => true,
          ]);
        }
        else{
          $f = Files::create([
            'cardId' => $cardId,
            'detail'=>$request['detaile'],
            'fileName' => $request['fileName'],
            'drugSens' => false
          ]);
          return response()->json([
            'state' => true,
          ]);
        }
      }
      return response()->json([
        'state' => false,
      ]);
    } catch (Exception $e) {
      return response()->json([
        "state" => false,
        "data" => $e->getMessage()
      ]);
    }
  }

  public function addDrugSens(Request $request)
  {
    try {
      $request->validate([
        'passcode' => 'required',
        'detail' => 'required',
        'fileName' => 'required'
      ]);

      $cardId = Cards::where('passcode', $request['passcode'])->where('userId', Auth::id())->value('id');
      if ($cardId != null) {
        if ($request->file('file') != null) {
          $file = $request->file('file');
          $filePath = time() . $file->getClientOriginalName();
          $fileType = $file->guessClientExtension();
          //return 1;
          Storage::disk('public')->put($filePath, File::get($file));
          $f = Files::create([
            'cardId' => $cardId,
            'filePath' => $filePath,
            'fileType' => $fileType,
            'detail'=>$request['detaile'],
            'fileName' => $request['fileName'],
            'drugSens' => true
          ]);
          return response()->json([
            'state' => true,
          ]);
        }
        else{
          $f = Files::create([
            'cardId' => $cardId,
            'detail'=>$request['detaile'],
            'fileName' => $request['fileName'],
            'drugSens' => true
          ]);
          return response()->json([
            'state' => true,
          ]);
        }
      }
      return response()->json([
        'state' => false,
      ]);
    } catch (Exception $e) {
      return response()->json([
        "state" => false,
        "data" => $e->getMessage()
      ]);
    }
  }

  public function getCardDrugSens(Request $request)
  {
    try {
      $request->validate([
        'passcode' => 'required',
        'userId' => 'required'
      ]);
      $data = Files::where('userId', $request->userId)
        ->where('passcode', $request->passcode)
        ->where('drugSens', true)
        ->first(['id', 'detail', 'fileName']);
      return response()->json([
        'state' => true,
        'data' => $data
      ]);
    } catch (Exception $e) {
      return response()->json([
        "state" => false,
        "data" => $e->getMessage()
      ]);
    }
  }
}
