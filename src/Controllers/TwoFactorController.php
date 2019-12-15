<?php

namespace MabenDev\TwoFactor\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class TwoFactorController extends Controller
{
    public function index(Request $request)
    {
        Session::put('url.intended', URL::previous());
        return view('MabenDevTwoFactor::index', [
            'qr' => Auth::user()->getQr(),
        ]);
    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '2fa' => 'required',
        ]);

        $validator->after(function($validator) {
            /** @var User $user */
            $user = Auth::user();
            if(!$user->checkCode(Request()->input('2fa'))) {
                $validator->errors()->add('2fa', __('MabenDevTwoFactor::TwoFactor.error_invalid_code'));
            }
        });

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $request->session()->put('2fa', true);
        Auth::user()->twoFactor->update(['setup' => true]);
        return redirect()->intended(config('MabenDevTwoFactor.redirect_url', '/home'));
    }
}
