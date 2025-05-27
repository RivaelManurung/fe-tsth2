import './bootstrap';
import echo from './echo';
import Toastify from 'toastify-js';
import "toastify-js/src/toastify.css";

echo.channel('stock-channel')
    .listen('.stock.minimum', (e) => {
        Toastify({
            text: `${e.title}: ${e.message}`,
            duration: 5000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
        }).showToast();
    });
