import Echo from 'laravel-echo';

console.log('Bootstrap loaded'); // Debugging

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: 'tsth2-key',
    wsHost: '127.0.0.1',
    wsPort: 6001,
    forceTLS: false,
    enabledTransports: ['ws'],
    disableStats: true
});
