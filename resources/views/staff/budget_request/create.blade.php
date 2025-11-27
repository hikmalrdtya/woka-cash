@extends('layouts.main')

@section('title', 'Branch Create | WokaCash')

@section('content')
    <style>
        /* DARK MODE FIX untuk TomSelect */
        .dark .ts-control,
        .dark .ts-dropdown {
            background-color: #1f2937 !important;
            /* gray-800 */
            color: white !important;
            border: 1px 1px solid #374151;
        }

        .dark .ts-dropdown .option {
            background-color: #1f2937 !important;
            color: white !important;
        }

        .dark .ts-dropdown .option:hover {
            background-color: #374151 !important;
            /* gray-700 */
        }
    </style>

    <!-- ===== Page Wrapper Start ===== -->
    <div class="px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mt-5 flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Create Branch</h2>

            <a href="{{ route('staff.budget_requests.index') }}"
                class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white px-4 py-2 rounded-lg transition">
                ← Back
            </a>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6">

            <form id="userCreateForm" action="{{ route('staff.budget_requests.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <!-- GRID 2 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- CABANG --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Cabang Perusahaan
                        </label>
                        <select name="branch_id"
                            class="w-full border border-gray-300/50 dark:border-gray-600/50 bg-white/50 dark:bg-gray-700/50 rounded-xl px-3 py-2.5 dark:text-white">
                            <option value="">Pilih Cabang</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                        @error('branch_id') <p class="text-error-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    {{-- TITLE --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Judul Pengeluaran
                        </label>
                        <input type="text" name="title"
                            class="w-full border border-gray-300/50 dark:border-gray-600/50 bg-white/50 dark:bg-gray-700/50 rounded-xl px-3 py-2.5 dark:text-white">
                        @error('title') <p class="text-error-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    {{-- AMOUNT --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jumlah Pengeluaran
                        </label>

                        <div
                            class="flex items-center rounded-xl overflow-hidden border border-gray-300/50 dark:border-gray-600/50 bg-white/50 dark:bg-gray-700/50">
                            <span class="px-4 py-2.5 text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 text-sm">
                                Rp
                            </span>
                            <input type="text" name="amount" id="amount"
                                class="w-full py-2.5 px-3 bg-transparent focus:outline-none dark:text-white"
                                oninput="formatRupiah(this)">
                        </div>
                        @error('amount') <p class="text-error-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    {{-- NOTE --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Catatan
                        </label>
                        <textarea name="note" rows="3"
                            class="w-full border border-gray-300/50 dark:border-gray-600/50 bg-white/50 dark:bg-gray-700/50 rounded-xl px-3 py-2.5 dark:text-white"></textarea>
                        @error('note') <p class="text-error-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal Pengajuan (auto today) --}}
                    <input type="hidden" name="date_submission" value="{{ date('Y-m-d') }}">
                </div>

                <!-- BUTTON -->
                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-brand-500 hover:bg-blue-700 text-white  px-4 py-2 rounded-lg shadow transition 
                            focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-600">
                        Create Branch
                    </button>
                </div>

            </form>
        </div>

    </div>

    <!-- SCRIPT PREVIEW -->
    <script>
        const dropdownButton = document.getElementById("dropdownButton");
        const dropdownMenu = document.getElementById("dropdownMenu");
        const searchUser = document.getElementById("searchUser");
        const userList = document.getElementById("userList");
        const noUserFound = document.getElementById("noUserFound");
        const selectedUser = document.getElementById("selectedUser");
        const userInput = document.getElementById("userInput");

        // Toggle dropdown
        dropdownButton.addEventListener("click", () => {
            dropdownMenu.classList.toggle("hidden");
            searchUser.focus();
        });

        // Filter user
        searchUser.addEventListener("input", () => {
            const keyword = searchUser.value.toLowerCase();
            let found = false;

            userList.querySelectorAll("li").forEach((li) => {
                const name = li.dataset.name;
                if (name.includes(keyword)) {
                    li.classList.remove("hidden");
                    found = true;
                } else {
                    li.classList.add("hidden");
                }
            });

            // Tampilkan atau sembunyikan pesan not found
            if (!found) {
                noUserFound.classList.remove("hidden");
            } else {
                noUserFound.classList.add("hidden");
            }
        });

        // Pilih user
        userList.querySelectorAll("li").forEach((li) => {
            li.addEventListener("click", () => {
                selectedUser.textContent = li.dataset.name;
                userInput.value = li.dataset.id;
                dropdownMenu.classList.add("hidden");
            });
        });

        // Klik luar → tutup dropdown
        document.addEventListener("click", (e) => {
            if (!dropdownMenu.contains(e.target) && !dropdownButton.contains(e.target)) {
                dropdownMenu.classList.add("hidden");
            }
        });

        const passwordField = document.querySelector("[name=password]");
        const invalidPassword = document.getElementById("invalid-password");

        passwordField.addEventListener("keyup", () => {
            const value = passwordField.value.trim();

            if (value === "") {
                invalidPassword.classList.add("hidden");
                return;
            }

            if (!passwordField.validity.valid) {
                invalidPassword.classList.remove("hidden");
            } else {
                invalidPassword.classList.add("hidden");
            }
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