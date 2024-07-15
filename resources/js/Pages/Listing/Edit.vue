<template>
    <form @submit.prevent="update">
        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-2">
                <label class="label">Beds</label>
                <input v-model.number="form.beds" type="text" class="input" />
                <div v-if="form.errors.beds" class="input-error">
                    {{ form.errors.beds }}
                </div>
            </div>

            <div class="col-span-2">
                <label
                    class="block mb-1 text-gray-500 dark:text-gray-300 font-medium"
                    >Baths</label
                >
                <input
                    v-model.number="form.baths"
                    type="text"
                    class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"
                />
                <div v-if="form.errors.baths" class="input-error">
                    {{ form.errors.baths }}
                </div>
            </div>

            <div class="col-span-2">
                <label
                    class="block mb-1 text-gray-500 dark:text-gray-300 font-medium"
                    >Area</label
                >
                <input
                    v-model.number="form.area"
                    type="text"
                    class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"
                />
                <div v-if="form.errors.area" class="input-error">
                    {{ form.errors.area }}
                </div>
            </div>

            <div class="col-span-4">
                <label
                    class="block mb-1 text-gray-500 dark:text-gray-300 font-medium"
                    >City</label
                >
                <input
                    v-model="form.city"
                    type="text"
                    class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"
                />
                <div v-if="form.errors.city" class="input-error">
                    {{ form.errors.city }}
                </div>
            </div>

            <div class="col-span-2">
                <label
                    class="block mb-1 text-gray-500 dark:text-gray-300 font-medium"
                    >Post Code</label
                >
                <input
                    v-model="form.code"
                    type="text"
                    class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"
                />
                <div v-if="form.errors.code" class="input-error">
                    {{ form.errors.code }}
                </div>
            </div>

            <div class="col-span-4">
                <label
                    class="block mb-1 text-gray-500 dark:text-gray-300 font-medium"
                    >Street</label
                >
                <input
                    v-model="form.street"
                    type="text"
                    class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"
                />
                <div v-if="form.errors.street" class="input-error">
                    {{ form.errors.street }}
                </div>
            </div>

            <div class="col-span-2">
                <label
                    class="block mb-1 text-gray-500 dark:text-gray-300 font-medium"
                    >Street No.</label
                >
                <input
                    v-model.number="form.street_number"
                    type="text"
                    class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"
                />
                <div v-if="form.errors.street_number" class="input-error">
                    {{ form.errors.street_number }}
                </div>
            </div>

            <div class="col-span-6">
                <label
                    class="block mb-1 text-gray-500 dark:text-gray-300 font-medium"
                    >Price</label
                >
                <input
                    v-model.number="form.price"
                    type="text"
                    class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"
                />
                <div v-if="form.errors.price" class="input-error">
                    {{ form.errors.price }}
                </div>
            </div>

            <div class="col-span-6">
                <button type="submit" class="btn-primary">Update</button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    listing: Object,
});

const form = useForm({
    beds: props.listing.beds,
    baths: props.listing.baths,
    area: props.listing.area,
    city: props.listing.city,
    street: props.listing.street,
    code: props.listing.code,
    street_number: props.listing.street_number,
    price: props.listing.price,
});
const update = () => form.put(route("listing.update", listing.id));
</script>
