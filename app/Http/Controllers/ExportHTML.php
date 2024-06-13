<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportHTML extends Controller
{
    public function export(Request $request)
    {
        $content = $request->input('content');
        dd($content);

        // Process the content as needed, for example, save to file or database

        return response()->json(['success' => true]);
    }
}
