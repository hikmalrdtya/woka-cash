@extends('layouts.main')

@section('title', 'Branch Create | WokaCash')

@section('content')
    <style>
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
        <div class="mt-5 mb-4 flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Update Income</h2>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-gray-900 rounded-xl mt-4 shadow p-6">

            <form action="{{ route('staff.incomes.update', $income->id) }}" method="POST" id="addIncomeForm">
                @csrf
                @method('PUT')

                <!-- GRID 2 -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Income Source
                    </label>

                    <select id="income_source" disabled
                        class="w-full border border-gray-300/50 dark:border-gray-600/50 bg-white/50 dark:bg-gray-700/50 rounded-xl px-3 py-2.5 dark:text-white">
                        <option value="">Select Source</option>
                        <option value="project" {{ $income->project_id ? 'selected' : '' }}>Project</option>
                        <option value="other" {{ !$income->project_id ? 'selected' : '' }}>Lainnya</option>
                    </select>

                    <input type="hidden" name="income_source" value="{{ $income->project_id ? 'project' : 'other' }}">

                    @error('income_source')
                        <p class="text-error-500 text-sm">{{ $message }}</p>
                    @enderror

                    {{-- PROJECT FIELD --}}
                    <div id="projectField" class="mb-4 {{ $income->project_id ? '' : 'hidden' }}">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Select Project
                        </label>

                        <select name="project_id" id="project_id" disabled
                            class="w-full border border-gray-300/50 dark:border-gray-600/50 rounded-xl px-3 py-2.5 bg-white dark:bg-gray-700 dark:text-white">
                            <option value="">Select Project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" {{ $income->project_id == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>

                        <input type="hidden" name="project_id" value="{{ $income->project_id }}">

                    </div>


                    {{-- DESCRIPTION FIELD --}}
                    <div id="descriptionField" class="mb-4 {{ $income->project_id ? 'hidden' : '' }}">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea
                            class="w-full border border-gray-300/50 dark:border-gray-600/50 rounded-xl px-3 py-2.5 bg-white dark:bg-gray-700 dark:text-white"
                            name="description">{{ $income->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Amount
                        </label>

                        <div
                            class="flex items-center rounded-xl overflow-hidden border border-gray-300/50 dark:border-gray-600/50 bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm">

                            <!-- Prefix -->
                            <span class="px-4 py-2.5 text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 text-sm">
                                Rp
                            </span>

                            <!-- Input -->
                            <input type="text" id="amount" name="amount"
                                value="{{ number_format($income->amount, 0, ',', '.') }}"
                                class="w-full py-2.5 px-3 bg-transparent focus:outline-none dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                                oninput="formatRupiah(this)">
                            @error('amount')
                                <p class="text-error-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <div class="mt-8 flex justify-end gap-2">
                        <a href="{{ route('staff.incomes.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 text-white px-4 py-2 rounded-lg shadow transition 
                                                                                                                                                    focus:ring-2">
                            ← Back
                        </a>
                        <button type="submit"
                            class="bg-brand-500 hover:bg-blue-700 text-white  px-4 py-2 rounded-lg shadow transition 
                                                                                                                                                    focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-600">
                            Update Income
                        </button>
                    </div>

            </form>
        </div>

    </div>

    <script>
        function formatRupiah(el) {
            let value = el.value.replace(/[^0-9]/g, ""); // hanya angka

            if (!value) {
                el.value = "";
                return;
            }

            // format angka dengan locale Indonesia
            let formatted = new Intl.NumberFormat("id-ID").format(value);

            el.value = formatted;
        }


        // Form Elements
        const incomeSourceSelect = document.getElementById("income_source");
        const projectField = document.getElementById("projectField");
        const descriptionField = document.getElementById("descriptionField");
        const projectSelect = document.getElementById("project_id");
        const form = document.getElementById('addIncomeForm');

        const dropdownButton = document.getElementById("dropdownButton");
        const dropdownMenu = document.getElementById("dropdownMenu");
        const searchUser = document.getElementById("searchUser");
        const userList = document.getElementById("userList");
        const noUserFound = document.getElementById("noUserFound");
        const selectedUser = document.getElementById("selectedUser");
        const userInput = document.getElementById("userInput");

        function toggleIncomeSource() {
            const source = incomeSourceSelect.value;

            if (source === "project") {
                projectField.classList.remove("hidden");
                descriptionField.classList.add("hidden");

                // Jika user memilih project, hilangkan description
                document.querySelector('input[name="description"]').value = "";
            } else if (source === "other") {
                projectField.classList.add("hidden");
                descriptionField.classList.remove("hidden");

                // Jika user memilih other, hilangkan project
                projectSelect.value = "";
            } else {
                projectField.classList.add("hidden");
                descriptionField.classList.add("hidden");
            }
        }

        // Ketika user mengganti Income Source
        incomeSourceSelect.addEventListener("change", toggleIncomeSource);

        // Trigger saat halaman pertama kali dibuka (edit page)
        document.addEventListener("DOMContentLoaded", toggleIncomeSource);

        form.addEventListener('submit', function (e) {
            const incomeSourceValue = incomeSource.value;
            const projectId = form.querySelector('select[name="project_id"]').value;
            const description = form.querySelector('input[name="description"]').value;
            const branchId = form.querySelector('select[name="branch_id"]').value;
            const amount = form.querySelector('input[name="amount"]').value;

            if (!incomeSourceValue) {
                e.preventDefault();
                showAlert('Please select income source', 'error');
                return;
            }

            if (incomeSourceValue === 'project' && !projectId) {
                e.preventDefault();
                showAlert('Please select a project', 'error');
                return;
            }

            if (incomeSourceValue === 'other' && !description) {
                e.preventDefault();
                showAlert('Please enter description', 'error');
                return;
            }

            if (!branchId) {
                e.preventDefault();
                showAlert('Please select a branch', 'error');
                return;
            }

            if (!amount || parseFloat(amount) <= 0) {
                e.preventDefault();
                showAlert('Please enter a valid amount', 'error');
                return;
            }
        });

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