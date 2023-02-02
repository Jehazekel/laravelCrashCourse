<?php


namespace App\Models; //namespace to make the file accessible



// TO generate call php artisan make:model [NAME]

class Listing
{
  public static function all()
  {
    return [
      [
        'id' => 1,
        'title' => 'Listing One',
        'description' => 'random'
      ],
      [
        'id' => 2,
        'title' => 'Listing Two',
        'description' => 'random'
      ],
    ];
  }


  public static function find($id){
    $listings = self::all() ;

    foreach($listings as $listing ){
      if ( $listing['id'] == $id)
        return $listing;
    }
  }
}
