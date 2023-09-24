<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

interface Indication {
    id: number;
    name: string;
    code: string;
}

defineProps<{
    indication: Indication
}>();
</script>

<template>
    <Head title="Indication Form" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Indication {{ indication.code
                ?? "Form" }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Name</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ indication.name }}
                            </p>
                        </header>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
