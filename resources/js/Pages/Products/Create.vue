<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    categories: Array,
});

const form = useForm({
    name: '',
    sku: '',
    description: '',
    price: '',
    cost_price: '',
    quantity: 0,
    category_id: '',
    image: null,
    status: 'active',
});

const submit = () => {
    form.post(route('products.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const previewImage = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
    }
};
</script>

<template>
    <Head title="Créer un produit" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Créer un produit
                </h2>
                <Link
                    :href="route('products.index')"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Retour à la liste
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- Nom du produit -->
                                <div>
                                    <InputLabel for="name" value="Nom du produit" />
                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.name"
                                        required
                                        autofocus
                                    />
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <!-- SKU -->
                                <div>
                                    <InputLabel for="sku" value="SKU" />
                                    <TextInput
                                        id="sku"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.sku"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.sku" />
                                </div>

                                <!-- Prix de vente -->
                                <div>
                                    <InputLabel for="price" value="Prix de vente" />
                                    <TextInput
                                        id="price"
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        class="mt-1 block w-full"
                                        v-model="form.price"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.price" />
                                </div>

                                <!-- Prix d'achat -->
                                <div>
                                    <InputLabel for="cost_price" value="Prix d'achat" />
                                    <TextInput
                                        id="cost_price"
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        class="mt-1 block w-full"
                                        v-model="form.cost_price"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.cost_price" />
                                </div>

                                <!-- Quantité -->
                                <div>
                                    <InputLabel for="quantity" value="Quantité" />
                                    <TextInput
                                        id="quantity"
                                        type="number"
                                        min="0"
                                        class="mt-1 block w-full"
                                        v-model="form.quantity"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.quantity" />
                                </div>

                                <!-- Catégorie -->
                                <div>
                                    <InputLabel for="category_id" value="Catégorie" />
                                    <select
                                        id="category_id"
                                        v-model="form.category_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    >
                                        <option value="" disabled>Sélectionnez une catégorie</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">
                                            {{ category.name }}
                                        </option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.category_id" />
                                </div>

                                <!-- Statut -->
                                <div>
                                    <InputLabel for="status" value="Statut" />
                                    <select
                                        id="status"
                                        v-model="form.status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    >
                                        <option value="active">Actif</option>
                                        <option value="inactive">Inactif</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.status" />
                                </div>

                                <!-- Image -->
                                <div>
                                    <InputLabel for="image" value="Image" />
                                    <input
                                        type="file"
                                        id="image"
                                        @change="previewImage"
                                        class="mt-1 block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500"
                                        accept="image/*"
                                    />
                                    <InputError class="mt-2" :message="form.errors.image" />
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <InputLabel for="description" value="Description" />
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    rows="4"
                                ></textarea>
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>

                            <div class="flex items-center justify-end">
                                <PrimaryButton :disabled="form.processing" class="ml-4">
                                    Créer le produit
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>