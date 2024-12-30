@extends('layouts.main')

@section('content')
<div class="container mx-auto mt-10 max-w-4xl bg-white shadow-md rounded-lg p-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-700">Employment History</h2>
        <a href="/employment/create"
            class="px-4 py-2 text-sm text-white bg-indigo-500 rounded-md hover:bg-indigo-600">
            Add Employment
        </a>
    </div>

    <div class="mt-6">
        <!-- Employment Entries -->
        <table class="w-full text-left border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-2 border border-gray-300">Employer</th>
                    <th class="p-2 border border-gray-300">Position</th>
                    <th class="p-2 border border-gray-300">Occupation</th>
                    <th class="p-2 border border-gray-300">Manager Name</th>
                    <th class="p-2 border border-gray-300">Manager Email</th>
                    <th class="p-2 border border-gray-300">Actions</th>
                </tr>
            </thead>
            @foreach ($employments as $employment)
            <tbody id="employmentTable">
                    <td class="p-2 border">{{ $employment->employer_name }}</td>
                    <td class="p-2 border">{{ $employment->position }}</td>
                    <td class="p-2 border">{{ $employment->occupation }}</td>
                    <td class="p-2 border">{{ $employment->manager_name }}</td>
                    <td class="p-2 border">{{ $employment->manager_email }}</td>
                    <td class="p-2 border">
                        <a href="/employment/{{ $employment->id }}/edit">Edit</a>
                        <a id="deleteEmpBtn">Delete</a>
                    </td>

            </tbody>
            @endforeach
        </table>
    </div>
</div>


    <script>
        // Fetch and populate employment history
        function fetchEmploymentHistory() {
            $.ajax({
                url: '/api/employments',
                method: 'GET',
                success: function (data) {
                    let rows = '';
                    data.forEach(entry => {
                        rows += `
                            <tr>
                                <td class="p-2 border border-gray-300">${entry.employer}</td>
                                <td class="p-2 border border-gray-300">${entry.position}</td>
                                <td class="p-2 border border-gray-300">${entry.manager_name}</td>
                                <td class="p-2 border border-gray-300">
                                    <a href="/edit/${entry.id}" class="text-indigo-500 hover:underline">Edit</a>
                                    <button data-id="${entry.id}" class="text-red-500 hover:underline delete-btn">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#employmentTable').html(rows);
                }
            });
        }

        // Delete entry
        $(document).on('click', '.delete-btn', function () {
            const id = $(this).data('id');
            $.ajax({
                url: `/api/employments/${id}`,
                method: 'DELETE',
                success: function () {
                    fetchEmploymentHistory();
                }
            });
        });

        // Initialize
        $(document).ready(fetchEmploymentHistory);
    </script>
@endsection
