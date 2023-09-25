<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RuleForm from './Partials/RuleForm.vue';
import { Head } from '@inertiajs/vue3';

interface Problem {
    code: string;
}

interface Indication {
    code: string;
}

interface Rule {
    id: number
    problem: Problem,
    problem_code: string,
    indication_codes: Indication[],
    indication: Indication[]
}

defineProps<{
    problems: Problem[],
    indication: Indication[],
    rule: Rule | null
}>();
</script>

<template>
    <Head title="Problem Form" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Rule {{ rule?.problem_code ?? "Form" }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <RuleForm class="max-w-xl" :problems="problems" :indication="indication" :rule="rule"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
