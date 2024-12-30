<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10 max-w-4xl bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Add Employment</h2>

        <form id="addEmploymentForm" action="/add-employment" method="POST" class="space-y-4">
            @csrf
            <!-- Employer Name -->
            <div>
                <label for="employer_name" class="block text-gray-600 font-medium">Employer Name</label>
                <input type="text" id="employer_name" name="employer_name"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <!-- Position -->
            <div>
                <label for="position" class="block text-gray-600 font-medium">Position</label>
                <input type="text" id="position" name="position"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <!-- Occupation -->
            <div>
                <label for="occupation" class="block text-gray-600 font-medium">Occupation</label>
                <input type="text" id="occupation" name="occupation"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <!-- Manager Name -->
            <div>
                <label for="manager_name" class="block text-gray-600 font-medium">Manager Name</label>
                <input type="text" id="manager_name" name="manager_name"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <!-- Manager Email -->
            <div>
                <label for="manager_email" class="block text-gray-600 font-medium">Manager Email</label>
                <input type="email" id="manager_email" name="manager_email"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-white bg-indigo-500 rounded-md hover:bg-indigo-600">
                    Add Employment
                </button>
            </div>
        </form>
    </div>
</body>

</html>

<script>
    // CSRF Token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#addEmploymentForm").submit(function(e) {
        e.preventDefault();

        // Get the values from the input fields
        const employerName = $('#employer_name').val();
        const position = $('#position').val();
        const occupation = $('#occupation').val();
        const managerName = $('#manager_name').val();
        const managerEmail = $('#manager_email').val();

        // Send the data via AJAX
        $.ajax({
            url: '/add-employment',  // Adjust the URL for your endpoint
            type: 'POST',
            data: {
                employer_name: employerName,
                position: position,
                occupation: occupation,
                manager_name: managerName,
                manager_email: managerEmail
            },
            success: function(response) {
                console.log(response);
                // Optional: Display a success message or reset the form
                alert('Employment added successfully!');
                $('#addEmploymentForm')[0].reset();
            },
            error: function(error) {
                console.error(error);
                alert('There was an error adding the employment.');
            }
        });
    });
</script>
