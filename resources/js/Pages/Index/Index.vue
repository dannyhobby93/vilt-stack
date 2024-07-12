<template>
    <div>Index</div>
    <div>Message is {{ message }}</div>
    <Link href="/hello">Show Page</Link>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    message: String,
});
</script>
