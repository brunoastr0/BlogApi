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

class AuthorController extends Controller
{
    public function register(CreateAuthorRequest $request)
    {

        try {

            $authorExists = User::where('email', $request->email)->first();

            //dd($authorExists->count());
            if ($authorExists) {
                return response(['error' => 'User already exists!'], 400);
            }
            $author = User::create($request->validated());

            if ($author) {
                return response(['success' => 'Registration done successfully !', 'author' => $author]);
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
        $validators = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validators->fails()) {
            return response(['errors' => $validators->getMessageBag()->toArray()]);
        } else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $author = $request->user();
                $author->api_token = Str::random(80);
                $author->save();
                return response(['loggedin' => true, 'success' => 'Login was successfully !', 'author' => Auth::user()]);
            } else {
                return response(['loggedin' => false, 'errors' => 'Login failed ! Wrong credentials.']);
            }
        }
    }

    // get authenticated author
    public function getAuthor()
    {
        $author = [];
        $author['name'] = Auth::user()->name;
        $author['email'] = Auth::user()->email;
        return response($author);
    }

    // log the author out
    public function logout(Request $request)
    {

        try {
            $author = $request->user();

            $author->api_token = NULL;
            $author->save();
            return response(['message' => 'Logged out!']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
