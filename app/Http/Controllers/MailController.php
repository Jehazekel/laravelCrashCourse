<?php

namespace App\Http\Controllers;

use App\Mail\emailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public function sendMail( ){

        $name = 'Jerry' ;
        $url = 'http://192.119.91.91/storage/images/185-Out With A Bang Cover Art.png';
        // 
        // Mail::to('jeremiahstrong321@gmail.com')
        // ->send( new emailTemplate($name, $url)) ;

        // return view('emailForm') ;
        return new emailTemplate($name, $url);
    }
}
