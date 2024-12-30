<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <!-- Logo -->
                <div class="text-2xl font-bold text-indigo-600">Brand</div>

                <!-- Menu Button (Mobile) -->
                <div class="lg:hidden">
                    <button id="menu-btn" class="text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Links -->
                <div id="menu" class="hidden lg:flex space-x-6">
                    <a href="#" class="text-gray-600 hover:text-indigo-600">Home</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600">About</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600">Services</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600">Contact</a>
                </div>
            </div>

            <!-- Mobile Links -->
            <div id="mobile-menu" class="hidden lg:hidden">
                <a href="#" class="block py-2 px-4 text-gray-600 hover:text-indigo-600 hover:bg-gray-50">Home</a>
                <a href="#" class="block py-2 px-4 text-gray-600 hover:text-indigo-600 hover:bg-gray-50">About</a>
                <a href="#" class="block py-2 px-4 text-gray-600 hover:text-indigo-600 hover:bg-gray-50">Services</a>
                <a href="#" class="block py-2 px-4 text-gray-600 hover:text-indigo-600 hover:bg-gray-50">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mx-auto mt-8">
    </div>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const menu = document.getElementById('menu');
        const mobileMenu = document.getElementById('mobile-menu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

</body>
</html>
