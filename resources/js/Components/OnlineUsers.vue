<script setup>
import { onMounted, ref } from 'vue';

const onlineUsers = ref([]);
const userCount = ref(0);

onMounted(() => {
    // Écouter le canal de présence pour les utilisateurs connectés
    window.Echo.join('presence.users')
        .here((users) => {
            onlineUsers.value = users;
            userCount.value = users.length;
            console.log('Users currently online:', users);
        })
        .joining((user) => {
            onlineUsers.value.push(user);
            userCount.value++;
            console.log('User joined:', user);
        })
        .leaving((user) => {
            onlineUsers.value = onlineUsers.value.filter(u => u.id !== user.id);
            userCount.value--;
            console.log('User left:', user);
        });

    // Écouter les notifications d'administrateur
    if (window.Echo) {
        window.Echo.private('admin.notifications')
            .listen('.user.logged.in', (e) => {
                console.log('User logged in event received:', e);
                // Vous pouvez ajouter une notification ici
            })
            .listen('.user.logged.out', (e) => {
                console.log('User logged out event received:', e);
                // Vous pouvez ajouter une notification ici
            });
    }
});
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900">Utilisateurs en ligne ({{ userCount }})</h3>
        <div class="mt-4">
            <div v-if="onlineUsers.length === 0" class="text-gray-500">
                Aucun utilisateur en ligne
            </div>
            <ul v-else class="divide-y divide-gray-200">
                <li v-for="user in onlineUsers" :key="user.id" class="py-3 flex items-center">
                    <div class="flex-shrink-0">
                        <span class="h-2 w-2 rounded-full bg-green-400 inline-block mr-2"></span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ user.name }}</p>
                        <p class="text-sm text-gray-500">{{ user.role }}</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>