<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Auth;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    public function register(CreateAuthorRequest $request)
    {

        try {

            // $authorExists = User::where('email', $request->email)->first();

            // //dd($authorExists->count());
            // if ($authorExists) {
            //     return response(['error' => 'User already exists!'], 400);
            // }
            $author = User::create($request->validated());
            $token = $author->createToken("blogToken")->plainTextToken;

            if ($author) {
                return response([
                    'success' => 'Registration done successfully !',
                    'author' => $author,
                    'token' => $token
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    // login user
    public function login(Request $request)
    {

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required'
        ]);


        $authorExists = User::where('email', $fields['email'])->first();
        if (!$authorExists || !Hash::check($fields['password'], $authorExists->password)) {
            return response(['loggedin' => false, 'errors' => 'Login failed ! Wrong credentials.'], 401);
        }

        $token = $authorExists->createToken("blogToken")->plainTextToken;


        return response([
            'success' => 'LogIn done successfully !',
            'author' => $authorExists,
            'token' => $token
        ]);
    }

    // get authenticated author
    public function getAuthor()
    {

        $author = [];
        $author['name'] = auth()->user()->name;
        $author['email'] = auth()->user()->email;



        return response($author);
    }


    public function getAuthorPost()
    {
        $author = auth()->user()->post()->get();

        return response($author);
    }

    // log the author out
    public function logout(Request $request)
    {

        try {

            auth()->user()->tokens()->delete();



            return response(['message' => 'Logged out!']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
