<section>
    <header class="mb-3">
        <h2 class="section-title">Perbarui Kata Sandi</h2>
        <p class="text-muted small">
            Gunakan kata sandi panjang dan acak untuk menjaga keamanan akun Anda.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" style="max-width: 600px;">
        @csrf
        @method('put')

        {{-- Password Saat Ini --}}
        <div class="form-group mb-3">
            <label for="update_password_current_password" class="font-weight-bold text-dark mb-1">Kata Sandi Saat Ini</label>
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="form-control form-control-sm"
                autocomplete="current-password" />
            <x-input-error class="text-danger small mt-1" :messages="$errors->updatePassword->get('current_password')" />
        </div>

        {{-- Password Baru --}}
        <div class="form-group mb-3">
            <label for="update_password_password" class="font-weight-bold text-dark mb-1">Kata Sandi Baru</label>
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                class="form-control form-control-sm"
                autocomplete="new-password" />
            <x-input-error class="text-danger small mt-1" :messages="$errors->updatePassword->get('password')" />
        </div>

        {{-- Konfirmasi Password --}}
        <div class="form-group mb-3">
            <label for="update_password_password_confirmation" class="font-weight-bold text-dark mb-1">Konfirmasi Kata Sandi</label>
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-control form-control-sm"
                autocomplete="new-password" />
            <x-input-error class="text-danger small mt-1" :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        {{-- Tombol Simpan --}}
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>

            @if (session('status') === 'password-updated')
                <span
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-success small"
                >Kata sandi berhasil diperbarui.</span>
            @endif
        </div>
    </form>
</section>
