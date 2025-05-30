<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    products: Object,
    categories: Array,
    filters: Object,
    userRoles: Array,
});

const search = ref(props.filters.search || '');
const categoryId = ref(props.filters.category_id || '');
const status = ref(props.filters.status || '');

// Fonction pour formater le prix
const formatPrice = (price) => {
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF' }).format(price);
};

// Surveiller les changements dans les filtres et recharger la page
watch([search, categoryId, status], () => {
    window.history.pushState(
        {},
        '',
        route('products.index', {
            search: search.value,
            category_id: categoryId.value,
            status: status.value,
        })
    );
    
    // Recharger la page après un court délai pour éviter trop de requêtes
    const debounce = setTimeout(() => {
        window.location.reload();
    }, 500);
    
    return () => clearTimeout(debounce);
});
</script>

<template>
    <Head title="Produits" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Produits
                </h2>
                <Link
                    v-if="userRoles && (userRoles.includes('admin') || userRoles.includes('approvisionneur'))"
                    :href="route('products.create')"
                    class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-indigo-900"
                >
                    Ajouter un produit
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Filtres -->
                <div class="mb-6 bg-white p-4 shadow sm:rounded-lg sm:p-6">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Filtres</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <InputLabel for="search" value="Recherche" />
                            <TextInput
                                id="search"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="search"
                                placeholder="Nom ou SKU"
                            />
                        </div>
                        <div>
                            <InputLabel for="category" value="Catégorie" />
                            <select
                                id="category"
                                v-model="categoryId"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Toutes les catégories</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <InputLabel for="status" value="Statut" />
                            <select
                                id="status"
                                v-model="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Tous les statuts</option>
                                <option value="active">Actif</option>
                                <option value="inactive">Inactif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Liste des produits -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Image
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Nom
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            SKU
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Catégorie
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Prix
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Quantité
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Statut
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="product in products.data" :key="product.id">
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <img 
                                                v-if="product.image" 
                                                :src="`/storage/${product.image}`" 
                                                alt="Product image" 
                                                class="h-10 w-10 rounded-full object-cover"
                                            />
                                            <div v-else class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-xs text-gray-500">N/A</span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ product.name }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            {{ product.sku }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            {{ product.category.name }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            {{ formatPrice(product.price) }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            {{ product.quantity }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            <span 
                                                :class="{
                                                    'px-2 py-1 text-xs font-semibold rounded-full': true,
                                                    'bg-green-100 text-green-800': product.status === 'active',
                                                    'bg-red-100 text-red-800': product.status === 'inactive'
                                                }"
                                            >
                                                {{ product.status === 'active' ? 'Actif' : 'Inactif' }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <Link 
                                                    :href="route('products.show', product.id)" 
                                                    class="text-indigo-600 hover:text-indigo-900"
                                                >
                                                    Voir
                                                </Link>
                                                <Link 
                                                    v-if="$page.props.auth.user.roles.some(role => ['admin', 'approvisionneur'].includes(role.name))"
                                                    :href="route('products.edit', product.id)" 
                                                    class="text-yellow-600 hover:text-yellow-900"
                                                >
                                                    Modifier
                                                </Link>
                                                <Link 
                                                    v-if="$page.props.auth.user.roles.some(role => ['admin'].includes(role.name))"
                                                    :href="route('products.destroy', product.id)" 
                                                    method="delete"
                                                    as="button"
                                                    type="button"
                                                    class="text-red-600 hover:text-red-900"
                                                    @click.prevent="confirm('Êtes-vous sûr de vouloir supprimer ce produit ?') && $inertia.delete(route('products.destroy', product.id))"
                                                >
                                                    Supprimer
                                                </Link>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="products.data.length === 0">
                                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Aucun produit trouvé
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-4 flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Affichage de {{ products.from || 0 }} à {{ products.to || 0 }} sur {{ products.total }} résultats
                            </div>
                            <div class="flex space-x-2">
                                <Link 
                                    v-if="products.prev_page_url" 
                                    :href="products.prev_page_url"
                                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                >
                                    Précédent
                                </Link>
                                <Link 
                                    v-if="products.next_page_url" 
                                    :href="products.next_page_url"
                                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                >
                                    Suivant
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>