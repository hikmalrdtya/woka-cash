@extends('layouts.main')

@section('title', 'Expanses Create | WokaCash')

@section('content')
    <style>
        .dark .ts-control,
        .dark .ts-dropdown {
            background-color: #1f2937 !important;
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
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Create Expanses</h2>

            <a href="{{ route('finance.expenses.index') }}"
                class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white px-4 py-2 rounded-lg transition">
                ← Back
            </a>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-gray-900 rounded-xl mt-4 shadow p-6">

            <form id="userCreateForm" action="{{ route('finance.expenses.store') }}" method="POST"
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

                    {{-- FILE --}}
                    <div>
                        <label class="text-sm">Upload Nota</label>
                        <input type="file" name="receipt_file" id="receipt_file" accept="image/*"
                            class="w-full rounded-lg border px-3 py-2">
                    </div>

                    {{-- PREVIEW IMAGE --}}
                    <div id="preview-wrapper" class="hidden">
                        <label class="text-sm">Preview Nota</label>
                        <img id="preview-image" class="rounded-lg border max-h-64">
                    </div>

                    {{-- STORE --}}
                    <div id="store-wrapper" class="hidden">
                        <label class="text-sm">Nama Toko</label>
                        <input type="text" name="store_name" id="store_name" class="w-full rounded-lg border px-3 py-2">
                    </div>

                    {{-- NOTE NUMBER --}}
                    <div id="note-wrapper" class="hidden">
                        <label class="text-sm">Nomor Nota</label>
                        <input type="text" name="note_number" id="note_number" class="w-full rounded-lg border px-3 py-2">
                    </div>

                    {{-- DATE --}}
                    <div id="date-wrapper" class="hidden">
                        <label class="text-sm">Tanggal</label>
                        <input type="date" name="expense_date" id="expense_date" class="w-full rounded-lg border px-3 py-2">
                    </div>

                    <input type="hidden" name="ocr_raw_text" id="ocr_raw_text">

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-brand-500 hover:bg-blue-700 text-white  px-4 py-2 rounded-lg shadow transition 
                                                                focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-600">
                            Create Expanse
                        </button>
                    </div>

            </form>
        </div>

    </div>

    <script>
        const receiptInput = document.getElementById('receipt_file');

        const storeWrapper = document.getElementById('store-wrapper');
        const storeName = document.getElementById('store_name');
        const noteWrapper = document.getElementById('note-wrapper');
        const noteNumber = document.getElementById('note_number');
        const dateWrapper = document.getElementById('date-wrapper');
        const expenseDate = document.getElementById('expense_date');
        const amountInput = document.getElementById('amount');

        const previewWrapper = document.getElementById('preview-wrapper');
        const previewImage = document.getElementById('preview-image');

        receiptInput.addEventListener('change', async function () {
            if (!this.files.length) return;

            // preview image
            previewWrapper.classList.remove('hidden');
            previewImage.src = URL.createObjectURL(this.files[0]);

            const formData = new FormData();
            formData.append('receipt_file', this.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            try {
                const res = await fetch('{{ route('finance.expenses.ocr.preview') }}', {
                    method: 'POST',
                    body: formData
                });

                if (!res.ok) throw new Error('OCR gagal');

                const data = await res.json();

                document.getElementById('ocr_raw_text').value = data.raw_text ?? '';

                if (data.parsed?.store_name) {
                    storeWrapper.classList.remove('hidden');
                    storeName.value = data.parsed.store_name;
                }

                if (data.parsed?.note_number) {
                    noteWrapper.classList.remove('hidden');
                    noteNumber.value = data.parsed.note_number;
                }

                if (data.parsed?.amount) {
                    amountInput.value = new Intl.NumberFormat("id-ID").format(data.parsed.amount);
                }

                if (data.parsed?.expense_date) {
                    dateWrapper.classList.remove('hidden');
                    expenseDate.value = data.parsed.expense_date;
                }

            } catch (err) {
                console.error(err);
                alert('OCR gagal diproses');
            }
        });

        function formatRupiah(el) {
            el.value = el.value.replace(/\D/g, '')
                .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    </script>
@endsection