<?php

namespace App\Http\Controllers;

use App\Models\cardFiles;
use App\Models\Cards;
use App\Models\Files;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{

  function editFile(Request $request)
  {
    try {
      $id = Auth::id();
      $request->validate([
        'fileId' => 'required',
        'name' => 'required',
        'detail' => 'required'
      ]);
      $cardId = Files::where('id', $request['fileId'])->value('cardId');
      if ($cardId == null) {
        return response()->json([
          'state' => false,
          'data' => 'not found'
        ], 404);
      }
      $userId = Cards::where('id', $cardId)->value('userID');
      if ($id != $userId) {
        return response()->json([
          'state' => false,
          'data' => 'access denied'
        ], 403);
      }
      Files::where('id', $request['fileId'])->update([
        'fileName' => $request['name'],
        'detail' => $request['detail']
      ]);
      return response()->json([
        'state' => true
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'state' => false,
        'data' => $th->getMessage()
      ], 400);
    }
  }

  function deletecardFile(Request $request)
  {
    try {
      $id = Auth::id();
      $request->validate([
        'fileId' => 'required'
      ]);
      $cardId = Files::where('id', $request['fileId'])->value('cardId');
      if ($cardId == null) {
        return response()->json([
          'state' => false,
          'data' => 'not found'
        ], 404);
      }
      $userId = Cards::where('id', $cardId)->value('userID');
      if ($id != $userId) {
        return response()->json([
          'state' => false,
          'data' => 'access denied'
        ], 403);
      }
      Files::where('id', $request['fileId'])->delete();
      return response()->json([
        'state' => true
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'state' => false,
        'data' => $th->getMessage()
      ], 400);
    }
  }

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

  public function editFilePhoto(Request $request)
  {
    try {
      $id = Auth::id();
      $request->validate([
        'fileId' => 'required'
      ]);
      $cardId = Files::where('id', $request['fileId'])->value('cardId');
      if ($cardId == null) {
        return response()->json([
          'state' => false,
          'data' => 'not found'
        ], 404);
      }
      $userId = Cards::where('id', $cardId)->value('userID');
      if ($id != $userId) {
        return response()->json([
          'state' => false,
          'data' => 'access denied'
        ], 403);
      }
      if ($request->file('file') != null) {
        $file = $request->file('file');
        $filePath = time() . $file->getClientOriginalName();
        $fileType = $file->guessClientExtension();
        //return 1;
        Storage::disk('public')->put($filePath, File::get($file));
        $f = Files::where('id', $request['fileId'])->update([
          'filePath' => $filePath,
          'fileType' => $fileType
        ]);
        return response()->json([
          'state' => true
        ]);
      }
      $f = Files::where('id', $request['fileId'])->update([
        'filePath' => null,
        'fileType' => null
      ]);
      return response()->json([
        'state' => true,
      ]);
    } catch (Exception $e) {
      return response()->json([
        "state" => false,
        "data" => $e->getMessage()
      ], 500);
    }
  }

  public function editPhoto(Request $request)
  {
    try {
      $request->validate([
        'passcode' => 'required',
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
            'type' => 'personal'
          ]);
          Cards::where('id', $cardId)->update(['picId' => $f['id']]);
          return response()->json([
            'state' => true,
            "data" => $f['id']
          ]);
        }
        Cards::where('id', $cardId)->update(['picId' => null]);
        return response()->json([
          'state' => true,
          "data" => null
        ]);
      }
    } catch (Exception $e) {
      return response()->json([
        "state" => false,
        "data" => $e->getMessage()
      ], 500);
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
        ->where('type', 'presonal')
        ->first('id');
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
        'fileName' => 'required',
        'detail' => 'required',
        'type' => 'required'
      ]);
      $cardId = Cards::where('passcode', $request['passcode'])->where('userId', Auth::id())->value('id');
      if ($cardId == null) {
        return response()->json([
          'state' => false,
        ]);
      }
      if ($request['type'] == 'drug' || $request['type'] == 'ill') {
        $f = Files::create([
          'cardId' => $cardId,
          'detail' => $request['detail'],
          'fileName' => $request['fileName'],
          'type' => $request['type']
        ]);
        return response()->json([
          'state' => true,
        ]);
      } else {
        if ($request->file('file') != null) {
          $file = $request->file('file');
          $filePath = time() . $file->getClientOriginalName();
          $fileType = $file->guessExtension();
          //return 1;
          Storage::disk('public')->put($filePath, File::get($file));
          $f = Files::create([
            'cardId' => $cardId,
            'filePath' => $filePath,
            'fileType' => $fileType,
            'detail' => $request['detail'],
            'fileName' => $request['fileName'],
            'type' => $request['type']
          ]);
          return response()->json([
            'state' => true,
          ]);
        } else {
          $f = Files::create([
            'cardId' => $cardId,
            'detail' => $request['detail'],
            'fileName' => $request['fileName'],
            'type' => $request['type']
          ]);
          return response()->json([
            'state' => true,
          ]);
        }
      }
    } catch (Exception $e) {
      return response()->json([
        "state" => false,
        "data" => $e->getMessage()
      ]);
    }
  }

  public function getCardFiles(Request $request)
  {
    try {
      $request->validate([
        'passcode' => 'required',
        'userId' => 'required',
        'type' => 'required'
      ]);
      $userId = Users::where('userID', $request->userId)->value('id');
      if ($userId == null) {
        return response()->json([
          "state" => false,
          "data" => "no user found"
        ]);
      }
      $cardId = Cards::where('userId', $userId)
        ->where('passcode', $request->passcode)
        ->value('id');
      if ($cardId == null) {
        return response()->json([
          "state" => false,
          "data" => "no card found"
        ]);
      }
      $data = cardFiles::where('cardId', $cardId)
        ->where('type', $request['type'])
        ->where('deleted_at',null)
        ->get();
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
