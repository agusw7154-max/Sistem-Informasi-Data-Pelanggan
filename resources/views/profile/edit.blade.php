<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center gap-3">
            <i class="fas fa-user-cog" style="font-size: 1.8rem; color: white;"></i>
            <div>
                <h1 class="mb-0" style="color: white;">{{ __('Profile Settings') }}</h1>
                <small style="color: rgba(255,255,255,0.8);">{{ __('Manage your account settings and preferences') }}</small>
            </div>
        </div>
    </x-slot>

    <div class="row mt-4">
        <div class="col-lg-8 mx-auto">
            <div class="mb-4">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="mb-4">
                @include('profile.partials.update-password-form')
            </div>

            <div class="mb-4">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
