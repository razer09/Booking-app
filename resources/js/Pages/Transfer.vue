<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
const form = useForm({
    amount: 0,
    email: '',
});
function deposit() {
    form.post(route('transfer.post'), {
        onSuccess: () => {
            form.amount = 0;
            form.email = '';
        },
    });
}
</script>

<template>
    <AppLayout title="Transfer">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                TRANSFER
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-2">
                    <h1 class="text-xl font-bold text-gray-800 uppercase ">Transfer</h1>
                    <p class="mt-1 text-sm text-gray-600">Transfer money to your firends</p>
                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="email"
                            placeholder="example@email.com"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div>
                        <InputLabel for="amount" value="Amount" />
                        <TextInput
                            id="amount"
                            v-model="form.amount"
                            type="number"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="amount"
                        />
                        <InputError class="mt-2" :message="form.errors.amount" />
                    </div>
                    <PrimaryButton @click="deposit" class="w-full !block !text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Deposit
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
