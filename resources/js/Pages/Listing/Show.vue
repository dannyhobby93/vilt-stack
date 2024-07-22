<template>
    <div class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
        <Box
            v-if="listing.images.length"
            class="md:col-span-7 flex items-center"
        >
            <div class="grid grid-cols-2 gap-1">
                <img
                    v-for="image in listing.images"
                    :key="image.id"
                    :src="image.src"
                />
            </div>
        </Box>
        <EmptyState v-else class="md:col-span-7 flex items-center"
            >No Images</EmptyState
        >
        <div class="md:col-span-5 flex flex-col gap-4">
            <Box>
                <template #header>Basic Information</template>
                <Price :price="listing.price" class="text-2xl font-bold" />
                <ListingSpace :listing="listing" class="text-lg" />
                <ListingAddress :listing="listing" class="text-gray-500" />
            </Box>
            <Box>
                <template #header>Monthly Payment</template>
                <div>
                    <label class="label"
                        >Interest rate ({{ interestRate }}%)</label
                    >
                    <input
                        v-model.number="interestRate"
                        type="range"
                        min="0.1"
                        max="30"
                        step="0.1"
                        class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                    />
                    <label class="label">Duration ({{ duration }} years)</label>
                    <input
                        v-model.number="duration"
                        type="range"
                        min="3"
                        max="50"
                        step="1"
                        class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                    />
                    <div class="textgray-600 dark:text-gray-300 mt-2">
                        <div class="text-gray-400">Your monthly payment</div>
                        <Price :price="monthlyPayment" class="text-3xl" />
                    </div>
                    <div class="mt-2 text-gray-500">
                        <div class="justify-between flex">
                            <div>Total Paid</div>
                            <div>
                                <Price :price="totalPaid" />
                            </div>
                        </div>
                        <div class="justify-between flex">
                            <div>Principal Paid</div>
                            <div>
                                <Price :price="listing.price" />
                            </div>
                        </div>
                        <div class="justify-between flex">
                            <div>Interest Paid</div>
                            <div>
                                <Price :price="totalInterest" />
                            </div>
                        </div>
                    </div>
                </div>
            </Box>
            <MakeOffer
                v-if="user && !offerMade"
                @offer-updated="offer = $event"
                :listing-id="listing.id"
                :price="listing.price"
            />
            <OfferMade v-if="user && offerMade" :offer="offerMade" />
        </div>
    </div>
</template>
<script setup>
import ListingAddress from "@/Components/ListingAddress.vue";
import ListingSpace from "@/Components/ListingSpace.vue";
import Price from "@/Components/Price.vue";
import Box from "@/Components/UI/Box.vue";
import EmptyState from "@/Components/UI/EmptyState.vue";
import { useMonthlyPayment } from "@/Composables/useMonthlyPayment";

import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import MakeOffer from "./Show/Components/MakeOffer.vue";
import OfferMade from "./Show/Components/OfferMade.vue";

const interestRate = ref(2.5);
const duration = ref(25);
const props = defineProps({
    listing: Object,
    offerMade: Object,
});

const offer = ref(props.listing.price);

const { monthlyPayment, totalPaid, totalInterest } = useMonthlyPayment(
    offer,
    interestRate,
    duration,
);

const user = computed(() => usePage().props.user);
</script>
