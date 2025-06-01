<template>
    <header class="flex justify-between bg-gray-500 text-white px-3 pt-3 pb-3">
        <div class="brand">
            Real-time Notifications
        </div>
        <div class="notifications relative">
            <a href="#" @click.prevent="toggleNotifications" title="notifications">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                </svg>
            </a>

            <div class="dropdown absolute top-[37px] right-0 bg-blue-400 w-[230px] px-2 py-2 max-h-[260px] overflow-y-auto" :class="{'hidden': !showNotifications}">
                <ul v-if="notifications.length">
                    <li v-for="notification in notifications" :key="notification.id" class="mb-3 pb-1 border-b bg-gray-200 rounded text-black px-2">
                        <div>
                            <span class="pe-1" :class="notification.icon"></span>
                            <span class="text-sm">{{ notification.message }}</span>
                        </div>
                        <time>
                            <span class="fa fa-clock text-xs"></span> <span class="text-xs">{{ notification.formatted_time }}</span>
                        </time>
                    </li>
                </ul>
                <ul v-else>
                    <li>No notifications</li>
                </ul>
            </div>
        </div>
    </header>
    <div class="mx-4 my-5">
        <h3>Real-time Notifications with Laravel Reverb</h3>
        <p>Watch for notifications</p>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Echo from 'laravel-echo';  // Make sure Echo is imported
import axios from "axios";

const showNotifications = ref(false);
const notifications = ref([]);

const toggleNotifications = () => {
    showNotifications.value = !showNotifications.value;
};

// Fetch existing notifications from the backend
const getAllNotifications = () => {
    axios.get("/notifikasis").then(response => {
        if (response.data.data) {
            response.data.data.forEach(n => {
                notifications.value = [n, ...notifications.value];
            });
        }
    });
};

// Mark notification as read
const markNotificationAsRead = (id) => {
    axios.post(`/notifikasis/${id}/read`).then(() => {
        notifications.value = notifications.value.filter(n => n.id !== id);
    });
};

// Listen for real-time notifications using Laravel Echo
onMounted(() => {
    getAllNotifications();  // Load notifications on initial mount

    // Listen for notifications from the backend via Laravel Echo
    Echo.channel('stock-channel')
        .listen('.stock.minimum', (event) => {
            // Add notification to the list
            notifications.value = [{
                message: event.message,
                title: event.title,
                id: event.barang_id, // Use a unique ID for each notification
            }, ...notifications.value];

            // Show toast notification
            toast.success(event.message, {
                positionClass: 'toast-top-right',
                timeOut: 5000,
            });

            // Mark notification as read after it appears
            markNotificationAsRead(event.barang_id);
        });
});
</script>

<style scoped>
/* Add your custom styles here */
</style>
