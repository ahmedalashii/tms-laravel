<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\TrainingProgram;
use App\Http\Traits\EmailProcessing;
use Illuminate\Support\Facades\Session;
use App\Notifications\ManagerNotification;
use App\Notifications\TraineeNotification;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use App\Mail\TraineeTrainingProgramEnrollmentMail;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Exception\MissingParameterException;

class StripePaymentController extends Controller
{
    use EmailProcessing;

    public $stripe;

    public function __construct()
    {
        $this->stripe = Stripe::setApiKey(env('STRIPE_SECRET'));
    }


    public function paymentStripe($id, Request $request)
    {
        $trainingProgram = TrainingProgram::findOrFail($id);
        return view('trainee.stripe', compact('trainingProgram'));
    }

    public function postPaymentStripe($id, Request $request)
    {
        $trainingProgram = TrainingProgram::findOrFail($id);
        $request->validate([
            'card_no' => 'required|numeric',
            'ccExpiryMonth' => 'required|numeric|min:1|max:12',
            'ccExpiryYear' => 'required|numeric|min:' . date('Y') . '|max:' . (date('Y') + 10),
            'cvvNumber' => 'required|string|min:3|max:4',
        ]);
        $trainee = auth_trainee();
        $input = $request->except('_token');

        try {
            $token = $this->stripe->tokens()->create([
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
            $charge = $this->stripe->charges()->create([
                'card' => $token['id'],
                'currency' => 'USD',
                'amount' => $trainingProgram->fees,
                'description' => 'Payment for ' . $trainingProgram->name . ' training program' . ' by ' . $trainee->displayName,
            ]);
            if ($charge['status'] == 'succeeded') {
                info('Payment successful');
                $data = [
                    'trainee_id' => $trainee->id,
                    'training_program_id' => $trainingProgram->id,
                    'advisor_id' => $trainingProgram->advisor_id,
                    'status' => 'pending',
                    'fees_paid' => $trainingProgram->fees,
                ];
                $mailable = new TraineeTrainingProgramEnrollmentMail($trainee, $trainingProgram);
                $this->sendEmail($trainee->email, $mailable);
                $message = "$trainee->displayName has requested to enroll in $trainingProgram->name training program";
                // send notification to all managers
                $managers = \App\Models\Manager::all();
                foreach ($managers as $manager) {
                    $manager->notify(new ManagerNotification(null, null, $message));
                }
                $trainingProgram->training_program_users()->create($data);
                return redirect()->route('trainee.available-training-programs')->with(['success' => 'Payment has been successfully done!! Your request has been sent successfully and waiting for approval!', 'type' => 'success']);
            } else {
                return redirect()->back()->with(['fail', 'Insufficient balance!', 'type' => 'error']);
            }
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        } catch (CardErrorException $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        } catch (MissingParameterException $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}
