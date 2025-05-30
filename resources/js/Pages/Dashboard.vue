<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import OnlineUsers from '@/Components/OnlineUsers.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const isAdmin = computed(() => {
    return page.props.auth.user.roles && page.props.auth.user.roles.some(role => role.name === 'admin');
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>
                </div>
                
                <!-- Composant OnlineUsers visible uniquement pour les administrateurs -->
                <div v-if="isAdmin" class="mt-6">
                    <OnlineUsers />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
