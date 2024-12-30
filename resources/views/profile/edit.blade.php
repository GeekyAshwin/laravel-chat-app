<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10 max-w-4xl bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Edit Profile</h2>

        <form action="/update-profile" method="POST" class="space-y-4">
            <!-- Name -->
            <div>
                <label for="name" class="block text-gray-600 font-medium">Full Name</label>
                <input type="text" id="name" name="name" value="John Doe"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-600 font-medium">Email</label>
                <input type="email" id="email" name="email" value="johndoe@example.com"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-gray-600 font-medium">Phone</label>
                <input type="tel" id="phone" name="phone" value="123-456-7890"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <!-- Skills -->
            <div>
                <label for="skills" class="block text-gray-600 font-medium">Skills</label>
                <textarea id="skills" name="skills" rows="4"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">HTML, CSS, JavaScript</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-white bg-indigo-500 rounded-md hover:bg-indigo-600">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</body>

</html>
