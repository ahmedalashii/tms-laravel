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
        $trainee = auth_trainee();
        // if the training program discipline is in the trainee's disciplines
        if ($trainee->hasDiscipline($id)) {
            $trainingProgram = TrainingProgram::find($id);
            if ($trainingProgram->fees > 0) {
                return $next($request);
            } else {
                return redirect()->route('trainee.available-training-programs')->with(['fail' => 'This training program is ', 'type' => 'error']);
            }
        } else {
            return redirect()->route('trainee.available-training-programs')->with(['fail' => 'You are not allowed to access this training program', 'type' => 'error']);
        }
    }
}
