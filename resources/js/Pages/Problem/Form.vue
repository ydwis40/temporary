<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProblemForm from './Partials/ProblemForm.vue';
import { Head } from '@inertiajs/vue3';

interface Problem {
    id: number;
    name: string;
    code: string;
    solution: string;
}

defineProps<{
    problem: Problem | null
}>();
</script>

<template>
    <Head title="Problem Form" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Problem {{ problem?.code ?? "Form" }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <ProblemForm class="max-w-xl" :problem="problem"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
