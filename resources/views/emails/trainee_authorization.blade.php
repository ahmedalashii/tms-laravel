<x-mail::message>
    # Hello {{ $trainee->displayName }},

    You have been authorized by {{ $manager->displayName }} to access the system. Please click the button below to
    login.

    Your ID is: {{ $trainee->auth_id }}

    Please keep this ID safe as you will need it to login.
    
    <x-mail::button :url="{{ route('trainee.login') }}" color="success">
        Login Now
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
