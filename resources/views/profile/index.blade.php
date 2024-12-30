<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10 max-w-4xl bg-white shadow-md rounded-lg p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-700">Profile Details</h2>
            <a href="/edit-profile"
                class="px-4 py-2 text-sm text-white bg-indigo-500 rounded-md hover:bg-indigo-600">
                Edit Profile
            </a>
        </div>

        <div class="mt-6 space-y-6">
            <!-- Profile Picture -->
            <div class="flex items-center space-x-4">
                <img src="https://via.placeholder.com/100" alt="Profile Picture"
                    class="w-24 h-24 rounded-full border-2 border-indigo-500">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">John Doe</h3>
                    <p class="text-sm text-gray-500">Lead UI/UX Designer</p>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="border-t border-gray-300 pt-6">
                <h3 class="text-lg font-semibold text-gray-700">Personal Information</h3>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-600">Full Name:</span>
                        <span class="text-gray-800">John Doe</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-600">Email:</span>
                        <span class="text-gray-800">johndoe@example.com</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-600">Phone:</span>
                        <span class="text-gray-800">123-456-7890</span>
                    </div>
                </div>
            </div>

            <!-- Skills -->
            <div class="border-t border-gray-300 pt-6">
                <h3 class="text-lg font-semibold text-gray-700">Skills</h3>
                <ul class="list-disc pl-5 mt-4 space-y-1">
                    <li class="text-gray-800">HTML</li>
                    <li class="text-gray-800">CSS</li>
                    <li class="text-gray-800">JavaScript</li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>
