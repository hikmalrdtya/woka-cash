@extends('layouts.main')

@section('title', 'User Management | WokaCash')

@section('content')
    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden flex-col">

        <div class="hero p-6">
            <!-- Top bar -->
            <div class="flex justify-between items-center mb-6">
                <!-- SEARCH -->
                <div class="hidden lg:block">
                    <form>
                        <div class="relative">
                            <span class="absolute top-1/2 left-4 -translate-y-1/2">
                                <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z" />
                                </svg>
                            </span>

                            <input type="text" placeholder="Search name user" id="search-input"
                                class="dark:bg-dark-900 shadow-sm focus:border-brand-300 focus:ring-brand-500/10 
                                                                h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 
                                                                text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 outline-none
                                                                xl:w-64 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-white/30" />
                        </div>
                    </form>
                </div>

                <!-- CREATE USERS BUTTON -->
                <a href="{{ route('admin.user.create') }}"
                    class="bg-brand-500 px-4 py-2 rounded-lg text-white text-sm shadow hover:bg-brand-600 transition">
                    Create Users
                </a>
            </div>

            <!-- Table -->
            <div class="w-full p-4 bg-white dark:bg-gray-900 rounded-xl shadow-md">

                <!-- Title -->
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
                    Daftar Users
                </h2>

                <!-- Table Wrapper - Full Width -->
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <th class="py-3 px-4 text-gray-600 dark:text-white">No</th>
                                <th class="py-3 px-4 text-gray-600 dark:text-white">Name</th>
                                <th class="py-3 px-4 text-gray-600 dark:text-white">Email</th>
                                <th class="py-3 px-4 text-gray-600 dark:text-white">Role</th>
                                <th class="py-3 px-4 text-gray-600 dark:text-white">Cabang Perusahaan</th>
                                <th class="py-3 px-4 text-gray-600 dark:text-white">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($users as $no => $row)
                                <tr
                                    class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                    <td class="py-3 px-4 text-gray-700 dark:text-white">{{ $no + 1 }}</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-white flex items-center gap-3">
                                        <div class="w-10 h-10 overflow-hidden rounded-full">
                                            <img src="{{ asset('storage/' . $row->photo_profile) }}" alt="photo profile"
                                                srcset="" width="50px">
                                        </div>
                                        <div>
                                            <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                {{ $row->name }}
                                            </span>
                                            <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                                Web Designer
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-white">{{ $row->email }}</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-white">{{ ucfirst($row->role) }}</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-white">Jakarta</td>
                                    <td class="py-3 px-4 flex gap-3 justify-center items-center">
                                        <a href="{{ route('admin.user.edit', $row->id) }}"
                                            class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">Edit</a>
                                        <form id="delete-form-{{ $row->id }}"
                                            action="{{ route('admin.user.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" onclick="deleteUser({{ $row->id }})"
                                                 class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                                                Delete
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-gray- py-4">
                                        <i class="bi bi-info-circle"></i> Belum ada data Kegiatan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        function deleteUser(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data user ini akan hilang permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
                customClass: {
                    popup: 'rounded-xl shadow-lg swal-custom-popup',
                    container: 'swal-custom-container'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // submit form yang benar
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
                confirmButtonColor: '#4f46e5', // brand-500 TailAdmin
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
                confirmButtonColor: '#ef4444', // error-500 TailAdmin
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
                customClass: {
                    popup: 'rounded-xl shadow-lg animate__animated animate__shakeX',
                    confirmButton: 'rounded-lg px-4 py-2'
                }
            })
        </script>
    @endif

    <style>
        .swal-custom-container {
            z-index: 99999 !important;
        }

        .swal-custom-popup {
            z-index: 999999 !important;
        }
    </style>
@endsection