<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Listing;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// SHow Register form
Route::get('/register', [UserController::class, 'create'])
->middleware('guest');

// Create & login a user
Route::post('/users', [ UserController::class, 'store']);

// logout user
Route::post('/logout', [UserController::class, 'logout'])
->middleware('auth');

// Show login Form
Route::get('/login', [UserController::class, 'login'])
->name('login')
->middleware('guest'); //this defines the middleware check for each route

// log in User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);


// Route::get('/', function () {
//     return view('welcome');
// });

//                                          LISTING ROUTES

// Manage Listings
Route::get('/listings/manage',[ListingController::class, 'manage'])
->middleware('auth');

// Delete Form Submit 
Route::delete('listings/{listing}', [ListingController::class, 'delete'])
->middleware('auth');

// Edit Form Submit to Update
Route::put('listings/{listing}', [ListingController::class , 'update'])
->middleware('auth') ;

// Show Edit Listing Form
Route::get( '/listings/{listing}/edit', [ListingController::class, 'edit'] )
->middleware('auth'); //uses the 'edit' method in ListingController

// show CreateForm
Route::get('/listings/create',[ListingController::class, 'create'])
->middleware('auth');

// Receive form data
Route::post('/listings',[ListingController::class, 'store'])
->middleware('auth');



// Controller equivalent
Route::get('/', [ListingController::class, 'index']); // which uses the index method of the controller Class
Route::get('/listings', function () {



    // return response()->json([
    //     'listings' => [
    //         [
    //             'id' => 1,
    //             'title' => 'Listing One',
    //             'description ' => 'random'
    //         ],
    //         [
    //             'id' => 2,
    //             'title' => 'Listing Two',
    //             'description ' => 'random'
    //         ],
    //         'li' => Listing::all()
    //     ],
    // ]);

    // return view( 'listings', [
    //     'heading' => 'latest Headings',
    //     'listings' => [ ]
    // ]);

    return view('listings', [
        // array of data to be passed to view
        'heading' => 'Latest Listings',
        'listings' => Listing::all()
    ]);
});


Route::get('/listings/{id}', function ($id) {

    if ($id)
        return view('listing', [
            'listing' => Listing::find($id)
        ]);
    else {
        abort('404');
    }
});

// When using Eloquent Model( made from migrate:make model cmd) , we can pass an entire model
// Route::get('/listings/{listing}', function (Listing $listing){

//     // this method of passing the model, does the built in 404 method
//     return view('listing', [
//         'listing' => $listing
//     ]);

// });


Route::get('/hello', function () {
    // return '[Hello World !';
    return response('<h1> Hello World ! </h1>', 200)
        ->header('Content-Type', 'text/plain')
        ->header('foo', 'bar');  //setting the content to text/plain renders it as text not html
});


Route::get('/posts/{id}', function ($id) { // '{id}' catches the id as a parameter

    return response('Post ' . $id);
})->where('id', '[0-9]+');  //matches only the paths where the id is a 'number'


Route::get('/search', function (Request $request) { //to retrieve params from route '/search?name=Jerry&city=Arima' 
    // dd( $request );

    return ($request->name . ' ' . $request->city); //returns 'Jerry Arima'
});
