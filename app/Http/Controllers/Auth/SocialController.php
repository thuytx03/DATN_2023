<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Exception;


class SocialController extends Controller
{
    // dang nhap google
    protected $newUser;
    public function signInwithGoogle()
    {
        if (Auth::check()) {
            return redirect(route('index'));
        };
        return Socialite::driver('google')->redirect();
    }

    public function callbackToGoogle(Request $request)
    {
        try {
            // đăng nhập với google
            $user = Socialite::driver('google')->user();
            $finduser = User::where('gauth_id', $user->id)->first();
           
            // nếu đã có tài khoản tự động đăng nhập
            if ($finduser->status == 2) {
                toastr()->error('Tài Khoản của bạn đang bị khóa!', 'Congrats');
                return redirect(route('sign-up'));
            }
            if ($finduser) {

                Auth::login($finduser);


                return redirect(route('index'));
                // nếu chưa có thì sẽ tự động thêm mới 
            } else {
                $newUser =  $this->newUser;
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'gauth_id' => $user->id,
                    'gauth_type' => 'google',
                    'password' => encrypt('admin@123')
                ]);

                // email chào mừng
                $name = 'Chào Mừng   ' . '  ' . $newUser->name . '' . 'đến với boleto';
                Mail::send('admin.auth.mail', compact('name'), function ($message) {
                    $newUser =  $this->newUser;
                    $email = $newUser->email;
                    $name = $newUser->name;
                    $message->from('anhandepgiai22@gmail.com', 'Boleto');
                    $message->sender('john@johndoe.com', 'John Doe');
                    $message->to($email, $name);
                    $message->replyTo('john@johndoe.com', 'John Doe');
                    $message->subject('Chào Mừng đến với BoLeto');
                    $message->priority(3);
                });
                Auth::login($newUser);
                toastr()->success('Data has been saved successfully!', 'Congrats');
                return redirect(route('index'));
            }
        } catch (Exception $e) {
            toastr()->error('Oops! Something went wrong!', 'Oops!');
            return redirect(route('sign-up'));
        }
    }
    // dang nhap google
    // test send email
    public function sendMail()
    {
        $name = 'adadada';
        Mail::send('test', compact('name'), function ($message) {
            $email = 'levanan3418@gmail.com';
            $message->from('anhandepgiai22@gmail.com', 'Boleto');
            $message->sender('john@johndoe.com', 'John Doe');
            $message->to($email, 'John Doe');
            $message->replyTo('john@johndoe.com', 'John Doe');
            $message->subject('subject');
            $message->priority(3);
        });
    }
    // kết thúc test
    public function logout()
    {
        Auth::logout();
        return redirect(route('sign-up'));
    }
}
