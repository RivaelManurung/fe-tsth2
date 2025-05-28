import { io } from "socket.io-client";

const socket = io('ws://127.0.0.1:6001', {
  auth: {
    key: 'tsth2-key',
    secret: '8f2a9d15e43bd8a29c2e6b93d0e3a1e9',
  }
});

socket.on('connect', () => {
  console.log('Connected to Reverb WebSocket server');
});

socket.on('stock-channel:stock.minimum', (data) => {
  console.log('Received event:', data);
  alert(`Notif: ${data.title} - ${data.message}`);
});
