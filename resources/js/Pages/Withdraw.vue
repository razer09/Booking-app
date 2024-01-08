<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
const form = useForm({
    amount: 0,
});
function deposit() {
    form.post(route('withdraw.post'), {
        onSuccess: () => form.amount = 0,
    });
}
</script>

<template>
    <AppLayout title="Withdraw">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Withdraw
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-2">
                    <h1 class="text-xl font-bold text-gray-800 uppercase ">Withdraw</h1>
                    <p class="mt-1 text-sm text-gray-600">Withdraw money from your account</p>
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
                    <PrimaryButton @click="deposit" class="w-full !block !text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Deposit
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
