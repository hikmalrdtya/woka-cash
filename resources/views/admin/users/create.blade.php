@extends('layouts.main')

@section('title', 'User Create | WokaCash')

@section('content')

    <!-- ===== Page Wrapper Start ===== -->
    <div class="px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mt-5 mb-4 flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Create User</h2>

            <a href="{{ route('admin.user.index') }}"
                class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white px-4 py-2 rounded-lg transition">
                ← Back
            </a>
        </div>

        <!-- Card -->
        <div class="bg-white mt-5 dark:bg-gray-900 rounded-xl shadow p-6">

            <form id="userCreateForm" action="{{ route('admin.user.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <!-- GRID 2 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- NAME -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Name</label>
                        <input value="{{ old('name') }}" type="text" name="name"
                            class="w-full h-11 px-4 rounded-lg border border-gray-300 dark:border-gray-700 
                            bg-white dark:bg-gray-800 text-gray-800 dark:text-white 
                            placeholder-gray-400 dark:placeholder-white/30
                            focus:ring-2 focus:ring-brand-400 focus:border-brand-500 outline-none"
                            required>
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Email</label>
                        <input value="{{ old('email') }}" type="email" name="email"
                            class="w-full h-11 px-4 rounded-lg border border-gray-300 dark:border-gray-700 
                            bg-white dark:bg-gray-800 text-gray-800 dark:text-white 
                            placeholder-gray-400 dark:placeholder-white/30
                            focus:ring-2 focus:ring-brand-400 focus:border-brand-500 outline-none"
                            required>

                        @error('email')
                            <p class="text-error-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ROLE -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Role</label>
                        <select name="role"
                            class="w-full h-11 px-4 rounded-lg border border-gray-300 dark:border-gray-700 
                            bg-white dark:bg-gray-800 text-gray-800 dark:text-white 
                            focus:ring-2 focus:ring-brand-400 focus:border-brand-500 outline-none"
                            required>
                            <option value="" class="dark:bg-gray-800">-- Select Role --</option>
                            <option value="admin">Admin</option>
                            <option value="finance">Finance</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>

                </div>

                <!-- PASSWORD -->
                <div class="mt-6">
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Password</label>
                    <input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        class="w-full h-11 px-4 rounded-lg border border-gray-300 dark:border-gray-700 
                        bg-white dark:bg-gray-800 text-gray-800 dark:text-white 
                        placeholder-gray-400 dark:placeholder-white/30
                        focus:ring-2 focus:ring-brand-400 focus:border-brand-500 outline-none"
                        required>
                    <p id="invalid-password" class="text-error-500 hidden">The password must be at least 8 characters
                        long and mustcontain uppercase letters, numbers, and symbols.</p>
                    @error('password')
                        <p class="text-error-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PHOTO PROFILE -->
                <div class="mt-6">
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">
                        Photo Profile
                    </label>

                    <!-- Wrapper -->
                    <div class="flex items-center gap-4">

                        <!-- Preview -->
                        <div class="w-20 h-20 rounded-full overflow-hidden border border-brand-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800"
                            id="preview-wrapper">
                            <img id="preview-image" src="" alt=""
                                class="w-full h-full object-cover hidden">
                        </div>

                        <!-- Input File -->
                        <label
                            class="cursor-pointer px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 
            dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            Upload Photo
                            <input type="file" name="photo_profile" accept="image/*" class="hidden"
                                onchange="previewPhoto(event)">
                        </label>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="bg-brand-500 hover:bg-blue-700 text-white  px-4 py-2 rounded-lg shadow transition 
                        focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-600">
                        Create User
                    </button>
                </div>

            </form>
        </div>

    </div>

    <!-- SCRIPT PREVIEW -->
    <script>
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
