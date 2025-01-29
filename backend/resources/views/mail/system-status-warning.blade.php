<x-mail::message>
    # System Status Warning

    The system has detected some issues that require your attention.
    Please review the warnings listed below and take appropriate action to ensure the smooth operation of your application.

    @foreach ($warnings as $warning)
    - {{ $warning }}
    @endforeach
</x-mail::message>
