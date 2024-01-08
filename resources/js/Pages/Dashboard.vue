<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-4">
                   <p class="text-2xl font-semibold">Welcome {{ $page.props.auth.user.name }}!</p>
                   <hr>
                   <p>  <strong>User Id:</strong> 
                        <div class="inline ms-4 px-2 py-1 text-sm font-normal rounded text-blue-700 gap-x-2 bg-blue-100/60">
                        {{ $page.props.auth.user.email }}
                        </div>
                    </p>
                    <hr>
                   <p><strong>Your balance is:</strong> 
                        <div class="inline ms-4 px-2 py-1 text-sm font-normal rounded text-green-700 gap-x-2 bg-green-100/60">
                        ${{ $page.props.auth.user.balance }} 
                        </div>
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
