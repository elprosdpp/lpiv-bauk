const app = require('http').createServer();
const io = require('socket.io')(app, {
    cors: {
        origin: '*'
    }
});
const createTerminal = require('./terminal');

io.on('connection', (socket) => {
    createTerminal(socket);
});

app.listen(3000, () => {
    console.log('Server listening on port 3000');
});
