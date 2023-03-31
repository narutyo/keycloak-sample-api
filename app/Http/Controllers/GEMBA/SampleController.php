<?php

namespace App\Http\Controllers\GEMBA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SampleController extends Controller
{
  public function echo(Request $request)
  {
    return array(
      'message' => json_encode($request->toArray(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
    );
  }
}
