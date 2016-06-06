var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis');
var redis = new Redis();

redis.subscribe('test-channel');

redis.on('message', function(channel, message) {
    console.log(message);
    console.log(channel);
});

server.listen(3000);

console.log('Server is listening on port 3000..');