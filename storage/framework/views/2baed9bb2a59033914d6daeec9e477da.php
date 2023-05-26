<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Traing Program Payment</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet" />
</head>

<body>
    <div class="row">
        <div class='col-md-12'>
            <div class="card">
                <div class="card-header">
                    <h5>Training Program: <span class="text-danger"><?php echo e($trainingProgram->name); ?></span></h5>
                </div>
                <div class="card-body">
                    <?php if(Session::has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?php echo e(Session::get('error')); ?>

                        </div>
                    <?php endif; ?>
                    <form class="form-horizontal" method="POST" id="payment-form" role="form"
                        action="<?php echo e(route('trainee.stripe-payment', $trainingProgram->id)); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label class='control-label'>Card Number</label>
                            <input autocomplete='off' class='form-control card-number' size='20' type='text'
                                name="card_no" required>
                        </div>
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label class='control-label'>CVV</label>
                                <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311'
                                    type='text' name="cvvNumber" size="4" required>
                            </div>
                            <div class="col-auto">
                                <label class='control-label'>Expiration</label>
                                <input class='form-control card-expiry-month' placeholder='MM' size='4'
                                    type='text' name="ccExpiryMonth" required>
                            </div>
                            <div class="col-auto">
                                <label class='control-label'>Year</label>
                                <input class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='text' name="ccExpiryYear" required>
                                <input class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='hidden' name="amount" value="<?php echo e($trainingProgram->fees); ?>">
                            </div>
                        </div>

                        <div class="mb-3" style="padding-top:20px;">
                            <h5 class='total'>Total: <span class='amount'>$<?php echo e($trainingProgram->fees); ?></span></h5>
                        </div>

                        <div class="mb-3">
                            <button class='form-control btn btn-success submit-button' type='submit'>Pay »</button>
                        </div>

                        <div class="mb-3">
                            <div class='alert-danger alert' style="display:none;">
                                Please correct the errors and try again.
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php echo $__env->make('includes.js.allJS', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html>
<?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/trainee/stripe.blade.php ENDPATH**/ ?>