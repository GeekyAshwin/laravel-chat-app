<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{ url('/js/script.js') }}"></script>
    {{-- <input type="hidden" name="sent_by" > --}}
    <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
    <input type="hidden" id="username" name="username" value="{{ session('username') }}">
    <input type="hidden" id="cluster" name="cluster" value="{{ env('PUSHER_APP_CLUSTER') }}">
    <input type="hidden" id="pusher_app_key" name="pusher_app_key" value="{{ env('PUSHER_APP_KEY') }}">
    <input type="hidden" id="call_id" name="call_id">
    <input type="hidden" name="peerId" id="peerId">
    <input type="hidden" name="receiverPeerId" id="receiverPeerId">
    <script src="https://cdn.jsdelivr.net/npm/peerjs@1.3.2/dist/peerjs.min.js"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <div class="text-2xl font-bold text-indigo-600">
                    <a href="{{ url('/') }}">Brand</a>
                </div>

                <div class="lg:hidden">
                    <button id="menu-btn" class="text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>

                <div id="menu" class="hidden lg:flex space-x-6">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-indigo-600">Home</a>
                    <a href="{{ url('/employment') }}" class="text-gray-600 hover:text-indigo-600">Employment</a>
                    <a href="{{ url('/profile') }}" class="text-gray-600 hover:text-indigo-600">Profile</a>
                </div>
            </div>

            <div id="mobile-menu" class="hidden lg:hidden">
                <a href="{{ url('/') }}" class="block py-2 px-4 text-gray-600 hover:text-indigo-600 hover:bg-gray-50">Home</a>
                <a href="{{ url('/employment') }}" class="block py-2 px-4 text-gray-600 hover:text-indigo-600 hover:bg-gray-50">Employment</a>
                <a href="{{ url('/profile') }}" class="block py-2 px-4 text-gray-600 hover:text-indigo-600 hover:bg-gray-50">Profile</a>
            </div>
        </div>
    </nav>
    <main class="container mx-auto mt-8 px-4">
        @yield('content')
    </main>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
