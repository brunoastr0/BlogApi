<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    public function register(Request $request)
    {

        $validators = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        if ($validators->fails()) {
            return response(['errors' => $validators->getMessageBag()->toArray()]);
        } else {
            $author = new User();
            $author->name = $request->name;
            $author->email = $request->email;
            $author->password = bcrypt($request->password);
            $author->api_key = Str::random(80);
            $author->save();
            return response(['success' => 'Registration done successfully !', 'author' => $author]);
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
                $author->api_key = Str::random(80);
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
        $author = $request->user();
        $author->api_key = NULL;
        $author->save();
        return response(['message' => 'Logged out!']);
    }
}
