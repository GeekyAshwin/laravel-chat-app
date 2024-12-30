<!-- Main Container -->
<div id="callModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg w-96">
      <!-- Header -->
      <div class="px-6 py-4 border-b border-gray-200 text-center">
        <h2 id="callingStatus" class="text-lg font-semibold text-gray-800">Calling...</h2>
        <p class="text-sm text-gray-600 mt-1">Username: <span id="callSender" class="font-semibold"></span></p>
      </div>
      <!-- Body -->
      <div class="flex flex-col items-center justify-center px-6 py-8">

        <div class="flex justify-center gap-6">
          <!-- End Call Button -->
          <button
            id="endCall"
            class="bg-red-500 hover:bg-red-600 text-white rounded-full p-4 shadow-lg focus:outline-none"
            aria-label="End Call"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.994 12.126C6.333 10.444 7.121 8 9.004 8h6.001c1.883 0 2.671 2.444 2.01 4.126l-.39 1.028A2.994 2.994 0 0113.736 16H10.27a2.994 2.994 0 01-2.889-2.846l-.387-1.028z" />
            </svg>
          </button>
          <!-- Receive Call Button -->

          <button
            id="receiveCall"
            class="bg-green-500 hover:bg-green-600 text-white rounded-full p-4 shadow-lg focus:outline-none"
            aria-label="Receive Call"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 3h3m0 0h3m-3 0v3m3-3L12 12m0 0L9 15m3-3H3m12 0L3 3m3 0h3m0 0v3m0-3L12 15" />
            </svg>
          </button>
        </div>
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


    $("#endCall").click(function (e) {
        let callId = $("#call_id").val();

        $.ajax({
            url: '{{ route('reject-call') }}',
            type: 'POST',
            data: {
                call: callId
            },
            success: function(response) {
                $("#callModal").addClass("hidden");
                $("#callingStatus").text('Connecting....');
            },
            error: function(error) {
                console.error(error);
                alert('An error occurred');
            }
        });
    });

    $("#receiveCall").click(function (e) {
        let loginCode = $("#loginCode").val();
        let callId = $("#call_id").val();

        $.ajax({
            url: '{{ route('accept-call') }}',
            type: 'POST',
            data: {
                call: callId
            },
            success: function(response) {
                $("#loginModal").addClass("hidden");
                $("#callingStatus").text('Connected');
                receiveCall();
            },
            error: function(error) {
                console.error(error);
                alert('An error occurred');
            }
        });
    });

</script>
