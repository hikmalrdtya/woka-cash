@extends('layouts.main')

@section('title', 'Profil Admin')

@section('content')
    <section class="py-10">

        {{-- Alert Sukses --}}
        @if (session('success'))
            <div id="alert-success"
                class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow mb-4 text-sm flex items-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- Alert Error --}}
        @if ($errors->any())
            <div id="alert-danger"
                class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg shadow mb-4 text-sm flex items-center">
                {{ $errors->first() }}
            </div>
        @endif

        <script>
            setTimeout(() => {
                document.getElementById('alert-success')?.remove();
                document.getElementById('alert-danger')?.remove();
            }, 3000);
        </script>

        {{-- Card --}}
        <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">

            {{-- Form --}}
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <br><br>
                    {{-- FOTO ADMIN --}}
                    <div class="flex flex-col items-center text-center">
                        <div class="relative w-32 h-32">
                            <!-- Foto -->
                            @if ($admin->photo_profile)
                                <!-- Preview -->
                                <div class="w-20 h-20 rounded-full overflow-hidden border border-brand-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800"
                                    id="preview-wrapper">
                                    <img id="preview-image" src="{{ asset('storage/' . $admin->photo_profile) }}"
                                        class="w-32 h-32 rounded-full object-cover border-[5px] border-blue-300 shadow-lg"
                                        width="100">
                                </div>
                            @else
                                <div
                                    class="w-30 h-30 rounded-full bg-gray-300 flex items-center justify-center border-[5px] border-blue-300 shadow-lg">
                                    <img id="preview-image" src="{{ asset('asset/profile.jpg') }}"
                                        class="w-32 h-32 rounded-full object-cover border-[5px] border-blue-300 shadow-lg"
                                        width="100">
                                </div>
                            @endif

                            <!-- Ikon kamera -->
                            <label for="foto"
                                class="absolute bottom-0 right-0 bg-white p-1 rounded-full shadow-lg border-2 border-gray-800 cursor-pointer">

                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M10 12.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 3h-2l-.447-.894A2 2 0 0 0 12.764 1H7.236a2 2 0 0 0-1.789 1.106L5 3H3a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V5a2 2 0 0 0-2-2Z" />
                                </svg>
                            </label>

                            <input type="file" id="foto" name="foto" class="hidden" accept="image/*"
                                onchange="previewPhoto(event)">
                        </div>

                        <p class="text-gray-500 text-sm mt-2">Klik ikon kamera untuk mengganti foto</p>
                    </div>

                    {{-- Username --}}
                    <div>
                        <label class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Username</label>
                        <input type="text" name="name"
                            class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 shadow-sm"
                            value="{{ $admin->name }}" required>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email"
                            class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 shadow-sm"
                            value="{{ $admin->email }}" required>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Password (Opsional)</label>
                        <input type="password" name="password"
                            class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 shadow-sm"
                            placeholder="Kosongkan jika tidak ingin mengubah password">
                    </div>

                    {{-- SIMPAN PERUBAHAN --}}
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center gap-2 bg-gray-500 text-sm font-medium items px-4 rounded-lg text-white py-2">Back</a>
                        <button
                            class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-gray-600">
                            Simpan Perubahan
                        </button>
                    </div>

                </div>

            </form>

        </div>

        <!-- Modal Crop -->
        <div id="cropModal" class="fixed inset-0 hidden items-center justify-center bg-black/70 backdrop-blur-sm z-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-2xl w-[90%] max-w-sm animate-scaleIn">

                <h2 class="text-center text-lg font-semibold text-gray-800 dark:text-white mb-4">
                    Sesuaikan Foto Profil
                </h2>

                <!-- Container Croppie -->
                <div id="croppieContainer" class="flex justify-center"></div>

                <div class="mt-5 flex justify-end gap-3">
                    <button id="cancelCrop"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition">
                        Batal
                    </button>

                    <button id="cropImageBtn"
                        class="px-4 py-2 bg-brand-500 hover:bg-brand-700 text-white rounded-lg transition">
                        Crop & Simpan
                    </button>
                </div>
            </div>
        </div>

        <!-- Animasi -->

    </section>

    <style>
        @keyframes scaleIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-scaleIn {
            animation: scaleIn .2s ease-out;
        }

        /* Biar crop bulat */
        .croppie-container .cr-viewport {
            border-radius: 50% !important;
        }
    </style>


    <script>
        let croppieInstance = null;
        const fotoInput = document.getElementById("foto");
        const cropModal = document.getElementById("cropModal");
        const croppieContainer = document.getElementById("croppieContainer");
        const previewImage = document.getElementById("preview-image");

        // === Saat pilih foto baru ===
        fotoInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {

                // Hancurkan Croppie lama
                if (croppieInstance) {
                    croppieInstance.destroy();
                    croppieInstance = null;
                }

                croppieContainer.innerHTML = ""; // Reset container

                // Buat Croppie baru
                croppieInstance = new Croppie(croppieContainer, {
                    viewport: { width: 220, height: 220, type: "circle" },
                    boundary: { width: 260, height: 260 },
                    enableZoom: true,
                    enableOrientation: true
                });

                croppieInstance.bind({
                    url: e.target.result
                });

                // Munculkan modal
                cropModal.classList.remove("hidden");
                cropModal.classList.add("flex");
            };
            reader.readAsDataURL(file);
        });

        // === Tombol Batal ===
        document.getElementById("cancelCrop").addEventListener("click", function () {
            cropModal.classList.add("hidden");
            fotoInput.value = ""; // Reset input supaya bisa pilih file yang sama berkali-kali
        });

        // === Tombol Crop ===
        document.getElementById("cropImageBtn").addEventListener("click", function () {
            if (!croppieInstance) return;

            croppieInstance.result({
                type: "base64",
                format: "png",
                size: { width: 450, height: 450 }
            })
                .then(function (base64) {

                    // === DI SINI BARU PREVIEW DIUBAH ===
                    previewImage.src = base64;

                    // Convert base64 → file untuk dikirim di form
                    fetch(base64)
                        .then(r => r.blob())
                        .then(blob => {
                            const croppedFile = new File([blob], "profile.png", { type: "image/png" });

                            const dt = new DataTransfer();
                            dt.items.add(croppedFile);
                            fotoInput.files = dt.files; // kirim lewat form
                        });

                    // Tutup modal
                    cropModal.classList.add("hidden");
                });
        });

        function previewPhoto(event) {
            const file = event.target.files[0];
            if (!file) return;

            const img = document.getElementById('preview-image');
            const wrapper = document.getElementById('preview-wrapper');

            img.src = URL.createObjectURL(file);
            img.classList.remove('hidden');
            wrapper.classList.add('border-brand-500');
        }
    </script>

@endsection