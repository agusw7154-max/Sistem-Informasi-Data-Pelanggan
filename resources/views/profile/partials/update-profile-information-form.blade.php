<div class="card border-0">
    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <h5 class="mb-0 text-white">
            <i class="fas fa-user-circle me-2"></i> {{ __('Profile Information') }}
        </h5>
    </div>

    <div class="card-body">
        <p class="text-muted mb-4">
            {{ __("Update your account's profile information and email address.") }}
        </p>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-3">
                        <div class="alert alert-warning" role="alert">
                            <small>{{ __('Your email address is unverified.') }}</small>
                            <button type="submit" form="send-verification" class="btn btn-link btn-sm p-0 ms-1">{{ __('Click here to re-send the verification email.') }}</button>
                        </div>

                        @if (session('status') === 'verification-link-sent')
                            <div class="alert alert-success" role="alert">
                                <small>{{ __('A new verification link has been sent to your email address.') }}</small>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="d-flex gap-2 align-items-center">
                <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                    <i class="fas fa-save me-2"></i>{{ __('Save') }}
                </button>

                @if (session('status') === 'profile-updated')
                    <span class="alert alert-success mb-0 py-2" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ __('Saved.') }}
                    </span>
                @endif
            </div>
        </form>
    </div>
</div>
