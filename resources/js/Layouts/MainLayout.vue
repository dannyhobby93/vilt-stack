<template>
    <div>
        <nav>
            <Link :href="route('listing.index')">Listings</Link>
            <Link :href="route('listing.create')">New Listing</Link>
        </nav>
        <div v-if="flashSuccess" class="success">
            {{ flashSuccess }}
        </div>
        <slot />
    </div>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const flashSuccess = computed(() => usePage().props.flash.success);
</script>

<style scoped>
.success {
    background-color: green;
    color: white;
}
</style>
