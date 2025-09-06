<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserForm;
class FormController extends Controller
{
     public function showForm()
    {
        return view('form');
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:user_forms,email',
        ]);

        UserForm::create($request->only('name', 'email'));

        // Save email in session to prevent refill
        session(['email' => $request->email]);

        return redirect()->route('form.thankyou');
    }

    public function thankyou()
    {
        return view('thankyou');
    }
}
