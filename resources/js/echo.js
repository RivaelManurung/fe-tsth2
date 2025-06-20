import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY || 'your-app-key',
    wsHost: import.meta.env.VITE_REVERB_HOST || '127.0.0.1',
    wsPort: import.meta.env.VITE_REVERB_PORT || 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT || 8080,
    scheme: import.meta.env.VITE_REVERB_SCHEME || 'http',
    enabledTransports: ['ws'],
    forceTLS: false,
    disableStats: true,
    auth: {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token'),
        },
    },
});

// Debug WebSocket
window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log('WebSocket Connected to Reverb');
});
window.Echo.connector.pusher.connection.bind('error', (err) => {
    console.error('WebSocket Error:', err);
});
window.Echo.connector.pusher.connection.bind('disconnected', () => {
    console.log('WebSocket Disconnected');
});