let audioStream;
async function makeCall() {
    // const audioPlayer = $("#audioPlayer").get(0);
    // try {
    //     audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });
    //     audioPlayer.srcObject = audioStream;
    //     audioPlayer.play();
    //     console.log('Call started');
    //     console.log(audioStream);
    // } catch (error) {
    //     console.error('Error starting call:', error);
    // }

    var conn = peer.connect('another-peers-id');
// on open will be launch when you successfully connect to PeerServer
conn.on('open', function(){
  // here you have conn.id
  console.log('hello')
  conn.send('hi!');
});

    var getUserMedia = navigator.getUserMedia;
    getUserMedia(
        { audio: true },
        function (stream) {
            var call = peer.call("another-peers-id", stream);
            call.on("stream", function (remoteStream) {
                // Show stream in some video/canvas element.
                console.log(remoteStream);
            });
        },
        function (err) {
            console.log("Failed to get local stream", err);
        }
    );
}

async function receiveCall() {
    // const audioPlayer = $("#audioPlayer").get(0);
    // try {
    //     audioStream = await navigator.mediaDevices.getUserMedia({
    //         audio: true,
    //     });
    //     audioPlayer.srcObject = audioStream;
    //     audioPlayer.play();
    //     console.log("Call received");
    //     console.log(audioStream);
    // } catch (error) {
    //     console.error("Error receiving call:", error);
    // }
    var getUserMedia = navigator.getUserMedia ;
    peer.on("call", function (call) {
        getUserMedia(
            { audio: true },
            function (stream) {
                call.answer(stream); // Answer the call with an A/V stream.
                call.on("stream", function (remoteStream) {
                    // Show stream in some video/canvas element.
                    console.log(remoteStream)
                });
            },
            function (err) {
                console.log("Failed to get local stream", err);
            }
        );
    });
}

function endCall() {
    if (audioStream) {
        audioStream.getTracks().forEach((track) => track.stop());
        audioStream = null;
    }
    const audioPlayer = $("#audioPlayer").get(0);
    audioPlayer.srcObject = null;
    audioPlayer.pause();
    console.log("Call ended");
}
