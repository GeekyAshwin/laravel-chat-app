@extends('layouts.main')

@section('content')
    <div class="container mx-auto mt-10 max-w-4xl bg-white shadow-md rounded-lg p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-700">Employment History</h2>
            <a href="/employment/create" class="px-4 py-2 text-sm text-white bg-indigo-500 rounded-md hover:bg-indigo-600">
                Add Employment
            </a>
        </div>

        <div class="mt-6">
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
                            <a href="/employment/{{ $employment->id }}/edit"
                                class="px-4 m-2 py-2 text-sm text-white bg-indigo-500 rounded-md hover:bg-grey-600 flex items-center space-x-2">
                                Edit
                            </a>

                            <button id="deleteEmpBtn" data-empId="{{ $employment->id }}"
                                class="px-4 deleteEmpBtn m-2 py-2 text-sm text-white bg-red-500 rounded-md hover:bg-red-600 flex items-center space-x-2">
                                Delete
                            </button>
                        </td>

                    </tbody>
                @endforeach
            </table>
        </div>
    </div>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(".deleteEmpBtn").click(function(e) {
            var empId = $(this).data("empid");
            console.log(empId)
            $.ajax({
                url: '{{ route('employment.destroy', ':empId') }}'.replace(':empId',
                    empId), // Replace the placeholder with the actual userId
                type: 'DELETE',

                success: function(response) {
                    console.log(response);
                    $("#message").val('');
                    alert(response.message)
                    window.location.href = '/employment'
                },
                error: function(error) {
                    console.error(error);
                    alert(error);
                }
            });

        });
    </script>
@endsection

