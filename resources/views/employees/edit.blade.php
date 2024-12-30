@extends('layouts.main')

@section('content')
    <div class="container mx-auto mt-10 max-w-4xl bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-700">Edit Employment</h2>

        <form id="editEmploymentForm" class="mt-6 space-y-4">
            @csrf
            <input type="hidden" id="employment_id" value="{{ $employment->id }}">
            <div>
                <label class="block text-gray-700 font-medium">Employer Name</label>
                <input required type="text" id="employer"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                    value="{{ $employment->employer_name }}" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Position</label>
                <input required type="text" id="position"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                    value="{{ $employment->position }}" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Occupation</label>
                <input required type="text" id="occupation"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                    value="{{ $employment->occupation }}" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Manager Name</label>
                <input required type="text" id="manager_name"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                    value="{{ $employment->manager_name }}" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Manager Email</label>
                <input required type="email" id="manager_email"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                    value="{{ $employment->manager_email }}" required>
            </div>
            <button type="submit" class="px-4 py-2 text-white bg-indigo-500 rounded-md hover:bg-indigo-600">
                Update
            </button>
        </form>
    </div>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#editEmploymentForm').submit(function(e) {
        e.preventDefault();
        const id = $('#employment_id').val();
        const data = {
            employer_name: $('#employer').val(),
            position: $('#position').val(),
            occupation: $('#occupation').val(),
            manager_name: $('#manager_name').val(),
            manager_email: $('#manager_email').val()
        };
        $.ajax({
            url: `/employment/${id}`,
            method: 'PUT',
            data: data,
            success: function() {
                alert('Employment updated successfully!');
                window.location.href = '/';
            }
        });
    });
</script>
@endsection
