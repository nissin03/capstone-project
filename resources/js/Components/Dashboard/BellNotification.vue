<template>
    <div class="relative" ref="dropdownRef">

        <button @click="toggleDropdown" class="cursor-pointer relative p-2 rounded-lg text-stone-500
             hover:bg-stone-100
             transition-colors duration-200 ">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                </path>
            </svg>
            <span class="absolute top-1 -right-0.5 bg-red-500 text-white text-xs
               rounded-full size-4 flex items-center justify-center p-1.5">
                10
            </span>
        </button>


        <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100" leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <div v-if="isOpen" class="absolute right-0 mt-2 w-80 bg-white
               rounded-lg shadow-lg border border-stone-200
               z-50 max-w-sm">

                <div class="p-3 border-b border-stone-200  flex justify-between items-center">
                    <h3 class="font-semibold text-stone-900 ">
                        Notifications
                    </h3>
                    <button v-if="notifications.length > 0" @click="markAllAsRead" class="text-xs text-green-60
                   hover:text-green-700
                   transition-colors duration-200 hover:underline">
                        Mark all as read
                    </button>
                </div>

                <div class="max-h-64 overflow-y-auto">
                    <div v-if="notifications.length === 0" class="p-4 text-center">
                        <svg class="mx-auto size-12 text-stone-400  mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        <p class="text-sm text-stone-500">
                            No new notifications
                        </p>
                    </div>

                    <div v-for="notification in notifications" :key="notification.id"
                        @click="markAsRead(notification.id)" class="p-3 border-b border-stone-100 d
                   hover:bg-stone-50  cursor-pointer
                   transition-colors duration-200" :class="{
                    'bg-green-50 ': !notification.read_at,
                    'opacity-75': notification.read_at
                }">
                        <div class="flex items-start space-x-3">
                            <div v-if="!notification.read_at"
                                class="size-2 bg-green-500 rounded-full mt-2 flex-shrink-0"></div>
                            <div v-else class="size-2 bg-transparent rounded-full mt-2 flex-shrink-0"></div>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-stone-900 ">
                                    {{ notification.title }}
                                </p>
                                <p class="text-xs text-stone-600 mt-1">
                                    {{ notification.message }}
                                </p>
                                <span class="text-xs text-stone-500">
                                    {{ formatTime(notification.created_at) }}
                                </span>
                            </div>

                            <!-- Notification type icon -->
                            <div class="flex-shrink-0">
                                <component :is="getNotificationIcon(notification.type)"
                                    class="size-4 text-stone-400 " />
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="notifications.length > 0" class="p-3 border-t border-stone-200">
                    <button @click="loadMore" :disabled="loading" class="w-full text-center text-sm text-green-60
                   hover:text-green-700
                   transition-colors duration-200 hover:underline
                   disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                        <span v-if="loading">Loading...</span>
                        <span v-else>Load More</span>
                    </button>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import { ref, computed, onMounted, onUnmounted } from 'vue'

export default {
    name: 'NotificationBell',
    setup() {
        const isOpen = ref(false)
        const loading = ref(false)
        const dropdownRef = ref(null)
        const notifications = ref([
            {
                id: 1,
                title: 'New Comment on Dashboard',
                message: 'John Doe commented on your post',
                type: 'comment',
                read_at: null,
                created_at: new Date(Date.now() - 2 * 60 * 1000)
            },
            {
                id: 2,
                title: 'System Update',
                message: 'Your application has been updated to version 2.1.0',
                type: 'system',
                read_at: null,
                created_at: new Date(Date.now() - 15 * 60 * 1000)
            },
            {
                id: 3,
                title: 'New Message',
                message: 'You have received a new private message',
                type: 'message',
                read_at: new Date(),
                created_at: new Date(Date.now() - 60 * 60 * 1000)
            }
        ])

        const notificationCount = computed(() => {
            return notifications.value.filter(n => !n.read_at).length
        })

        const toggleDropdown = () => {
            isOpen.value = !isOpen.value
        }

        const closeDropdown = () => {
            isOpen.value = false
        }

        const markAsRead = (notificationId) => {
            console.log(`Would mark notification ${notificationId} as read`)
        }

        const markAllAsRead = () => {
            console.log('Would mark all notifications as read')
        }

        const loadMore = () => {
            console.log('Would load more notifications')
        }

        const formatTime = (date) => {
            const now = new Date()
            const diff = now - new Date(date)

            if (diff < 60000) return 'Just now'
            if (diff < 3600000) return `${Math.floor(diff / 60000)} mins ago`
            if (diff < 86400000) return `${Math.floor(diff / 3600000)} hours ago`
            return `${Math.floor(diff / 86400000)} days ago`
        }

        const getNotificationIcon = (type) => {
            const icons = {
                comment: 'ChatIcon',
                system: 'CogIcon',
                message: 'MailIcon',
                default: 'BellIcon'
            }
            return icons[type] || icons.default
        }

        const handleClickOutside = (event) => {
            if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
                closeDropdown()
            }
        }

        onMounted(() => {
            document.addEventListener('click', handleClickOutside)
        })

        onUnmounted(() => {
            document.removeEventListener('click', handleClickOutside)
        })

        return {
            isOpen,
            loading,
            dropdownRef,
            notifications,
            notificationCount,
            toggleDropdown,
            markAsRead,
            markAllAsRead,
            loadMore,
            formatTime,
            getNotificationIcon
        }
    }
}
</script>

<style scoped>
.max-h-64::-webkit-scrollbar {
    width: 4px;
}

.max-h-64::-webkit-scrollbar-track {
    background: transparent;
}

.max-h-64::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 2px;
}

.dark .max-h-64::-webkit-scrollbar-thumb {
    background: #475569;
}
</style>
