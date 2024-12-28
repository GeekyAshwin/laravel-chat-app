let audioStream;
async function makeCall() {
    const audioPlayer = $("#audioPlayer").get(0);
    try {
        audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });
        audioPlayer.srcObject = audioStream;
        audioPlayer.play();
        console.log('Call started');
        console.log(audioStream);
    } catch (error) {
        console.error('Error starting call:', error);
    }
}

async function receiveCall() {
    const audioPlayer = $("#audioPlayer").get(0);
    try {
        audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });
        audioPlayer.srcObject = audioStream;
        audioPlayer.play();
        console.log('Call received');
        console.log(audioStream);
    } catch (error) {
        console.error('Error receiving call:', error);
    }
}

function endCall() {
    if (audioStream) {
        audioStream.getTracks().forEach(track => track.stop());
        audioStream = null;
    }
    const audioPlayer = $("#audioPlayer").get(0);
    audioPlayer.srcObject = null;
    audioPlayer.pause();
    console.log('Call ended');
}
