@extends('layouts.main')

@section('title', 'Budget Request | WokaCash')

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

                            <input type="text" placeholder="Search budget request"
                                class="dark:bg-dark-900 shadow-sm h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-white/30" />
                        </div>
                    </form>
                </div>

                <a href="{{ route('staff.budget_requests.create') }}"
                    class="bg-brand-500 px-4 py-2 rounded-lg text-white text-sm shadow hover:bg-brand-600 transition">
                    Create Budget Requests
                </a>
            </div>
            {{-- TABLE LIST --}}
            <div class="w-full p-4 bg-white dark:bg-gray-900 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
                    Daftar Budget Request
                </h2>

                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-800">
                            <th class="py-3 px-4 text-gray-600 dark:text-white">No</th>
                            <th class="py-3 px-4 text-gray-600 dark:text-white">Judul</th>
                            <th class="py-3 px-4 text-gray-600 dark:text-white">Cabang</th>
                            <th class="py-3 px-4 text-gray-600 dark:text-white">Jumlah</th>
                            <th class="py-3 px-4 text-gray-600 dark:text-white">Status</th>
                            <th class="py-3 px-4 text-gray-600 dark:text-white">Tanggal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($budgetList as $no => $row)
                            <tr class="border-b dark:border-gray-700">
                                <td class="py-3 px-4 text-gray-700 dark:text-white">{{ $no + 1 }}</td>
                                <td class="py-3 px-4 text-gray-700 dark:text-white">{{ $row->title }}</td>
                                <td class="py-3 px-4 text-gray-700 dark:text-white">{{ $row->branch->name }}</td>
                                <td class="py-3 px-4 text-gray-700 dark:text-white">Rp
                                    {{ number_format($row->amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-gray-700 dark:text-white">
                                    <span class="
                                        inline-flex items-center px-3 py-1 text-sm font-medium rounded-full
                                        @if($row->status == 'pending') bg-yellow-100 text-yellow-700
                                        @elseif($row->status == 'approved') bg-green-100 text-green-700
                                        @elseif($row->status == 'rejected') bg-red-100 text-red-700
                                        @else bg-gray-100 text-gray-700 @endif
                                    ">
                                        {{ ucfirst($row->status) }}
                                    </span>
                                </td>

                                <td class="py-3 px-4 text-gray-700 dark:text-white">
                                    {{ \Carbon\Carbon::parse($row->date_submission)->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-500">No Budget Request</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- JS sama seperti modal income --}}
    <script>
        function formatRupiah(el) {
            let value = el.value.replace(/[^0-9]/g, "");
            if (!value) return el.value = "";
            el.value = new Intl.NumberFormat("id-ID").format(value);
        }

        document.addEventListener("DOMContentLoaded", () => {
            const wrapper = document.getElementById("add-budget-modal-wrapper");
            const backdrop = document.getElementById("add-budget-modal-backdrop");
            const content = document.getElementById("add-budget-modal-content");
            const openBtn = document.getElementById("open-modal-button");
            const close1 = document.getElementById("close-modal-button-header");
            const close2 = document.getElementById("close-modal-button-footer");

            function openModal() {
                wrapper.classList.remove("hidden");
                wrapper.offsetHeight;
                setTimeout(() => {
                    backdrop.classList.add("modal-open-backdrop");
                    content.classList.add("modal-open-content");
                }, 10);
                document.body.style.overflow = "hidden";
            }

            function closeModal() {
                backdrop.classList.remove("modal-open-backdrop");
                content.classList.remove("modal-open-content");
                setTimeout(() => {
                    wrapper.classList.add("hidden");
                    document.body.style.overflow = "";
                }, 300);
            }

            openBtn.addEventListener('click', openModal);
            close1.addEventListener('click', closeModal);
            close2.addEventListener('click', closeModal);
            wrapper.addEventListener('click', e => {
                if (e.target === wrapper || e.target === backdrop) closeModal();
            });
        });
    </script>

@endsection