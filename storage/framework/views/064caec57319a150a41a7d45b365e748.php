<?php $__env->startComponent('mail::message'); ?>
    # Hello <?php echo e($trainee->displayName); ?>,

    You have been authorized by <?php echo e($manager->displayName); ?> to access the system. Please click the button below to login.

    Your ID is: <?php echo e($trainee->auth_id); ?>


    Please keep this ID safe as you will need it to login.

    <?php $__env->startComponent('mail::button', ['url' => route('trainee.login')], ['color' => 'sucess']); ?>
        Login Now
    <?php echo $__env->renderComponent(); ?>

    Thanks,
    <?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/emails/trainee_authorization.blade.php ENDPATH**/ ?>