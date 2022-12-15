<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivationUrl;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendUserCredencialsMail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function processPayment(Request $request) {
        $activationUrl = ActivationUrl::with('registrationPage.groups', 'tickets', 'user')->findOrFail($request->activation_url_id);
        $user= $activationUrl->user;
        $paymentMethod = $request->input('payment_method');
        
        try {
            // dd($request->all());
            DB::beginTransaction();
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->charge(array_sum($activationUrl->tickets->pluck('amount')->toArray()) * 100, $paymentMethod);

            $user->update([
                'status' => 'active',
            ]);
            $user->groups()->sync($activationUrl->registrationPage->groups()->pluck('id')->toArray());

            $user = [
                'name' => getFullName($user),
                'email' => $user->email,
            ];
            Mail::to($user['email'])->send(new SendUserCredencialsMail($user));

            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Payment received successfully. Please check your Email for Login Credencials.',
            ], JsonResponse::HTTP_OK);

        } catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
