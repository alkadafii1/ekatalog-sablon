<section>
    <header class="mb-3">
        <h2 class="section-title">Informasi Profil</h2>
        <p class="text-muted small">Perbarui nama dan alamat email akun Anda.</p>
    </header>

    {{-- Form untuk verifikasi ulang email --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="max-width: 600px;">
        @csrf
        @method('patch')

        {{-- Nama --}}
        <div class="form-group mb-3">
            <label for="name" class="font-weight-semibold text-dark mb-1">Nama</label>
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="form-control form-control-sm"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name" />
            <x-input-error class="text-danger small mt-1" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div class="form-group mb-3">
            <label for="email" class="font-weight-semibold text-dark mb-1">Email</label>
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="form-control form-control-sm"
                :value="old('email', $user->email)"
                required
                autocomplete="username" />
            <x-input-error class="text-danger small mt-1" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <small class="text-warning">
                        Alamat email Anda belum diverifikasi. 
                        <button form="send-verification" class="btn btn-link p-0 align-baseline">
                            Klik di sini untuk mengirim ulang email verifikasi.
                        </button>
                    </small>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success mt-1 mb-0 small">
                            Link verifikasi baru telah dikirim ke email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Tombol Simpan --}}
        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary btn-sm">
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
                <span
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-success small"
                >Tersimpan.</span>
            @endif
        </div>
    </form>
</section>
