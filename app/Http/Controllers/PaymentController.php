<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivationUrl;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function cardDetails(Request $request) {
        $validator = Validator::make($request->all(), [
            'activation_url_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        // dd($request->all());
        $activationUrl = ActivationUrl::with('registrationPage', 'tickets', 'user')->findOrFail($request->activation_url_id);
        $intent = $activationUrl->user->createSetupIntent();
        return view('payments.card_details', compact('activationUrl', 'intent'));
        
    }
}
