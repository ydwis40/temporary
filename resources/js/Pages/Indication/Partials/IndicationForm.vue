<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

interface Indication {
    id: number;
    name: string;
    code: string;
}

const props = defineProps<{
    indication: Indication | null
}>();

const newIndication = {
    name: props.indication?.name ?? '',
}

const form = useForm(newIndication);

const submit = () => {
    return props.indication ? form.put(route('indication.update', props.indication.id), {
        preserveScroll: true,
    }) : form.post(route('indication.store'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Indication</h2>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Submit
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>
