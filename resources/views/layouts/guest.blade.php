<x-app-layout>
    <div class="container py-3">
        <div class="container py-3">
            <div class="mb-4 text-muted">
                {{ __('verification_message') }}
            </div>
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 alert alert-success">
                    {{ __('verification_success') }}
                </div>
            @endif
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        {{ __('resend_button') }}
                    </button>
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link text-decoration-none">
                        {{ __('logout_button') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>