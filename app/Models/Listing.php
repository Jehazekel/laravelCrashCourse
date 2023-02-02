<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    // to set the fields that can be assigned (e.g. on create) simultaneously : alteernative add 'Model::ungaurd()' in 'boot()' method for file 'Providers/AppService/'
    protected $fillable = ['title', 'company', 'location', 'email','website', 'tags', 'description', 'logo'];

    // To block all fields from being assigned
    // protected $guarded = ['*']; 


    public function scopeFilter( $query, array $filters ){
        // dd( $filters['tag']); 
        if( $filters['tag'] ?? false){
            $query -> where('tags', 'like', '%'.request('tag').'%');  //filters by column 'tags' where tags like requestTag
        };
        if( $filters['search'] ?? false){ //if there is a search filter
            $query -> where('title', 'like', '%'.request('search').'%')
            ->orWhere('description', 'like', '%'.request('search').'%')  
            ->orWhere('tags', 'like', '%'.request('search').'%');  //filters by column 'titles', 'tags' , or 'dsecription' where tags like requestTag
        };
    }

    // Defining the relationship to USer 
    public function user(){
        return $this->belongsTo(User::class , 'user_id'); //gives one to one relationship from Listings to User 
                                                            //  & 1-to-many from User to Listing
    }
}
