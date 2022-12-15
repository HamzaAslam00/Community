<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\RequestAdminMail;
use App\Models\RegistrationPage;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
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
        if ($slug) {
            $registrationPage = RegistrationPage::with('tickets', 'groups')->where('slug', $slug)->first();
            if(!$registrationPage) {abort(404);}
            if($registrationPage->status == 'inactive'){abort(403);}
            return view('payments.payment_form', compact('registrationPage'));
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
            'registration_page_id' => 'required',
            'ticket_id' => 'required',
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'card-holder-name' => 'required',
        ],[
            'ticket_id.required' => 'Please Select a ticket to proceed.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try{
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make(12345678),
                    'user_type' => 'user',
                    'status' => 'inactive',
                ]);
                $user->assignRole('user');
            }

            $amount = Ticket::find($request->ticket_id)->amount;
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($request->payment_method);
            $user->charge($amount * 100, $request->payment_method);

            $user->update([
                'status' => 'active',
            ]);
            
            $registrationPage = RegistrationPage::with('groups')->findOrFail($request->registration_page_id);
            $user->groups()->sync($registrationPage->groups()->pluck('id')->toArray());
            
            event(new Registered($user));
            Auth::login($user);
            $route =  redirect(RouteServiceProvider::HOME);
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'User created successfully',
                'route' => $route,
            ], JsonResponse::HTTP_OK);

        } catch(Exception $e){
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
