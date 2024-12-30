@extends('layouts.main')

@section('content')
<div class="container mx-auto mt-10 max-w-4xl bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-700 mb-6">Add Employment</h2>

    <form id="addEmploymentForm" method="POST" class="space-y-4">
        @csrf

        <div id="employmentFields">
            <div class="employment-row" data-index="0">
                <h3 class="text-lg font-semibold text-gray-600">Employment #1</h3>

                <div>
                    <label for="employment[0][employer_name]" class="block text-gray-600 font-medium">Employer
                        Name</label>
                    <input type="text" id="employment[0][employer_name]" name="employment[0][employer_name]"
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                </div>

                <div>
                    <label for="employment[0][position]" class="block text-gray-600 font-medium">Position</label>
                    <input type="text" id="employment[0][position]" name="employment[0][position]"
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                </div>

                <div>
                    <label for="employment[0][occupation]"
                        class="block text-gray-600 font-medium">Occupation</label>
                    <input type="text" id="employment[0][occupation]" name="employment[0][occupation]"
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                </div>

                <div>
                    <label for="employment[0][manager_name]" class="block text-gray-600 font-medium">Manager
                        Name</label>
                    <input type="text" id="employment[0][manager_name]" name="employment[0][manager_name]"
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                </div>

                <div>
                    <label for="employment[0][manager_email]" class="block text-gray-600 font-medium">Manager
                        Email</label>
                    <input type="email" id="employment[0][manager_email]" name="employment[0][manager_email]"
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                </div>
            </div>
        </div>


        <div class="flex justify-end space-x-4">
            <button type="button"
                class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100"
                id="addEmploymentRow">
                Add Another Employment
            </button>
            <button type="submit" class="px-4 py-2 text-white bg-indigo-500 rounded-md hover:bg-indigo-600">
                Submit Employment
            </button>
        </div>
    </form>
</div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let employmentCount = 1; // Start with one employment row
    $("#addEmploymentRow").click(function(e) {
        e.preventDefault();
        const newRow = `
    <div class="employment-row" data-index="${employmentCount}">
        <h3 class="text-lg font-semibold text-gray-600">Employment #${employmentCount + 1}</h3>

        <div>
            <label for="employment[${employmentCount}][employer_name]" class="block text-gray-600 font-medium">Employer Name</label>
            <input type="text" id="employment[${employmentCount}][employer_name]" name="employment[${employmentCount}][employer_name]"
                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>

        <div>
            <label for="employment[${employmentCount}][position]" class="block text-gray-600 font-medium">Position</label>
            <input type="text" id="employment[${employmentCount}][position]" name="employment[${employmentCount}][position]"
                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>

        <div>
            <label for="employment[${employmentCount}][occupation]" class="block text-gray-600 font-medium">Occupation</label>
            <input type="text" id="employment[${employmentCount}][occupation]" name="employment[${employmentCount}][occupation]"
                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>

        <div>
            <label for="employment[${employmentCount}][manager_name]" class="block text-gray-600 font-medium">Manager Name</label>
            <input type="text" id="employment[${employmentCount}][manager_name]" name="employment[${employmentCount}][manager_name]"
                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>

        <div>
            <label for="employment[${employmentCount}][manager_email]" class="block text-gray-600 font-medium">Manager Email</label>
            <input type="email" id="employment[${employmentCount}][manager_email]" name="employment[${employmentCount}][manager_email]"
                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>
    </div>
`;


        $("#employmentFields").append(newRow);

        employmentCount++;
    });

    $("#addEmploymentForm").submit(function(e) {
        e.preventDefault();

        const formData = $(this).serializeArray();
        console.log("Form Data: ", formData);

        $.ajax({
            url: '/employment',
            type: 'POST',
            data: formData,
            success: function(response) {
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
@endsection
