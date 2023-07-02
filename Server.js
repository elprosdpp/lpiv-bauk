const app = require('http').createServer();
const io = require('socket.io')(app, {
    cors: {
        origin: '*'
    }
});
const pty = require("node-pty");
const Guacamole = require('guacamole-common-js');

io.on('connection', (socket) => {
    console.log('Client connected');

    const term = pty.spawn(process.platform === 'win32' ? 'cmd.exe' : 'bash', [], {
        name: 'xterm-color',
        // cols: 80,
        // rows: 30,
        cwd: process.cwd(),
        env: process.env,
    });

    socket.on('input', (data) => {
        if (term) {
            term.write(data);
            console.log('Received input:', data);
        }
    });

    term.onData((data) => {
        socket.emit('output', data);
    });

    socket.on('disconnect', () => {
        console.log('Client disconnected');
    });

});

app.listen(3000, () => {
    console.log('Server listening on port 3000');
});
