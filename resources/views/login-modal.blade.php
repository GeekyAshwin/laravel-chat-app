<!-- Main Container -->
<div id="loginModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 ">
    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg w-96">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Login</h2>
        </div>
        <!-- Body -->
        <div class="px-6 py-4">
            <p class="text-gray-600 text-sm mb-4">Enter your login code to proceed:</p>

                <label for="loginCode" class="block text-sm font-medium text-gray-700">Login Code</label>
                <input
                    type="text"
                    id="loginCode"
                    name="loginCode"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Enter your code"
                    required
                />
                <button
                    type="submit"
                    id="login"
                    class="mt-4 w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"
                >
                    Submit
                </button>

        </div>
        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-200 text-right">
            <button
                id="closeModal"
                class="text-sm text-gray-500 hover:text-gray-700 focus:outline-none"
            >
                Cancel
            </button>
        </div>
    </div>
</div>
<script>
    // CSRF Token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // $("#loginModal").addClass("hidden");


    $("#login").click(function (e) {
        let loginCode = $("#loginCode").val();
        $.ajax({
            url: '{{ route('login') }}',
            type: 'POST',
            data: {
                login_code: loginCode
            },
            success: function(response) {
                $("#loginModal").addClass("hidden");
            },
            error: function(error) {
                console.error(error);
                alert('An error occurred');
            }
        });
    });

</script>
