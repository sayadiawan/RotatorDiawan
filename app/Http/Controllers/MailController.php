<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\EmailOmsayoer;
use Illuminate\Support\Facades\Mail;
use Modules\Customers\Entities\Customer;
use Ramsey\Uuid\Uuid;

class MailController extends Controller
{
    public function sendEmail(Request $request) {


        $email = $request->post('email');

        $set_customer = Customer::where('email',$email)->first();
        if (!empty($set_customer)) {

            $update_token = Customer::find($set_customer->id_customer);
            $token = Uuid::uuid4();
            $update_token->email_token = $token->toString(); 


            $mail_data = [
                'title' => 'Demo Email',
                'url' => 'http://localhost:8000/reset-password-email/'.$update_token->email_token
            ];
      
            $send = Mail::to($email)->send(new EmailOmsayoer($mail_data));
            
            $update_token->save();
            if ($send) {
                return response()->json([
                    'message' => 'Email has been sent.',
                    'status'=> true
                ], 200);
            }else{
                return response()->json([
                    'message' => $send,
                    'status'=> false
                ], 400);
            }
        }else{
            return response()->json([
                'message' => 'Email Not Found',
                'status'=> false
            ], 400);
        }
   
       
        
    }
}