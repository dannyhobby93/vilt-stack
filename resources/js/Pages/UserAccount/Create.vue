<template>
    <form @submit.prevent="register">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="name" class="label">Full Name</label>
                <input type="text" class="input" id="name" v-model="form.name" />
                <div class="input-error" v-if="form.errors.name">
                    {{ form.errors.name }}
                </div>
            </div>
            <div class="mt-4">
                <label for="email" class="label">Email address</label>
                <input type="text" class="input" id="email" v-model="form.email" />
                <div class="input-error" v-if="form.errors.email">
                    {{ form.errors.email }}
                </div>
            </div>
            <div class="mt-4">
                <label for="password" class="label">Password</label>
                <input type="password" class="input" id="password" v-model="form.password" />
                <div class="input-error" v-if="form.errors.password">
                    {{ form.errors.password }}
                </div>
            </div>
            <div class="mt-4">
                <label for="password_confirmation" class="label">Password Confirmation</label>
                <input type="password" class="input" id="password_confirmation" v-model="form.password_confirmation" />
                <div class="input-error" v-if="form.errors.password_confirmation">
                    {{ form.errors.password_confirmation }}
                </div>
            </div>
            <div class="mt-4">
                <button class="btn-primary w-full" type="submit">Create Account</button><div class="mt-2 text-center">
                    <Link :href="route('login')" class="text-sm text-gray-500">Already have an account? Login here</Link>
                </div>
            </div>
        </div>
    </form>
</template>
<script setup>
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null
})

const register = () => form.post(route('user-account.store'));
</script>