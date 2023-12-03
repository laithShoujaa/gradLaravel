<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
  public function getFile(Request $request)
  {
    try {
      $request->validate([
        'id' => 'required'
      ]);
      $file = Files::where('id', $request['id'])->first();
      if ($file != null) {
        $responseFile = Storage::disk('public')->get($file->path);
        return (new Response($responseFile, 200))->header('Content-Type', $file->typeFile);
      }
    } catch (Exception $e) {
      return response()->json([
        "state" => false,
        "data" => $e->getMessage()
      ]);
    }
  }
}
