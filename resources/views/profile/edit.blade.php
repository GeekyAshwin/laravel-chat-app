@extends('layouts.main')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('content')

    <div class="container mx-auto mt-10 max-w-4xl bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Edit Profile</h2>

        <form id="updateProfileForm"  method="POST" class="space-y-4">
            @csrf
            <!-- Name -->
            <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">

            <div>
                <label for="name" class="block text-gray-600 font-medium">Full Name</label>
                <input type="text" id="name" name="name" value="{{ $profile->name }}"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-600 font-medium">Email</label>
                <input type="email" id="email" name="email" value="{{ $profile->email }}"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-gray-600 font-medium">Phone</label>
                <input type="tel" id="phone" name="phone" value="{{ isset($profile->userProfile) ? $profile->userProfile->phone : '' }}"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <!-- Skills -->
            <div>
                <label for="skills" class="block text-gray-600 font-medium">Skills</label>
                <textarea id="skills" name="skills" rows="4"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">{{ $profile->userProfile->skills }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-white bg-indigo-500 rounded-md hover:bg-indigo-600">
                    Update Profile
                </button>
            </div>
        </form>
    </div>

<script>
     // CSRF Token setup
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#updateProfileForm").submit(function(e) {
        e.preventDefault();
        // Get the values from the input fields
        const name = $('#name').val();
        const email = $('#email').val();
        const phone = $('#phone').val();
        const userId = $('#user_id').val();
        const skills = $('#skills').val();


        $.ajax({
            url: '{{ route('profile.update', ':userId') }}'.replace(':userId', userId),  // Replace the placeholder with the actual userId

            type: 'PUT',
            data: {
                name: name,
                email: email,
                phone: phone,
                skills: skills
            },
            success: function(response) {
                console.log(response);
                window.location.href = '/'
            },
            error: function(error) {
                console.error(error);
                alert(error);
            }
        });

    });
</script>
@endsection
