<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    product: Object,
});

// Fonction pour formater le prix
const formatPrice = (price) => {
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF' }).format(price);
};

// Calculer la marge bénéficiaire
const calculateMargin = () => {
    if (!props.product.cost_price || props.product.cost_price === 0) return 0;
    const margin = ((props.product.price - props.product.cost_price) / props.product.cost_price) * 100;
    return margin.toFixed(2);
};
</script>

<template>
    <Head :title="`Produit: ${product.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Détails du produit
                </h2>
                <div class="flex space-x-2">
                    <Link
                        :href="route('products.index')"
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Retour à la liste
                    </Link>
                    <Link
                        v-if="$page.props.auth.user.roles.some(role => ['admin', 'approvisionneur'].includes(role.name))"
                        :href="route('products.edit', product.id)"
                        class="inline-flex items-center rounded-md border border-transparent bg-yellow-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-yellow-700 focus:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 active:bg-yellow-900"
                    >
                        Modifier
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <!-- Image et informations de base -->
                            <div class="md:col-span-1">
                                <div class="overflow-hidden rounded-lg bg-gray-100 p-4">
                                    <div class="mb-4">
                                        <img 
                                            v-if="product.image" 
                                            :src="`/storage/${product.image}`" 
                                            alt="Product image" 
                                            class="mx-auto h-64 w-full rounded-lg object-cover"
                                        />
                                        <div v-else class="flex h-64 w-full items-center justify-center rounded-lg bg-gray-200">
                                            <span class="text-lg text-gray-500">Aucune image</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Informations rapides</h3>
                                        <div class="mt-2 space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-sm font-medium text-gray-500">SKU:</span>
                                                <span class="text-sm font-semibold text-gray-900">{{ product.sku }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm font-medium text-gray-500">Catégorie:</span>
                                                <span class="text-sm font-semibold text-gray-900">{{ product.category.name }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm font-medium text-gray-500">Statut:</span>
                                                <span 
                                                    :class="{
                                                        'px-2 py-1 text-xs font-semibold rounded-full': true,
                                                        'bg-green-100 text-green-800': product.status === 'active',
                                                        'bg-red-100 text-red-800': product.status === 'inactive'
                                                    }"
                                                >
                                                    {{ product.status === 'active' ? 'Actif' : 'Inactif' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Détails du produit -->
                            <div class="md:col-span-2">
                                <div class="mb-6">
                                    <h1 class="text-2xl font-bold text-gray-900">{{ product.name }}</h1>
                                    <p class="mt-2 text-gray-600">{{ product.description }}</p>
                                </div>
                                
                                <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="rounded-lg bg-blue-50 p-4">
                                        <h3 class="text-lg font-semibold text-blue-800">Prix de vente</h3>
                                        <p class="mt-2 text-2xl font-bold text-blue-900">{{ formatPrice(product.price) }}</p>
                                    </div>
                                    
                                    <div class="rounded-lg bg-green-50 p-4">
                                        <h3 class="text-lg font-semibold text-green-800">Prix d'achat</h3>
                                        <p class="mt-2 text-2xl font-bold text-green-900">{{ formatPrice(product.cost_price) }}</p>
                                    </div>
                                </div>
                                
                                <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div class="rounded-lg bg-purple-50 p-4">
                                        <h3 class="text-lg font-semibold text-purple-800">Quantité en stock</h3>
                                        <p class="mt-2 text-2xl font-bold text-purple-900">{{ product.quantity }}</p>
                                    </div>
                                    
                                    <div class="rounded-lg bg-amber-50 p-4">
                                        <h3 class="text-lg font-semibold text-amber-800">Marge bénéficiaire</h3>
                                        <p class="mt-2 text-2xl font-bold text-amber-900">{{ calculateMargin() }}%</p>
                                    </div>
                                    
                                    <div class="rounded-lg bg-indigo-50 p-4">
                                        <h3 class="text-lg font-semibold text-indigo-800">Valeur du stock</h3>
                                        <p class="mt-2 text-2xl font-bold text-indigo-900">{{ formatPrice(product.price * product.quantity) }}</p>
                                    </div>
                                </div>
                                
                                <!-- Stock par point de vente -->
                                <div v-if="product.stocks && product.stocks.length > 0" class="mt-8">
                                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Stock par point de vente</h3>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                        Point de vente
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                        Quantité
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 bg-white">
                                                <tr v-for="stock in product.stocks" :key="stock.id">
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                                        {{ stock.pointOfSale.name }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                        {{ stock.quantity }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>