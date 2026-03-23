import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: true
});

window.Echo.channel('notifications')
  .listen('.notification.new', (e) => {
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded shadow';
    toast.textContent = e.notification.data.message || 'New notification';
    document.body.appendChild(toast);
    setTimeout(()=>toast.remove(),4000);
  });
