@extends('layouts.main')

@section('content')
<div class="container mx-auto mt-10 max-w-4xl bg-white shadow-md rounded-lg p-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-700">Profile Details</h2>
        <a href="/profile/{{ session('user_id') }}/edit"
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
                <h3 class="text-xl font-semibold text-gray-800">{{ $profile->name }}</h3>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="border-t border-gray-300 pt-6">
            <h3 class="text-lg font-semibold text-gray-700">Personal Information</h3>
            <div class="mt-4 space-y-2">
                <div class="flex justify-between">

                    <span class="font-medium text-gray-600">Full Name:</span>
                    <span class="text-gray-800">{{ $profile->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">Email:</span>
                    <span class="text-gray-800">{{ $profile->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">Phone:</span>
                    @if (isset($profile->userProfile))
                    <span class="text-gray-800">{{ $profile->userProfile->phone }}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Skills -->
        <div class="border-t border-gray-300 pt-6">
            <h3 class="text-lg font-semibold text-gray-700">Skills</h3>
            {{ $profile->userProfile->skills }}
        </div>
    </div>
</div>
@endsection


</html>
