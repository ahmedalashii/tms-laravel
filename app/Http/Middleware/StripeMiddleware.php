<?php

namespace App\Http\Middleware;

use App\Models\TrainingProgram;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StripeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // We want to detect if the training program is free or not
        // Getting the id from the path parameter
        $id = $request->route('id');
        $training_program = TrainingProgram::find($id);
        $discipline = $training_program->discipline;
        $trainee = auth_trainee();
        // Check if there's a request for this training program from this trainee and it's pending
        $request_exists = $trainee->training_requests()->where('training_program_id', $id)->where('status', 'pending')->exists();
        if (!$request_exists) {
            // Check if the trainee is already enrolled in the training program and its status is approved
            if (!$trainee->approved_training_programs()->where('training_program_id', $id)->exists()) {
                // if the training program discipline is in the trainee's disciplines
                if ($trainee->hasDiscipline($discipline->id)) {
                    $trainingProgram = TrainingProgram::find($id);
                    if ($trainingProgram->fees > 0) {
                        return $next($request);
                    } else {
                        return redirect()->route('trainee.available-training-programs')->with(['fail' => 'This training program is ', 'type' => 'error']);
                    }
                } else {
                    return redirect()->route('trainee.available-training-programs')->with(['fail' => 'You are not allowed to access this training program', 'type' => 'error']);
                }
            } else {
                return redirect()->route('trainee.available-training-programs')->with(['fail' => 'You are already enrolled in this training program', 'type' => 'error']);
            }
        } else {
            return redirect()->route('trainee.available-training-programs')->with(['fail' => 'You already have a pending request for this training program', 'type' => 'error']);
        }
    }
}
