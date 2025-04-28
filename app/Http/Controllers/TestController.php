<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return view('test.index');
    }


    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Process the data (e.g., save to database, send email, etc.)
        // For demonstration, we'll just return a success message
        return response()->json(['message' => 'Data processed successfully!']);
    }
}
