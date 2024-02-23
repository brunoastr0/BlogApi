<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAuthorRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
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
    public function index()
    {
        $auth_user = auth()->user();

        $author = [];
        $author['name'] = $auth_user->name;
        $author['email'] = $auth_user->email;
        $author['Posts'] = PostResource::collection($auth_user->post()->get());




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
