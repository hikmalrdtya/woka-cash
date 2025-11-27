@extends('layouts.main')

@section('title', 'Branch User Create | WokaCash')

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
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Create Branch User</h2>

            <a href="{{ route('admin.branchUser.index') }}"
                class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white px-4 py-2 rounded-lg transition">
                ← Back
            </a>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6">

            <form id="userCreateForm" action="{{ route('admin.branchUser.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <!-- GRID 2 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Branches -->
                    <div class="relative w-full fake-select" data-select="branch">
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Select Branch</label>
                        <button type="button"
                            class="dropdownButton
        w-full h-11 px-4 rounded-lg border border-gray-300 dark:border-gray-700 
        bg-white dark:bg-gray-800 text-gray-800 dark:text-white flex justify-between items-center">
                            <span class="selectedText">Select Branch</span>
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <input type="hidden" name="branch" class="realInput">

                        <div
                            class="dropdownMenu hidden absolute z-30 mt-2 w-full p-3 rounded-lg border border-gray-300 
        dark:border-gray-700 dark:bg-gray-800 shadow-lg">

                            <input
                                class="searchInput w-full h-10 px-3 mb-3 rounded-md border border-gray-300 dark:border-gray-700 
            bg-white dark:bg-gray-900 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-white/30"
                                placeholder="Search branch..." />

                            <ul class="itemList max-h-60 overflow-y-auto">
                                @foreach ($branches as $branch)
                                    <li data-id="{{ $branch->id }}" data-name="{{ strtolower($branch->name) }}"
                                        class="p-2 rounded-md cursor-pointer bg-white dark:bg-gray-800 
                    hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-800 dark:text-white">
                                        {{ $branch->name }}
                                    </li>
                                @endforeach
                            </ul>

                            <p class="notFound hidden text-error-500 text-sm px-2">Branch not found</p>
                        </div>
                    </div>

                    <!-- Users -->
                    <div class="relative w-full fake-select" data-select="user">
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Select Staff</label>
                        <button type="button"
                            class="dropdownButton
        w-full h-11 px-4 rounded-lg border border-gray-300 dark:border-gray-700 
        bg-white dark:bg-gray-800 text-gray-800 dark:text-white flex justify-between items-center">
                            <span class="selectedText">Select User</span>
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <input type="hidden" name="user" class="realInput">

                        <div
                            class="dropdownMenu hidden absolute z-30 mt-2 w-full p-3 rounded-lg border border-gray-300 
        dark:border-gray-700 dark:bg-gray-800 shadow-lg">

                            <input
                                class="searchInput w-full h-10 px-3 mb-3 rounded-md border border-gray-300 dark:border-gray-700 
            bg-white dark:bg-gray-900 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-white/30"
                                placeholder="Search user..." />

                            <ul class="itemList max-h-60 overflow-y-auto">
                                @foreach ($users as $user)
                                    <li data-id="{{ $user->id }}" data-name="{{ strtolower($user->name) }}"
                                        class="p-2 rounded-md cursor-pointer bg-white dark:bg-gray-800 
                    hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-800 dark:text-white">
                                        {{ $user->name }}
                                    </li>
                                @endforeach
                            </ul>

                            <p class="notFound hidden text-error-500 text-sm px-2">User not found</p>
                        </div>
                    </div>

                    <!-- Role in Branch -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Role in Branch</label>
                        <input value="{{ old('role_in_branch') }}" type="text" name="role_in_branch"
                            class="w-full h-11 px-4 rounded-lg border border-gray-300 dark:border-gray-700 
                            bg-white dark:bg-gray-800 text-gray-800 dark:text-white 
                            placeholder-gray-400 dark:placeholder-white/30
                            focus:ring-2 focus:ring-brand-400 focus:border-brand-500 outline-none">

                        @error('role_in_branch')
                            <p class="text-error-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- BUTTON -->
                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="bg-brand-500 hover:bg-blue-700 text-white  px-4 py-2 rounded-lg shadow transition 
                        focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-600">
                            Create Branch User
                        </button>
                    </div>

            </form>
        </div>

    </div>

    <!-- SCRIPT PREVIEW -->
    <script>
        document.querySelectorAll(".fake-select").forEach(select => {

            const btn = select.querySelector(".dropdownButton");
            const menu = select.querySelector(".dropdownMenu");
            const search = select.querySelector(".searchInput");
            const itemList = select.querySelector(".itemList");
            const selectedText = select.querySelector(".selectedText");
            const realInput = select.querySelector(".realInput");
            const notFound = select.querySelector(".notFound");

            // Toggle dropdown
            btn.addEventListener("click", () => {
                menu.classList.toggle("hidden");
                search.focus();
            });

            // Search filter
            search.addEventListener("input", () => {
                const keyword = search.value.toLowerCase();
                let found = false;

                itemList.querySelectorAll("li").forEach(li => {
                    const name = li.dataset.name;
                    if (name.includes(keyword)) {
                        li.classList.remove("hidden");
                        found = true;
                    } else {
                        li.classList.add("hidden");
                    }
                });

                notFound.classList.toggle("hidden", found);
            });

            // Select item
            itemList.querySelectorAll("li").forEach(li => {
                li.addEventListener("click", () => {
                    selectedText.textContent = li.textContent.trim();
                    realInput.value = li.dataset.id;
                    menu.classList.add("hidden");
                });
            });

            // Close when click outside
            document.addEventListener("click", e => {
                if (!select.contains(e.target)) {
                    menu.classList.add("hidden");
                }
            });
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
