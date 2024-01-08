<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
const {statments} = defineProps(['statments']);

function statmentType(statment){
    if (statment.type == 'deposit' || (statment.type == 'transfer' && usePage().props.auth.user.id == statment.recepiant?.id)) {
        return 'Credit';
    }
    return 'Debit';
}

// Statment Detail
function Detail(statment) {
    switch (statment.type) {
        case 'deposit':
            return 'Deposit';
        case 'withdraw':
            return 'Withdraw';
        case 'transfer':
            if (usePage().props.auth.user.id == statment.recepiant?.id) {
                return 'Transferm From ' + statment.user.email;
            }
            return 'Transferm To ' + statment.recepiant?.email;
        default:
            return 'Unknown';
    }
}

function Balance(statment) {
    let isRecipiant = (usePage().props.auth.user.id == statment.recepiant?.id);
    if ((statment.type == 'transfer') && isRecipiant) {
        return statment.recepient_balance;
    }
    return statment.balance;
}
</script>

<template>
    <AppLayout title="Statments">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Statments
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 py-10">
                    <h1 class="text-xl font-bold text-gray-800 uppercase ">Statment of your account</h1>
                    <section class="container px-4 mx-auto">
                        <div class="flex flex-col mt-6">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle px-4">
                                    <div class="overflow-hidden border border-gray-200 md:rounded-lg">

                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500">
                                                        <button class="flex items-center gap-x-3 focus:outline-none">
                                                            <span>#</span>
                                                        </button>
                                                    </th>

                                                    <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                                        Date Time
                                                    </th>

                                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                                        Amount
                                                    </th>

                                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">Type</th>

                                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">Detail</th>

                                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                                       Balance
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr v-for="(statment, index) in statments.data" :key="statment.id">
                                                    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                                        {{index + 1}}
                                                    </td>
                                                    <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                                        <div class="inline px-3 py-1 text-sm font-normal rounded text-emerald-700 gap-x-2 bg-emerald-100/60">
                                                            {{statment.created_at}}
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                                        <div class="inline px-3 py-1 text-sm font-normal rounded text-pink-700 gap-x-2 bg-pink-100/60">
                                                            {{statment.amount}}
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                                        {{statmentType(statment)}}
                                                    </td>

                                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                                        {{ Detail(statment) }}
                                                    </td>

                                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                                        <div class="inline px-3 py-1 text-sm font-normal rounded text-blue-700 gap-x-2 bg-blue-100/60">
                                                            {{ Balance(statment)}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <Pagination :links="statments.links" />
                    </section>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
