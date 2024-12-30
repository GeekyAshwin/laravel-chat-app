<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10 max-w-4xl bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-700">Edit Employment Entry</h2>

        <form id="editEmploymentForm" class="mt-6 space-y-4">
            <input type="hidden" id="entry_id">
            <div>
                <label class="block text-gray-700 font-medium">Employer Name</label>
                <input type="text" id="employer" class="w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Position</label>
                <input type="text" id="position" class="w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Occupation</label>
                <input type="text" id="occupation" class="w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Manager Name</label>
                <input type="text" id="manager_name" class="w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Manager Email</label>
                <input type="email" id="manager_email" class="w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <button type="submit"
                class="px-4 py-2 text-white bg-indigo-500 rounded-md hover:bg-indigo-600">
                Update
            </button>
        </form>
    </div>

    <script>
        const entryId = 1; // Replace with dynamic ID from URL
        $(document).ready(function () {
            $.ajax({
                url: `/api/employments/${entryId}`,
                method: 'GET',
                success: function (data) {
                    $('#entry_id').val(data.id);
                    $('#employer').val(data.employer);
                    $('#position').val(data.position);
                    $('#occupation').val(data.occupation);
                    $('#manager_name').val(data.manager_name);
                    $('#manager_email').val(data.manager_email);
                }
            });
        });

        $('#editEmploymentForm').submit(function (e) {
            e.preventDefault();
            const id = $('#entry_id').val();
            const data = {
                employer: $('#employer').val(),
                position: $('#position').val(),
                occupation: $('#occupation').val(),
                manager_name: $('#manager_name').val(),
                manager_email: $('#manager_email').val()
            };
            $.ajax({
                url: `/api/employments/${id}`,
                method: 'PUT',
                data: data,
                success: function () {
                    alert('Entry updated successfully!');
                    window.location.href = '/';
                }
            });
        });
    </script>
</body>

</html>
