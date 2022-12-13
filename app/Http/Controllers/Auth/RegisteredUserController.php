<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\RequestAdminMail;
use App\Models\ActivationUrl;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $slug = request()->route('slug');
        $activationUrl = '';
        if ($slug) {
            $activationUrl = ActivationUrl::with('tickets', 'registrationPage')->where('url', route('register', $slug))->first();
            if(!$activationUrl) {abort(404);}
            if($activationUrl->status == 'inactive'){abort(403);}
            if ($activationUrl->tickets) {
                return view('payments.payment_form', compact('activationUrl'));
            } else {
                $activationUrl->user->update([
                    'status' => 'active',
                ]);
                return view('auth.login');
            }
        }
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try{
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make(12345678),
                'user_type' => 'user',
                'status' => 'inactive',
            ]);
            $user->assignRole('user');
            $user = [
                'name' => getFullName($user),
                'email' => $request->email,
            ];
            $adminEmail = User::role('admin')->first()->email;
            Mail::to($adminEmail)->send(new RequestAdminMail($user));
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Email sent! Admin will back to you soon',
            ], JsonResponse::HTTP_OK);

        } catch(Exception $e){
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        // event(new Registered($user));

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
    }
}
