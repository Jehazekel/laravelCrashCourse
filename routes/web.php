<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Listing;
use Illuminate\Support\Facades\Storage;

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

// Show Upload Form
Route::get('/upload2', function () {

    return view('uploads.VideoUploadForm2');
});

// To recieve file in chunks ( install 'composer require pion/laravel-chunk-upload')
Route::post('/upload2', function (Request $request) {

    error_log('Current Chunk : ' . $request->resumableChunkNumber);
    error_log('Total Chunk : ' . $request->resumableTotalChunks);
    error_log('File Type : ' . $request->resumableType);

    $uploader =  new UploadController() ;
    
    return $uploader->upload($request);

    return response(['request' => $request], 200);
    // $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

    // if (!$receiver->isUploaded()) {
    //     // file not uploaded
    // }

    // $fileReceived = $receiver->receive(); // receive file
    // if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
    //     $file = $fileReceived->getFile(); // get file
    //     $extension = $file->getClientOriginalExtension();
    //     $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName()); //file name without extenstion
    //     $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

    //     // $disk = Storage::disk(config('filesystems.default'));
    //     $disk = Storage::disk('s3');
    //     $path = $disk->putFileAs('test', $file, $fileName);

    //     // delete chunked file
    //     unlink($file->getPathname());
    //     return [
    //         // 'path' => asset('storage/' . $path),
    //         'path' => asset('images'),
    //         'filename' => $fileName
    //     ];
    // }

    // // otherwise return percentage information
    // $handler = $fileReceived->handler();
    // return [
    //     'done' => $handler->getPercentageDone(),
    //     'status' => true
    // ];

});

// Show Upload Form
Route::get('/upload', function () {

    return view('uploads.uploadForm');
});

// Save Upload File ( WOrking for small Files e.g. videos or images)
Route::post('/upload', function (Request $request) {

    $request->validate(['video_file' => 'required']);

    // validate
    if ($request->hasFile('video_file')) {


        dd($request->file('video_file'));

        // TO STORE LOCALLY
        // $path = $request->file('video_file')->store('images' , 'public');// stores by default in storage/app folder 
        // ... the path 'images' creates a folder with that name : the options 'public' stores the file in storage/app/public folder 
        // to create a semi link from './public' to './storage' run ``` php artisan storage:link ```  (which makesthe stored files publicly accessible)

        // $path = Storage::disk('s3')->put('', $request->file('video_file') , ['name']);

        // to use s3 install flysystem using 'composer require league/flysystem-aws-s3-v3'
        $path = $request->file('video_file')->store('images', 's3'); // 
        return back()->with('success', $path);



        // Storage::disk('s3')->put('', $request->file('video_file') , [

        // ])
        return back()->with('success', '/');
    } else
        return back()->withErrors(['file' => 'No File was found!']);
    // return view('uploads.uploadForm');
});

// ShowEmail Form
Route::get('/sendmail', [MailController::class, 'sendMail']);

// Show Email Form 
Route::get('/email', function () {

    return view('emailForm', [
        'title', 'Festiv Media Submission',
        'subject', 'Test Email'
    ]);
});

Route::post('/email', function (Request $request) {

    // validate form first 
    $formFields = $request->validate(
        // array of rules (if we have more than one rule)
        [
            'title' => 'required',
            'subject' => ['required'],
            'email' => ['required', 'email'],
        ]
    );
    dd($formFields['title']);
});

// SHow Register form
Route::get('/register', [UserController::class, 'create'])
    ->middleware('guest');

// Create & login a user
Route::post('/users', [UserController::class, 'store']);

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
Route::get('/listings/manage', [ListingController::class, 'manage'])
    ->middleware('auth');

// Delete Form Submit 
Route::delete('listings/{listing}', [ListingController::class, 'delete'])
    ->middleware('auth');

// Edit Form Submit to Update
Route::put('listings/{listing}', [ListingController::class, 'update'])
    ->middleware('auth');

// Show Edit Listing Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])
    ->middleware('auth'); //uses the 'edit' method in ListingController

// show CreateForm
Route::get('/listings/create', [ListingController::class, 'create'])
    ->middleware('auth');

// Receive form data
Route::post('/listings', [ListingController::class, 'store'])
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
