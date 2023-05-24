<!DOCTYPE html>

<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('50fd908f86ab9aec746a', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('trainee-channel');
        channel.bind('trainee-event', function(data) {
            alert(JSON.stringify(data));
        });
    </script>
</head>

<body>
    <?php
        event(new \App\Events\MyEventNotification('Hey people'));
    ?>


    <h1>Pusher Test</h1>
    <p>
        Try publishing an event to channel <code>my-channel</code>
        with event name <code>my-event</code>.
    </p>
</body>
<?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/testnotification.blade.php ENDPATH**/ ?>