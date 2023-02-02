<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // to create controller run ```php artisan make:controller UserController`


    // show register/create form
    public function create( ){
        return view('users.register');
    }   

    // Create a new User 
    public function store(Request $request){

        $formFields = request()->validate([
            'name' => ['required', 'min:3'], //to defined a min # of characters
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6'], //pwd is required & min of 6 characters
            // 'password' => ['required | confirmed | min:6'], //pwd is required & min of 6 characters

        ]);

        // Hash passwords using 'bcrpty' in laravel
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User
        $user = User::create( $formFields); 

        // login
        auth()->login($user );

        return redirect('/')->with('success', 'User created and logged in');
    }

    public function logout( Request $request){

        auth()->logout() ;

        // invalidate users token & send a newToekn
        $request -> session() ->invalidate();
        $request -> session() ->regenerateToken();

        return redirect('/') -> with('success', 'You have been logged out!');
    }


    public function login(Request $request){
        return view('users.login');
    }

    // to Sign in a user
    public function authenticate( Request $request){

        // Validate form
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required' ], //pwd is required & min of 6 characters
           
        ]);

        // Attempt to login the user 9returns true
        if( auth()->attempt($formFields) ){
            // Create new token
            $request -> session() ->regenerate();

            return redirect('/') -> with('success', 'You are now logged in!');
        
        }
        
        
        return back()->withErrors(['email'=>'Invalid Credentials'])
        ->onlyInput('email'); // 'onlyInput' makes it show only for email
    }
}
