@extends('layouts.main')

@section('title', 'User Management | WokaCash')

@section('content')
    <div class="flex h-screen overflow-hidden flex-col">

        <div class="hero p-6">
            <div class="flex justify-between items-center mb-6">
                <div class="hidden lg:block">
                    <form>
                        <div class="relative">
                            <span class="absolute top-1/2 left-4 -translate-y-1/2">
                                <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z" />
                                </svg>
                            </span>

                            <input type="text" placeholder="Search incomes" id="search-input"
                                class="dark:bg-dark-900 shadow-sm focus:border-brand-300 focus:ring-brand-500/10 
                                                                                    h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 
                                                                                    text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 outline-none
                                                                                    xl:w-64 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-white/30" />
                        </div>
                    </form>
                </div>


                <button id="open-modal-button"
                    class="bg-brand-500 px-4 py-2 rounded-lg text-white text-sm shadow hover:bg-brand-600 transition">
                    Add Incomes
                </button>
            </div>

            <div id="add-income-modal-wrapper" class="hidden fixed inset-0 z-50 overflow-y-auto">
               
                <div id="add-income-modal-backdrop"
                    class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity duration-300 ease-in-out opacity-0">
                </div>
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div id="add-income-modal-content"
                        class="relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl border border-white/20 dark:border-gray-700/50 rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 ease-in-out opacity-0 scale-95 mx-auto">

                        <div
                            class="flex items-center justify-between p-6 border-b border-white/20 dark:border-gray-700/50 bg-white/20 dark:bg-gray-800/20 rounded-t-2xl">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Income</h3>
                            <button id="close-modal-button-header"
                                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200 bg-white/30 dark:bg-gray-700/30 hover:bg-white/50 dark:hover:bg-gray-600/50 rounded-full p-1">
                                <i class="bi bi-x-lg text-lg"></i>
                            </button>
                        </div>

                        <div class="p-6 max-h-[60vh] overflow-y-auto">
                            <form action="{{ route('staff.incomes.store') }}" method="POST" id="addIncomeForm">
                                @csrf

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Income Source
                                    </label>
                                    <select name="income_source" id="income_source"
                                        class="w-full border border-gray-300/50 dark:border-gray-600/50 bg-white/50 dark:bg-gray-700/50 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent dark:text-white backdrop-blur-sm">
                                        <option value="">Select Source</option>
                                        <option value="project">Project</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                    @error('income_source')
                                        <p class="text-error-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div id="projectField" class="mb-4 hidden">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Select Project
                                    </label>
                                    <select name="project_id" id="project_id"
                                        class="w-full border border-gray-300/50 dark:border-gray-600/50 bg-white/50 dark:bg-gray-700/50 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent dark:text-white backdrop-blur-sm">
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <p class="text-error-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div id="descriptionField" class="mb-4 hidden">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Description
                                    </label>
                                    <input type="text" name="description"
                                        class="w-full border border-gray-300/50 dark:border-gray-600/50 bg-white/50 dark:bg-gray-700/50 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent dark:text-white placeholder-gray-500 dark:placeholder-gray-400 backdrop-blur-sm"
                                        placeholder="Enter income description">
                                    @error('description')
                                        <p class="text-error-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Select Branch
                                    </label>
                                    <select name="branch_id"
                                        class="w-full border border-gray-300/50 dark:border-gray-600/50 bg-white/50 dark:bg-gray-700/50 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent dark:text-white backdrop-blur-sm">
                                        <option value="">Select Branch</option>
                                        @foreach($branchIds as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Amount
                                    </label>

                                    <div
                                        class="flex items-center rounded-xl overflow-hidden border border-gray-300/50 dark:border-gray-600/50 bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm">

                                        <!-- Prefix -->
                                        <span
                                            class="px-4 py-2.5 text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 text-sm">
                                            Rp
                                        </span>

                                        <!-- Input -->
                                        <input type="text" id="amount" name="amount"
                                            class="w-full py-2.5 px-3 bg-transparent focus:outline-none dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                                            oninput="formatRupiah(this)" required>
                                        @error('amount')
                                            <p class="text-error-500 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Date
                                    </label>
                                    <input type="date" name="date"
                                        class="w-full border border-gray-300/50 dark:border-gray-600/50 bg-white/50 dark:bg-gray-700/50 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent dark:text-white backdrop-blur-sm"
                                        value="{{ date('Y-m-d') }}" required>
                                    @error('date')
                                        <p class="text-error-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Notes (Optional)
                                    </label>
                                    <textarea name="notes" rows="3"
                                        class="w-full border border-gray-300/50 dark:border-gray-600/50 bg-white/50 dark:bg-gray-700/50 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent dark:text-white placeholder-gray-500 dark:placeholder-gray-400 backdrop-blur-sm"
                                        placeholder="Additional notes..."></textarea>
                                </div>
                            </form>
                        </div>

                        {{-- MODAL FOOTER WITH GLASS EFFECT - Enhanced submit button --}}
                        <div
                            class="flex justify-end gap-3 p-6 border-t border-white/20 dark:border-gray-700/50 bg-white/20 dark:bg-gray-800/20 rounded-b-2xl">
                            <button id="close-modal-button-footer" type="button"
                                class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white/60 dark:bg-gray-700/60 border border-white/30 dark:border-gray-600/50 rounded-xl hover:bg-white/80 dark:hover:bg-gray-600/80 focus:outline-none focus:ring-2 focus:ring-gray-400/50 backdrop-blur-sm transition-all duration-200">
                                Cancel
                            </button>
                            <button type="submit" form="addIncomeForm"
                                class="bg-brand-500 px-4 py-2 rounded-lg text-white text-sm shadow hover:bg-brand-600 transition">
                                Add Income
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full p-4 bg-white dark:bg-gray-900 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
                    Daftar Incomes
                </h2>

                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <th class="py-3 px-4 text-gray-600 dark:text-white">No</th>
                                <th class="py-3 px-4 text-gray-600 dark:text-white">Name</th>
                                <th class="py-3 px-4 text-gray-600 dark:text-white">Project</th>
                                <th class="py-3 px-4 text-gray-600 dark:text-white">Cabang Perusahaan</th>
                                <th class="py-3 px-4 text-gray-600 dark:text-white">Jumlah</th>
                                <th class="py-3 px-4 text-gray-600 dark:text-white">Deskripsi</th>
                                <th class="py-3 px-4 text-gray-600 dark:text-white">Tanggal</th>
                                <th class="py-3 px-4 text-gray-600 dark:text-white">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($Incomeslist as $no => $row)
                                <tr
                                    class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                    <td class="py-3 px-4 text-gray-700 dark:text-white">{{ $no + 1 }}</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-white flex items-center gap-3">
                                        {{ $row->user->name }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-white">{{ $row->project->name ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-white">{{ $row->branch->name ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-white"> Rp
                                        {{ number_format((int) $row->amount, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-white">{{ $row->description }}</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-white">
                                        {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                                    <td class="py-3 px-4 flex gap-3 justify-center items-center">
                                        <a href="{{ route('admin.user.edit', $row->id) }}"
                                            class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">Edit</a>
                                        <form id="delete-form-{{ $row->id }}"
                                            action="{{ route('admin.user.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="deleteUser({{ $row->id }})"
                                                class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-error-500 shadow-theme-xs hover:bg-brand-600">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-gray-700 dark:text-white py-4">
                                        <i class="bi bi-info-circle"></i> No incomes yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .modal-open-backdrop {
            opacity: 1;
        }

        .modal-open-content {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        /* Enhanced glass morphism effects */
        #add-income-modal-content {
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.8) 0%,
                    rgba(255, 255, 255, 0.6) 100%);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.25),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.2),
                inset 0 -1px 0 0 rgba(0, 0, 0, 0.1);
        }

        .dark #add-income-modal-content {
            background: linear-gradient(135deg,
                    rgba(31, 41, 55, 0.8) 0%,
                    rgba(31, 41, 55, 0.6) 100%);
            border: 1px solid rgba(55, 65, 81, 0.5);
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.1),
                inset 0 -1px 0 0 rgba(0, 0, 0, 0.3);
        }

        /* Smooth scrolling for modal content */
        #add-income-modal-content>div:last-child {
            scrollbar-width: thin;
            scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
        }

        #add-income-modal-content>div:last-child::-webkit-scrollbar {
            width: 6px;
        }

        #add-income-modal-content>div:last-child::-webkit-scrollbar-track {
            background: transparent;
        }

        #add-income-modal-content>div:last-child::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5);
            border-radius: 3px;
        }

        #add-income-modal-content>div:last-child::-webkit-scrollbar-thumb:hover {
            background-color: rgba(107, 114, 128, 0.7);
        }

        /* Dark mode scrollbar */
        .dark #add-income-modal-content>div:last-child::-webkit-scrollbar-thumb {
            background-color: rgba(75, 85, 99, 0.5);
        }

        .dark #add-income-modal-content>div:last-child::-webkit-scrollbar-thumb:hover {
            background-color: rgba(107, 114, 128, 0.7);
        }

        /* Input focus effects for glass morphism */
        input:focus,
        select:focus,
        textarea:focus {
            background: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(10px) !important;
        }

        .dark input:focus,
        .dark select:focus,
        .dark textarea:focus {
            background: rgba(55, 65, 81, 0.7) !important;
        }
    </style>

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

        document.addEventListener('DOMContentLoaded', function () {
            // Modal Elements
            const modalWrapper = document.getElementById('add-income-modal-wrapper');
            const modalBackdrop = document.getElementById('add-income-modal-backdrop');
            const modalContent = document.getElementById('add-income-modal-content');
            const openButton = document.getElementById('open-modal-button');
            const closeButtonHeader = document.getElementById('close-modal-button-header');
            const closeButtonFooter = document.getElementById('close-modal-button-footer');

            // Form Elements
            const incomeSource = document.getElementById('income_source');
            const projectField = document.getElementById('projectField');
            const descriptionField = document.getElementById('descriptionField');
            const form = document.getElementById('addIncomeForm');

            // Open Modal Function
            function openModal() {
                modalWrapper.classList.remove('hidden');

                // Trigger reflow
                modalWrapper.offsetHeight;

                // Add open classes with slight delay for transition
                setTimeout(() => {
                    modalBackdrop.classList.add('modal-open-backdrop');
                    modalContent.classList.add('modal-open-content');
                }, 10);

                // Prevent body scroll
                document.body.style.overflow = 'hidden';
            }

            // Close Modal Function
            function closeModal() {
                // Remove open classes
                modalBackdrop.classList.remove('modal-open-backdrop');
                modalContent.classList.remove('modal-open-content');

                // Wait for transition to complete before hiding
                setTimeout(() => {
                    modalWrapper.classList.add('hidden');
                    document.body.style.overflow = '';
                }, 300);
            }

            // Event Listeners for Modal
            openButton.addEventListener('click', openModal);
            closeButtonHeader.addEventListener('click', closeModal);
            closeButtonFooter.addEventListener('click', closeModal);

            // Close modal when clicking on backdrop
            modalWrapper.addEventListener('click', function (e) {
                if (e.target === modalWrapper || e.target === modalBackdrop) {
                    closeModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !modalWrapper.classList.contains('hidden')) {
                    closeModal();
                }
            });

            // Dynamic Form Fields
            incomeSource.addEventListener('change', function () {
                projectField.classList.add('hidden');
                descriptionField.classList.add('hidden');

                if (this.value === 'project') {
                    projectField.classList.remove('hidden');
                } else if (this.value === 'other') {
                    descriptionField.classList.remove('hidden');
                }
            });

            // Form Validation
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

            // Helper function for alerts
            function showAlert(message, type = 'error') {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: type,
                        title: type === 'error' ? 'Error!' : 'Success!',
                        text: message,
                        confirmButtonColor: type === 'error' ? '#ef4444' : '#4f46e5',
                        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                        color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
                        customClass: {
                            popup: 'rounded-xl shadow-lg'
                        }
                    });
                } else {
                    alert(message);
                }
            }
        });

        function deleteUser(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
                customClass: {
                    popup: 'rounded-xl shadow-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                confirmButtonColor: '#4f46e5',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
                customClass: {
                    popup: 'rounded-xl shadow-lg'
                }
            })
        </script>
    @elseif (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#ef4444',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
                customClass: {
                    popup: 'rounded-xl shadow-lg animate__animated animate__shakeX',
                    confirmButton: 'rounded-lg px-4 py-2'
                }
            })
        </script>
    @endif
@endsection