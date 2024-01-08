<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap mt-6 -mb-1">
        <template v-for="(link, key) in links">
            <div v-if="link.url === null" :key="key" class="me-1 px-4 py-3 mb-1 text-sm text-gray-400 border rounded cursor-not-allowed" v-html="link.label" />
            <Link v-else class="me-1 hover:bg-white focus:border-main-color focus:text-main-color px-4 py-3 mb-1 text-sm border rounded" :class="{ 'bg-white': link.active, 'ms-auto': link.label === '{{Update }}' }" :href="link.url" v-html="link.label" />
        </template>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
export default {
    components: {
        Link,
    },
    props: {
        links: Array,
    },
}
</script>
