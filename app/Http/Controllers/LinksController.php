<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LinksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Link::with('user')->get();
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function mylinks(Request $request){
        $user_id=$request->user()->id;
        $links=Link::where('users_id',$user_id)->limit(100)->get();
        return response()->json($links);
    }


    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'original' => 'required|url|max:1000',
            ]);
        } catch (ValidationException $e) {
            // Return the validation error response to the client
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(jkjk),
            ], 422); // 422 indicates Unprocessable Entity (validation failed)

            // You can also use $e->getMessage() to get the error message if you prefer.
            // However, $e->errors() will give you an array with detailed error messages for each field.
        }
        $shortend=$this->generateShortLink();
        $userId=auth()->user()['id'];
        $link=Link::create([
            'users_id'=>$userId,
            'name'=>$validatedData['name'],
            'visits'=>0,
            'original'=>$validatedData['original'],
            'shortened'=>$shortend
        ]);
        return response()->json([
            'message' => 'Link created successfully',
            'link' => $link,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $id = (int)$id;

            $link = Link::findOrFail($id);

           return response()->json([
               'message'=>'Link retrieved successfully',
               'link'=>$link
           ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case where the link is not found, for example, redirect or show an error page
            abort(404, 'Link not found');
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $link=Link::findOrFail($id);
        if(!$link){
            abort(404, 'Link not found');
        }else{
            $link->name=$request->name;
            $link->original=$request->original;
            $link->save();
            return response()->json([
                'message'=>'link updated successfully',
                'link'=>$link
            ]);
        }
    }


    function generateShortLink($length = 5) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $shortLink = '';

        do {
            $shortLink = substr(str_shuffle($characters), 0, $length);
        } while (Link::where('shortened', $shortLink)->exists());

        return $shortLink;
    }
    public function redirect(Request $request,$id){
        $link=DB::table('links')
            ->where('shortened', '=', $id)
            ->get();
        if ($link) {
            // Increment the visits count
            DB::table('links')
                ->where('shortened', '=', $id)
                ->increment('visits');
            return $link[0]->original; // Redirect the user
        } else {
            return response()->json(['error' => 'Link not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
