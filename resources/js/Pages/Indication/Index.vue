<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimeDataTable from '@/Components/PrimeDataTable.vue';
import { Head, Link } from '@inertiajs/vue3';
import { IColumn, IndexData } from "@/types/index";

defineProps<{
    index: IndexData,
    columns?: IColumn[],
}>();
</script>

<template>
    <Head title="List Of Indication" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Indication</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="dark:bg-gray-800 overflow-hidden sm:rounded-lg min-h-table overflow-x-auto">
                    <PrimeDataTable :index="index" :columns="columns" :action="true">
                        <template #action="{ data }">
                            <Link
                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                :href="route('indication.show', data.id)">Show</Link>
                            <Link
                                class="mx-2 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                :href="route('indication.edit', data.id)">Edit</Link>
                            <Link
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                :href="route('indication.destroy', data.id)"
                                method="delete">Delete</Link>
                        </template>
                    </PrimeDataTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
