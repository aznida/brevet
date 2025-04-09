<template>
    <div class="relative">
        <button @click="isOpen = !isOpen" class="relative inline-flex items-center text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span v-if="unreadCount > 0" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                {{ unreadCount }}
            </span>
        </button>

        <div v-if="isOpen" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg overflow-hidden z-50">
            <div class="p-2">
                <div v-if="notifications.length === 0" class="px-4 py-3 text-sm text-gray-500">
                    No notifications
                </div>
                <template v-else>
                    <div v-for="notification in notifications" :key="notification.id" 
                         class="px-4 py-3 hover:bg-gray-50 cursor-pointer"
                         :class="{ 'bg-blue-50': !notification.read_at }"
                         @click="markAsRead(notification.id)">
                        <p class="text-sm text-gray-600">{{ notification.data.message }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ formatDate(notification.created_at) }}</p>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'

dayjs.extend(relativeTime)

export default {
    setup() {
        const notifications = ref([])
        const unreadCount = ref(0)
        const isOpen = ref(false)

        const fetchNotifications = async () => {
            try {
                const response = await axios.get('/api/notifications')
                notifications.value = response.data
                unreadCount.value = notifications.value.filter(n => !n.read_at).length
            } catch (error) {
                console.error('Error fetching notifications:', error)
            }
        }

        const markAsRead = async (id) => {
            try {
                await axios.post(`/api/notifications/${id}/read`)
                await fetchNotifications()
            } catch (error) {
                console.error('Error marking notification as read:', error)
            }
        }

        const formatDate = (date) => {
            return dayjs(date).fromNow()
        }

        onMounted(() => {
            fetchNotifications()
            setInterval(fetchNotifications, 60000) // Poll every minute
        })

        return {
            notifications,
            unreadCount,
            isOpen,
            markAsRead,
            formatDate
        }
    }
}
</script>