<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\ResetPassMail;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

     //view
     public function ShowResetPasswordEmail($token)
     {
         $cekToken = User::where('token_reset','=',$token)->count();
         if($cekToken > 0){
             $cekDate = User::where('token_reset',$token)->first();
             $dateNow = Carbon::now()->toDateTimeString();
             if(($dateNow >= $cekDate->date_token_reset_now) && ($dateNow <= $cekDate->date_token_reset_end) ){
                 $status = 1;
             }else{
                 // Token Expired
                 $status = 2;
             }
         }else{
             //Token tidak ditemukan
             $status = 3;
         }
         return view('auth.passwords.reset', ['token' => $token, 'status'=>$status]);
     }
 
    //proses
    public function ResetPasswordEmail(Request $request)
    {
        $email = $request->email;
        $token = Uuid::uuid4();
        $dateTokenResetNow = Carbon::now()->toDateTimeString();
        $dateTokenResetEnd = Carbon::now()->addMinutes(30)->toDateTimeString();

        $validated = Validator::make($request->all(), [
            'email' => 'email',
        ],
        [
        'email.email' => 'Email Tidak Sesuai Standar'
        ]);

        if ($validated->fails()) {
            return response()->json(['status'=>false, 'message'=>'Email Tidak Sesuai Standar']);
        }
        $cekMail = User::wherehas('employee',function ($query) use ($email)
        {
            $query->where('email_employee',$email);
        })->first();
        if (empty($cekMail->id)) {
            return response()->json(['status'=>false, 'message'=>'Email Tidak Ditemukan']);
        }
        if ($cekMail->status==0) {
            return response()->json(['status'=>false, 'message'=>'Akun Tidak Aktif']);
        }
    
        $update = [
            'token_reset'=>$token,
            'date_token_reset_now'=>$dateTokenResetNow,
            'date_token_reset_end'=>$dateTokenResetEnd
        ];

        $updateToken = User::wherehas('employee',function ($query) use ($email)
        {
            $query->where('email_employee',$email);
        })->update($update);
        
        $detailMail = [
            'title' => 'Informasi SAS',
            'nama' => $cekMail->employee->name_employee,
            'desc' => 'Berikut Adalah Link Untuk Reset Password Akunmu.',
            'token'=>$token,
        ];

        if($updateToken){
            $sendMail = Mail::to($email)->send(new ResetPassMail($detailMail));
            return response()->json(['status'=>true,'message'=>'Silahkan Cek Email Anda Untuk Reset Password']);
        }
    
        
    }
 
    public function ResetPasswordCustome(Request $request)
    {
        $token = $request->post('token_reset');
        $password = $request->post('password');
        $cek = User::where('token_reset',$token)->first();
        $dateNow = Carbon::now()->toDateTimeString();
        if(($dateNow >= $cek->date_token_reset_now) && ($dateNow <= $cek->date_token_reset_end) ){
            $save['password'] = Hash::make($request->password);
            $save['date_token_reset_now'] = null;
            $save['date_token_reset_end'] = null;
            $save['token_reset'] = null;
            $save['email_verified_at'] = date('Y-m-d H:i:s');
            $set = User::where('id',$cek->id)->update($save);
            if($set){
                return response()->json(['status'=>true,'message'=>'Berhasil Mereset Password']);
            }else{
                return response()->json(['status'=>false,'message'=>'Gagal Mereset Password']);
            }
        }else{
            return response()->json(['status'=>false,'message'=>'Token expired']);
        }
        
    }
}