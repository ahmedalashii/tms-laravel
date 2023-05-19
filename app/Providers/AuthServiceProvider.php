<?php

namespace App\Providers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Firebase\FirebaseManagerProvider;
use App\Firebase\FirebaseAdvisorProvider;
use App\Firebase\FirebaseTraineeProvider;
class AuthServiceProvider extends ServiceProvider {
   protected $policies = [
      // 'App\Model' => 'App\Policies\ModelPolicy',
   ];
   public function boot() {
      $this->registerPolicies();
      \Illuminate\Support\Facades\Auth::provider('firebasemanagerprovider', function($app, array $config) {
         return new FirebaseManagerProvider($app['hash'], $config['model']);
      });
      \Illuminate\Support\Facades\Auth::provider('firebaseadvisorprovider', function($app, array $config) {
         return new FirebaseAdvisorProvider($app['hash'], $config['model']);
      });
      \Illuminate\Support\Facades\Auth::provider('firebasetraineeprovider', function($app, array $config) {
         return new FirebaseTraineeProvider($app['hash'], $config['model']);
      });
   }
}