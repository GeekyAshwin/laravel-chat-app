<!-- component -->
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{ url('/js/script.js') }}"></script>
    {{-- <input type="hidden" name="sent_by" > --}}
    <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
    <input type="hidden" id="username" name="username" value="{{ session('username') }}">
    <input type="hidden" id="call_id" name="call_id">
    <input type="hidden" name="peerId" id="peerId">
    <input type="hidden" name="receiverPeerId" id="receiverPeerId">
    <script src="https://cdn.jsdelivr.net/npm/peerjs@1.3.2/dist/peerjs.min.js"></script>


    <script>
        // Peer JS
        var peer = new Peer();

        // Create the peer and listen for incoming connections
        peer.on('open', (id) => {
            console.log('My peer ID is: ' + id);
            document.getElementById('peerId').value = id;
            $.ajax({
                url: '{{ route('update-peerid') }}', // Replace with the route to save the peer ID
                type: 'POST',
                data: {
                    peer_id: id,
                },
                success: function(response) {
                    console.log('Peer ID updated successfully');
                },
                error: function(error) {
                    console.error('Error updating peer ID', error);
                }
            });
        });

        async function makeCall(receiverPeerId, callId) {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    audio: true
                }); // Local stream

                // Include metadata (e.g., call ID) when making the call
                const callMetadata = {
                    callId: callId,
                    username: $("#username").val()
                };
                console.log(callMetadata)

                // Make the call and send the local stream to the receiver
                const call = peer.call(receiverPeerId, stream, {
                    metadata: callMetadata
                });
                peer.connect(receiverPeerId);

                console.log('Caller: Initiating call with peer ID: ' + receiverPeerId);

                // On receiving remote stream from the receiver
                call.on('stream', function(remoteStream) {
                    console.log('Caller: Received remote stream 1');
                    const audioPlayer = document.getElementById('audioPlayer');
                    audioPlayer.srcObject = remoteStream; // Play the remote audio stream
                    audioPlayer.play();
                });

                // Debugging errors on the caller's side
                call.on('error', function(err) {
                    console.error('Caller: Call Error:', err);
                });

            } catch (err) {
                console.error('Error getting local stream on caller side:', err);
            }
        }


        async function receiveCall() {
            peer.on('call', async function(call) {
                try {
                    // //Run the wrapped code  after btn click
                    // // wrap code start
                    const stream = await navigator.mediaDevices.getUserMedia({
                        audio: true
                    }); // Local stream for answering the call

                    // // Answer the call with the local audio stream
                    call.answer(stream);

                    // // On receiving remote stream from the caller
                    call.on('stream', function(remoteStream) {
                        console.log('Receiver: Received remote stream');
                        const audioPlayer = document.getElementById('audioPlayer');
                        audioPlayer.srcObject = remoteStream; // Play the remote audio stream
                        audioPlayer.play();
                    });
                    //wrap code end

                    // Debugging errors on the receiver's side
                    call.on('error', function(err) {
                        console.error('Receiver: Call Error:', err);
                    });

                } catch (err) {
                    console.error('Error getting local stream on receiver side:', err);
                }
            });
        }

        /// 1. open modal
        /// 2. pass call id
        /// 3. on click of receive btn trigger the event and remainign code

        peer.on('call', async function(call) {
            try {
                console.log('Receiver: You received a call');
                console.log('Receiver: Call metadata:', call.metadata); // Access call metadata
                console.log('Receiver: Call ID:', call.metadata.callId); // Access the call ID

                const callId = call.metadata.callId;
                const callerName = call.metadata.username;

                // $('#callModal').removeClass('hidden');
                // $("#call_id").val(call.metadata.callId);
                // console.log($('#callModal').length); // Should log 1 if the element exists
                const isReceived = confirm(callerName + ' is calling you. Press ok to pickup.')
                // //Run the wrapped code  after btn click

                // // wrap code start

                if (isReceived) {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        audio: true
                    });
                    call.answer(stream);
                    call.on('stream', function(remoteStream) {
                        console.log('Receiver: Received remote stream');
                        const audioPlayer = document.getElementById('audioPlayer');
                        audioPlayer.srcObject = remoteStream; // Play the remote audio stream
                        audioPlayer.play();
                    });
                }
            } catch (err) {
                console.error('Error getting local stream on receiver side:', err);
            }
        });

        async function endCall(receiverPeerId) {

        }

        var pusher = new Pusher('f5fa53d5e2af981c1678', {
            cluster: 'ap2',
            userTls: true,
        });

        const loggedInUserId = document.getElementById("user_id").value;
        var channel = pusher.subscribe('public');
        channel.bind('chat', function(data) {
            console.log(JSON.parse(data.message).message);
            const message = JSON.parse(data.message).message;
            const receivedHtml = `<div class="col-start-1 col-end-8 p-3 rounded-lg">
                                    <div class="flex flex-row items-center">
                                        <div
                                            class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                            A
                                        </div>
                                        <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                            <div>` + message + `</div>
                                        </div>
                                    </div>
                                </div>`
            const sentHtml = `<div class="col-start-6 col-end-13 p-3 rounded-lg">
    <div class="flex items-center justify-start flex-row-reverse">
        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
            A
        </div>
        <div class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
            <div>` + message + `</div>
        </div>
    </div>
</div>`;
            if (JSON.parse(data.message).sent_by == loggedInUserId) {
                // $('#chat-row').append(sentHtml);
            } else {
                $('#chat-row').append(receivedHtml);
                console.log('revied html printed')
            }



        });


        var callChannel = pusher.subscribe('call');
        // Listen for call initiated created
        callChannel.bind('call-initiated', function(data) {
            // console.log(data.call)
            // $('#callModal').removeClass('hidden');
            // $("#call_id").val(data.call.id);
            // console.log($('#callModal').length); // Should log 1 if the element exists

        });

        // Listen for call ended
        callChannel.bind('call-ended', function(data) {
            console.log(data)
            console.log($('#callModal').length); // Should log 1 if the element exists
        });

        // Listen for call rejected
        callChannel.bind('call-rejected', function(data) {
            console.log(data)
            $("#callModal").addClass("hidden");
            $("#callingStatus").text('Connecting....');
        });

        // Listen for call accepted
        callChannel.bind('call-accepted', function(data) {
            console.log(data)
            $("#callingStatus").text('Connected');
        });
    </script>
</head>

<body>
    <div class="flex h-screen antialiased text-gray-800">
        <audio id="audioPlayer" class="mt-4 w-full hidden" controls></audio>
        <div class="flex flex-row h-full w-full overflow-x-hidden">
            <div class="flex flex-col py-8 pl-6 pr-2 w-64 bg-white flex-shrink-0">
                <div class="flex flex-row items-center justify-center h-12 w-full">
                    <div class="flex items-center justify-center rounded-2xl text-indigo-700 bg-indigo-100 h-10 w-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-2 font-bold text-2xl">MyChattingApp</div>
                </div>
                <div
                    class="flex flex-col items-center bg-indigo-100 border border-gray-200 mt-4 w-full py-6 px-4 rounded-lg">
                    <div class="h-20 w-20 rounded-full border overflow-hidden">
                        <img src="https://avatars3.githubusercontent.com/u/2763884?s=128" alt="Avatar"
                            class="h-full w-full" />
                    </div>
                    <div class="text-sm font-semibold mt-2">{{ session('username') }}</div>
                    <div class="text-xs text-gray-500">Lead UI/UX Designer</div>
                    <div class="flex flex-row items-center mt-3">

                        <button id="logout"
                            class="flex items-center m-1 justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white px-4 py-1 flex-shrink-0">
                            <span>Logout</span>
                        </button>

                    </div>
                    <input type="hidden" id="inviteLink"
                        value="{{ url('/invite-link') . '/' . session('chat_code') }}">
                    <button id="invite"
                        class="flex items-center m-1 justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white px-4 py-1 flex-shrink-0">
                        <span>Copy Invite Link</span>
                    </button>
                </div>
                <input type="hidden" id="user_loggedin" name="user_loggedin" value="{{ session('user_loggedin') }}">

                <div class="flex flex-col mt-8">
                    <div class="flex flex-row items-center justify-between text-xs">
                        <span class="font-bold">Active Conversations</span>
                        <span class="flex items-center justify-center bg-gray-300 h-4 w-4 rounded-full">4</span>
                    </div>
                    <div class="flex flex-col space-y-1 mt-4 -mx-2 h-48 overflow-y-auto">

                        @foreach ($users as $user)
                            <button id="user_{{ $user->id }}" data-receiver="{{ $user->id }}"
                                data-peer_id="{{ $user->peer_id }}" data-username="{{ $user->name }}"
                                class="user-chat flex flex-row items-center hover:bg-gray-100 rounded-xl p-2">
                                <div class="flex items-center justify-center h-8 w-8 bg-pink-200 rounded-full">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="ml-2 text-sm font-semibold">{{ $user->name }}</div>
                            </button>
                        @endforeach
                    </div>


                </div>
            </div>
            <div class="flex flex-col flex-auto h-full p-6">
                <div class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-gray-100 h-full p-4">
                    <div class="flex flex-row items-center h-16 rounded-xl bg-white w-full px-4">
                        <div id="chatUserName">
                            {{ $users[0]->name }}
                            {{-- <input type="hidden" id="receiver" value={{ $users[0]->id }}> --}}
                        </div>
                        <input type="hidden" id="receiver" value={{ $users[0]->id }}>
                        <div class="flex-grow ml-4">
                            <div id="make-call" style="cursor: pointer;"
                                class="flex items-center justify-center w-8 h-8 bg-green-500 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="white" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 10.75V6.5A2.5 2.5 0 015.5 4h3.25a2.5 2.5 0 012.5 2.5v.916c0 .648-.426 1.25-1.063 1.496l-1.066.428a11.05 11.05 0 005.558 5.558l.428-1.066a1.5 1.5 0 011.496-1.063H17.5A2.5 2.5 0 0120 15.25v3.25a2.5 2.5 0 01-2.5 2.5h-4.25C5.603 21 3 15.879 3 10.75z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div id="chatBoxArea" class="flex flex-col h-full overflow-x-auto mb-4">
                        <div class="flex flex-col h-full">
                            <div id="chat-row" class="grid grid-cols-12 gap-y-2">
                                @foreach ($messages as $message)
                                    @if ($message->sent_by === session('user_id'))
                                        @include('message.sent', ['message' => $message->message])
                                    @else
                                        @include('message.received', ['message' => $message->message])
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row items-center h-16 rounded-xl bg-white w-full px-4">
                        <div>
                            <button class="flex items-center justify-center text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex-grow ml-4">
                            <div class="relative w-full">
                                <input id="message" type="text"
                                    class="flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10" />
                                <button
                                    class="absolute flex items-center justify-center h-full w-12 right-0 top-0 text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="ml-4">
                            <input type="hidden" id="chatUserId">
                            <button id="send-message"
                                class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white px-4 py-1 flex-shrink-0">
                                <span>Send</span>
                                <span class="ml-2">
                                    <svg class="w-4 h-4 transform rotate-45 -mt-px" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (!session('user_loggedin'))
        @include('login-modal')
    @endif
    @include('call', ['sender_id' => session('user_id')])
</body>

</html>

<script>
    // CSRF Token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Load chats of user
    // const loggedInUserId = document.getElementById("user_id").value;
    const userElement = "#user_" + loggedInUserId;
    $(userElement).click(function(e) {
        $.ajax({
            url: '{{ route('loadMessages') }}',
            type: 'GET',
            data: {
                receiver: message
            },
            success: function(response) {
                console.log(response.data.message);
                $("#message").val('');
            },
            error: function(error) {
                console.error(error);
                alert(error);
            }
        });

    });

    // Submit Data
    $('#send-message').click(function(e) {
        e.preventDefault(); // Prevent default form submission
        $("#chatUserId").val($("#receiver").val())
        let message = $("#message").val();
        $("#message").val(''); //clearing input box
        const sentHtml = `<div class="col-start-6 col-end-13 p-3 rounded-lg">
    <div class="flex items-center justify-start flex-row-reverse">
        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
            A
        </div>
        <div class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
            <div>` + message + `</div>
        </div>
    </div>
</div>`;
        // if (JSON.parse(data.message).sent_by == loggedInUserId) {
        $('#chat-row').append(sentHtml);
        // }
        let chatUserId = $("#chatUserId").val();
        console.log(chatUserId);
        $.ajax({
            url: '{{ route('message.store') }}',
            type: 'POST',
            data: {
                message: message,
                receiver: chatUserId
            },
            success: function(response) {
                console.log(response.data.message);
                $("#message").val('');
            },
            error: function(error) {
                console.error(error);
                alert(error);
            }
        });
    });

    // Make a call
    $('#make-call').click(function(e) {
        $('#callModal').removeClass('hidden');
        $('#receiveCall').addClass('hidden');
        $("#chatUserId").val($("#receiver").val())
        let chatUserId = $("#chatUserId").val();
        console.log(chatUserId);
        console.log('called')
        $.ajax({
            url: '{{ route('make-call') }}',
            type: 'POST',
            data: {
                sender: loggedInUserId,
                receiver: chatUserId // TODO: hardcoded
            },
            success: function(response) {
                console.log(response.data);
                if (response.data.sender == loggedInUserId || response.data.receiver ==
                    loggedInUserId) {
                    let receiverPeerId = $("#receiverPeerId").val();
                    let callId = response.data.id
                    makeCall(receiverPeerId, callId);
                }
                $("#call_id").val(response.data.id);
            },
            error: function(error) {
                console.error(error);
                alert(error);
            }
        });
    });

    // Logout
    $('#logout').click(function(e) {
        $.ajax({
            url: '{{ route('logout') }}',
            type: 'POST',

            success: function(response) {
                console.log(response);
                $("#logout").addClass('hidden');
                window.location.reload();
            },
            error: function(error) {
                console.error(error);
                alert(error);
            }
        });
    });

    $("#invite").click(function(e) {
        navigator.clipboard.writeText($("#inviteLink").val());
    });

    $(".user-chat").click(function(e) {
        var userId = $(this).data(
            "receiver"); // Alternatively, $(this).attr("id").split("_")[1] to extract the numeric part
        var chatUserName = $(this).data("username");
        $("#chatUserName").text(chatUserName)
        $("#receiver").val(userId);
        var peerId = $(this).data("peer_id");
        $("#receiverPeerId").val(peerId);
        $.ajax({
            url: '{{ route('loadMessages') }}',
            type: 'GET',
            data: {
                receiver: userId
            },
            success: function(response) {
                var chatRow = $("#chat-row");
                chatRow.empty(); // Clear the existing messages

                // Populate the new messages
                response.data.forEach(function(message) {
                    if (message.sent_by == loggedInUserId) {
                        // Add sent message
                        chatRow.append(`
                        <div class="col-start-6 col-end-13 p-3 rounded-lg">
    <div class="flex items-center justify-start flex-row-reverse">
        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
            A
        </div>
        <div class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
            <div>` + message.message + `</div>
        </div>
    </div>
</div>
                    `);
                    } else {
                        // Add received message
                        chatRow.append(`
                        <div class="col-start-1 col-end-8 p-3 rounded-lg">
                                    <div class="flex flex-row items-center">
                                        <div
                                            class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                            A
                                        </div>
                                        <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                            <div>` + message.message + `</div>
                                        </div>
                                    </div>
                                </div>
                    `);
                    }
                });

            },
            error: function(error) {
                console.error(error);
                alert(error);
            }
        });
        // console.log(userId)
    });
</script>
