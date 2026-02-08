<x-guest-layout>
    <h4 class="mb-3">Verify Email</h4>
    <p class="text-muted">Thanks for registering! Please verify your email address.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">A new verification link has been sent to your email.</div>
    @endif

    <div class="d-flex gap-2">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Resend Verification Email</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary">Log Out</button>
        </form>
    </div>
</x-guest-layout>
