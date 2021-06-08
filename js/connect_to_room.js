function sendMsg() {
    const socket = io("http://83.6.205.202:2077");
    socket.on('connect', function() {
        socket.emit("message", "HELLO WORLD");
    })
};