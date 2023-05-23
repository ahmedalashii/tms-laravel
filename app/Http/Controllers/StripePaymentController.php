<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Exception\MissingParameterException;

class StripePaymentController extends Controller
{
    public function paymentStripe()
    {
        return view('stripe');
    }

    public function postPaymentStripe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_no' => 'required',
            'ccExpiryMonth' => 'required',
            'ccExpiryYear' => 'required',
            'cvvNumber' => 'required',
        ]);

        $input = $request->except('_token');
        
        if($validator->passes()){
            $stripe = Stripe::setApiKey(env('STRIPE_SECRET'));
            try {
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number' => $request->get('card_no'),
                        'exp_month' => $request->get('ccExpiryMonth'),
                        'exp_year' => $request->get('ccExpiryYear'),
                        'cvc' => $request->get('cvvNumber'),
                    ],
                ]);
                if (!isset($token['id'])) {
                    return redirect()->back()->with('error', 'The Stripe Token was not generated correctly');
                }
                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' => 'USD',
                    'amount' => 10.00,
                    'description' => 'Test payment from TrainMaster',
                ]);
                if ($charge['status'] == 'succeeded') {
                    dd($charge);
                    return redirect()->back()->with('success', 'Payment successful!');
                } else {
                    return redirect()->back()->with('error', 'Money not add in wallet!!');
                }
            } catch (Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            } catch(CardErrorException $e) {
                return redirect()->back()->with('error', $e->getMessage());
            } catch(MissingParameterException $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }
}
