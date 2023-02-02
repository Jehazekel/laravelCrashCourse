<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //

    public function index(){
        // 'dd' is a die dump
        // dd( request()->tag ); // ''request()' or 'Request $request' gives an instance of a request
        // dd( request('tag') ); // ''request()' or 'Request $request' gives an instance of a request

        // return view('listings', [
        //     'heading' => 'LaraGigs',
        //     // 'listings' => Listing::all(), 
        //     'listings' => Listing::latest()->get()  //which gets the all from the lastest entry first
        // ]);

        // to add pagination, we use '->paginate(numPages)' 
        // for the next page we use the parameters '?page=2'
        return view('listings', [
            'heading' => 'LaraGigs',
            'listings' => Listing::latest()
            ->filter(  array ( 
                'tag' => request('tag' ), 
                'search' => request('search'), 
                
                ) )  //filter uses a user defined 'scopeFilter( $query, array $filters )'  
            ->paginate(3)  //which gets the all from the lastest entry first
                // for 'next/ prev' buttons use 'simplePaginate
        ]);

        return view('listings', [
            'heading' => 'LaraGigs',
            'listings' => Listing::latest()
            ->filter(  array ( 
                'tag' => request('tag' ), 
                'search' => request('search'), 
                
                ) )  //filter uses a user defined 'scopeFilter( $query, array $filters )'  
            ->get()  //which gets the all from the lastest entry first
        ]);
    }

    public function show(Listing $listing){

        return view('listing', [
            'listings' => $listing
        ]);
    }


    public function create( ){ //returns create form

        return view('listings.create');
    }


    // Store listing data
    public function store(Request $request){
        // dd($request->all()); // to dump all the request parameters
        // dd($request->file('logo')); // to dump file with the key name

        // Validating form use '
        $formFields = $request->validate(
            // array of rules (if we have more than one rule)
            [
                'title' => 'required',
                // for multiple rules we use an array : for unique `Rule::unique('tableName', 'column')`
                'company' => ['required', Rule::unique('listings', 'company')],
                'location' => 'required',
                'website' => 'required',
                'email' => ['required', 'email'],
                'tags' => 'required' ,
                'description' => 'required' ,

            ]);
            
        // N.B if the validation fails, it automatically  returns an error

        // Check if file was uploaded 
        if($request->hasFile('logo') ){ //logo is the input field name
            //  
            $formFields['logo'] = $request -> file('logo')->store('logos', 'public'); // stores by default in storage/app folder 
            // ... the path 'logos' creates a folder with that name : the options 'public' stores the file in storage/app/public folder 
            // to create a semi link from './public' to './storage' run ``` php artisan storage:link ```  (which makesthe stored files publicly accessible)
        }

        // setting the Listings user_id
        $formFields['user_id'] = auth()->id(); //'auth()->id()' get the id for the current user
        
        // dd($formFields );
        Listing::create($formFields  ) ; //returns key array
        
        // Adding Flash meessages
        // Session::flash( '', 'Listing'); 

        // Alternative for adding flash message
        return  redirect('/')->with('success', 'Listing created successfully!'); 
    }


    public function edit(Listing $listing){ //recieves a listing id & obtains the listing on request and passes it to the edit form view
        // dd($listing);
        // dd($listing->title);
        return view('listings.edit', ['listing' => $listing]);
    }


    // Update listing data
    public function update(Request $request, Listing $listing){
        // dd($request->all()); // to dump all the request parameters
        // dd($request->file('logo')); // to dump file with the key name


        // Make sure user logged in is the owner
        if($listing->user_id != auth()->id() ){
            abort( 403, 'Unauthorized Action');
        }

        // Validating form use '
        $formFields = $request->validate(
            // array of rules (if we have more than one rule)
            [
                'title' => 'required',
                // for multiple rules we use an array : for unique `Rule::unique('tableName', 'column')`
                'company' =>  ['required'], //['required', Rule::unique('listings', 'company')], //we can't have unqiue here because resubmiting the same company will give an error
                'location' => 'required',
                'website' => 'required',
                'email' => ['required', 'email'],
                'tags' => 'required' ,
                'description' => 'required' ,

            ]);
            
        // N.B if the validation fails, it automatically  returns an error

        // Check if file was uploaded 
        if($request->hasFile('logo') ){ //logo is the input field name
            //  
            $formFields['logo'] = $request -> file('logo')->store('logos', 'public'); // stores by default in storage/app folder 
            // ... the path 'logos' creates a folder with that name : the options 'public' stores the file in storage/app/public folder 
            // to create a semi link from './public' to './storage' run ``` php artisan storage:link ```  (which makesthe stored files publicly accessible)
        }
        
        // dd($formFields );
        $listing -> update($formFields  ) ; 
        
        // Adding Flash meessages
        // Session::flash( '', 'Listing'); 

        // Alternative for adding flash message
        // return  redirect('/')->with('success', 'Listing created successfully!'); 
        
        // to go back to page of request
        return  back()->with('success', 'Listing updated successfully!'); 
    }


    public function delete( Listing $listing ){

        
        // Make sure user logged in is the owner
        if($listing->user_id != auth()->id() ){
            abort( 403, 'Unauthorized Action');
        }

        $listing -> delete(); //to delete a record
        return  redirect('/')->with('success', 'Listing deleted successfully!'); 
        
    }


    public function manage( ){
        // dd(auth()->user()); //'auth()->user()' returns an instance of user class
        // dd(auth()->user()->listings()->get()); //'auth()->user()->listings()' returns an query of user class & 'get()' returns the results
        
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
