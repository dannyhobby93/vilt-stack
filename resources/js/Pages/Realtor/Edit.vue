<template>
    <form @submit.prevent="update">
        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-2">
                <label class="label">Beds</label>
                <input v-model.number="form.beds" type="text" class="input" />
                <ErrorMessage
                    v-if="form.errors.beds"
                    :error="form.errors.beds"
                />
            </div>

            <div class="col-span-2">
                <label class="label">Baths</label>
                <input v-model.number="form.baths" type="text" class="input" />
                <ErrorMessage
                    v-if="form.errors.baths"
                    :error="form.errors.baths"
                />
            </div>

            <div class="col-span-2">
                <label class="label">Area</label>
                <input v-model.number="form.area" type="text" class="input" />
                <ErrorMessage
                    v-if="form.errors.area"
                    :error="form.errors.area"
                />
            </div>

            <div class="col-span-4">
                <label class="label">City</label>
                <input v-model="form.city" type="text" class="input" />
                <ErrorMessage
                    v-if="form.errors.city"
                    :error="form.errors.city"
                />
            </div>

            <div class="col-span-2">
                <label class="label">Post Code</label>
                <input v-model="form.code" type="text" class="input" />
                <ErrorMessage
                    v-if="form.errors.code"
                    :error="form.errors.code"
                />
            </div>

            <div class="col-span-4">
                <label class="label">Street</label>
                <input v-model="form.street" type="text" class="input" />
                <ErrorMessage
                    v-if="form.errors.street"
                    :error="form.errors.street"
                />
            </div>

            <div class="col-span-2">
                <label class="label">Street No.</label>
                <input
                    v-model.number="form.street_number"
                    type="text"
                    class="input"
                />
                <ErrorMessage
                    v-if="form.errors.street_number"
                    :error="form.errors.street_number"
                />
            </div>

            <div class="col-span-6">
                <label class="label">Price</label>
                <input v-model.number="form.price" type="text" class="input" />
                <ErrorMessage
                    v-if="form.errors.price"
                    :error="form.errors.price"
                />
            </div>

            <div class="col-span-6">
                <button type="submit" class="btn-primary">Update</button>
            </div>
        </div>
    </form>
</template>

<script setup>
import ErrorMessage from "@/Components/UI/ErrorMessage.vue";
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
const update = () =>
    form.put(route("realtor.listing.update", props.listing.id));
</script>
