import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// ---------------------------
// Laravel Echo & Pusher Setup
// ---------------------------

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY || '7b7225b1a5da9387b588',
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER || 'ap1',
    forceTLS: true,
    encrypted: true,
    // optional for localhost debugging
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    disableStats: true,
});

// ---------------------------
// Listen to IncidentReported event
// ---------------------------

window.Echo.channel('incidents')
    .listen('IncidentReported', (event) => {
        console.log('New incident reported:', event);

        // Dispatch a custom event so Blade JS can handle notification dropdown
        const notifEvent = new CustomEvent('new-incident', {
            detail: event
        });
        window.dispatchEvent(notifEvent);
    });
