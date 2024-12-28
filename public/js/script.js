async function makeCall() {
    const audioPlayer = $("#audioPlayer").get(0); // Get the raw DOM element from jQuery
    audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });

    // Play the captured audio
    audioPlayer.srcObject = audioStream;
    audioPlayer.play();
    console.log('call started')
    console.log(audioStream);

}


async function receiveCall() {
    const audioPlayer = $("#audioPlayer").get(0); // Get the raw DOM element from jQuery
    audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });

    // Play the captured audio
    audioPlayer.srcObject = audioStream;
    audioPlayer.play();
    console.log('call received')
    console.log(audioStream);

}


function endCall() {

}
