<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
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
            return Response::json(['errors' => $validators->getMessageBag()->toArray()]);
        } else {
            $author = new User();
            $author->name = $request->name;
            $author->email = $request->email;
            $author->password = bcrypt($request->password);
            $author->api_token = Str::random(80);
            $author->save();
            return Response::json(['success' => 'Registration done successfully !', 'author' => $author]);
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
            return Response::json(['errors' => $validators->getMessageBag()->toArray()]);
        } else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $author = $request->user();
                $author->api_token = Str::random(80);
                $author->save();
                return Response::json(['loggedin' => true, 'success' => 'Login was successfully !', 'author' => Auth::user()]);
            } else {
                return Response::json(['loggedin' => false, 'errors' => 'Login failed ! Wrong credentials.']);
            }
        }
    }

    // get authenticated author
    public function getAuthor()
    {
        $author = [];
        $author['name'] = Auth::user()->name;
        $author['email'] = Auth::user()->email;
        return Response::json($author);
    }

    // log the author out
    public function logout(Request $request)
    {
        $author = $request->user();
        $author->api_token = NULL;
        $author->save();
        return Response::json(['message' => 'Logged out!']);
    }
}
