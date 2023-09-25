<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import MultiSelect from 'primevue/multiselect';
import AutoComplete from 'primevue/autocomplete';
import Dropdown from 'primevue/dropdown';

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

const props = defineProps<{
    problems: Problem[]
    indication: Indication[],
    rule: Rule | null
}>();

const problems = props.problems;
const indication = props.indication;

const newRule = {
    indication: props.rule ? props.rule.indication_codes : [],
    problem_code: props.rule?.problem_code ?? ''
}

const form = useForm(newRule);

const search = (event: any) => {
    setTimeout(() => {
        if (!event.query.trim().length) {
            form.indication = [...indication];
        } else {
            form.indication = indication.filter((indication) => {
                return indication.code.toLowerCase().startsWith(event.query.toLowerCase());
            });
        }
    }, 250);
}

const submit = () => {
    return props.rule ? form.put(route('rule.update', props.rule.id), {
        preserveScroll: true,
    }) : form.post(route('rule.store'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Rule</h2>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name" />

                <MultiSelect v-model="form.indication" display="chip" :options="indication" optionLabel="code" placeholder="Select Indicate"
                    :maxSelectedLabels="3" class="w-full md:w-20rem" />

                <InputError class="mt-2" :message="form.errors.indication" />
            </div>

            <div>
                <InputLabel for="solution" value="Solution" />

                <Dropdown v-model="form.problem_code" :options="problems" optionLabel="code" placeholder="Select Diagnose" class="w-full md:w-14rem" />

                <!-- <AutoComplete v-model="form.problem_code" :suggestions="problems" @complete="search" /> -->

                <InputError class="mt-2" :message="form.errors.problem_code" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Submit
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>
