<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    //
    public function sendEmail(Request $request)
    {
        $title = 'Welcome to the laracoding.com example email';
        $content =  $request->input('content');
        $email = $request->input('email');

        
        Mail::to($email)->send(new SendEmail($title, $content));

        return redirect()->back()->with('success',"Gửi email thành công");

       
    }
}
