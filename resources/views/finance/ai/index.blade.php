@extends('layouts.main')

@section('content')
    <div class="container rounded-2xl bg-gray-100 px-2">
        <div style="max-height: 500px; width: 80%;"
            class="max-w-xl mx-auto mt-6 dark:bg-gray-900 rounded-xl shadow-xl flex flex-col h-screen p-5">

            
            <!-- Header -->
            <div
                class="bg-green-600 dark:bg-green-700 text-gray-500 dark:text-white px-4 py-3 flex items-start justify-start gap-3">
                <h1 class="text-lg font-semibold">AI Chat</h1>
            </div>

            <!-- Chat Box -->
            <div id="chatBox"
                class="flex-1 p-4 overflow-y-auto space-y-3 
            bg-[url('https://i.ibb.co/3fJvcyM/bg-whatsapp-dark.jpg')] 
            dark:bg-[url('https://i.ibb.co/3fJvcyM/bg-whatsapp-dark.jpg')] 
            bg-cover bg-center">
            </div>

            <!-- Input Area -->
            <div
                class="w-full p-3 rounded-2xl bg-gray-200 dark:bg-gray-800 
                flex items-center gap-2 overflow-hidden">

                <input style="outline: none;" id="input" type="text"
                    class="flex-1 min-w-0 px-4 py-2 rounded-2xl bg-transparent 
               dark:bg-gray-700 dark:text-white focus:outline-none"
                    placeholder="Tulis pesan..." />

                <!-- Mic Button -->
                <button id="micButton"
                    class="shrink bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 
               dark:hover:bg-gray-700 p-3 rounded-full flex items-center 
               justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        class="w-6 h-6 stroke-gray-500 dark:stroke-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 1a3 3 0 00-3 3v6a3 3 0 006 0V4a3 3 0 00-3-3zm6 9a6 6 0 01-12 0M5 10v2a7 7 0 0014 0v-2M12 17v4m0 0h-3m3 0h3" />
                    </svg>
                </button>

                <!-- Send Button -->
                <button onclick="sendMessage()"
                    class="shrink bg-brand-500 hover:bg-brand-700 text-white px-4 py-2 rounded-full">
                    ➤
                </button>
            </div>

        </div>
    </div>


    <script src="{{ asset('/js/chat.js') }}"></script>
@endsection
