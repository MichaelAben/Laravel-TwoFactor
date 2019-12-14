<?php

namespace MabenDev\TwoFactor\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('TwoFactor.index', [
            'qr' => Auth::user()->getQr(),
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            '2fa' => 'required',
        ]);

        /** @var User $user */
        $user = Auth::user();
        if(!$user->checkCode($request->input('2fa'))) {
            return redirect()->back()->with('error', 'Invalid code, please try again');
        }

        $request->session()->put('2fa', true);
        Auth::user()->twoFactor->update(['setup' => true]);
        return redirect()->route('home');
    }
}
