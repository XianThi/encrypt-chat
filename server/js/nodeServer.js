var socket = require( 'socket.io' );
var express = require( 'express' );
var http = require( 'http' );
//var https = require( 'https' );
var fs= require('fs');

var app = express();

/*
var opts = {
	key : fs.readFileSync('/Applications/XAMPP/xamppfiles/apache2/conf/server.key'),
	cert : fs.readFileSync('/Applications/XAMPP/xamppfiles/apache2/conf/server.crt'),
	//ca : fs.readFileSync('/etc/ssl/certs/L1Kroot.pem'),
	requestCert : true,
	rejectUnauthorized : false
};
	
//var server = https.createServer(opts, app);
*/	
var server = http.createServer( app );

var io = socket.listen( server );
var connectedUsers = 0;
var userDetails = {};
io.sockets.on( 'connection', function( socket ) {

socket.on('userinfo', function( data ) {
    console.log(data);
	socket.userName = data.userinfo.myname;
    socket.userID = data.userinfo.myid;
});
	connectedUsers++;
	//console.log( "New client !" );
	userDetails[socket.id] = socket.userName;
	console.log(userDetails[socket.id] + ' user connected');
	io.sockets.connected[socket.id].emit('userData', {username: socket.userName});
	io.sockets.emit( 'allUsers', { userDetails: userDetails } );


   socket.on('disconnect', function() {
   		console.log(userDetails[socket.id] + ' user disconnected');
		delete(userDetails[socket.id]);
   })
	
	socket.on( 'message', function( data ) {
		console.log( 'Message received ' + socket.userName + ":" + data.message );
		console.log(socket);
		socket.emit( 'message', { name: socket.userName, message: data.message } );
		if(userDetails[data.recepient]) {
			io.sockets.connected[data.recepient].emit( 'message', { name: socket.userName, message: data.message } );
		}
	});

	socket.on( 'typing', function( data ) {
		console.log( 'User is typing ' + socket.userName + ":" + data.message );
		io.sockets.emit( 'typing', { name: socket.userName, message: data.message } );
	});
    


});

server.listen( 1334, function() {
	console.log('lisning to port 1334');
});