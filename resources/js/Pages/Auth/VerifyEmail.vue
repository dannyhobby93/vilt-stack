<template>
    <div>
        Your email address must be verified to access this page!
        <Link
            :href="route('verification.send')"
            method="post"
            as="button"
            class="text-indigo-600 dark:text-indigo-400"
            >Click here</Link
        >
        to resend verification email.
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>
