<template>
    <div v-if="reservationSummary" class="px-4 grid gap-3 grid-cols-12">
        <StatCard :amount="reservationSummary.totalAmount" :percentageChange="reservationSummary.percentageChange"
            :icon="reservationSummary.percentageChange >= 0 ? TrendingUp : TrendingDown" :date="'July 21, 2025'">
            Total Reservation
        </StatCard>

        <StatCard :amount="1200" :percentageChange="-5" :icon="TrendingUp" :date="'July 21, 2025'">
            Total Reserved Items
        </StatCard>
        <StatCard :amount="200" :percentageChange="-5" :date="'July 21, 2025'">
            Total Claimed Items
        </StatCard>

        <StatCard :amount="1200" :percentageChange="-5" :icon="TrendingUp" :date="'July 21, 2025'">
            Total Amount Claimed Items
        </StatCard>
        <StatCard :amount="50" :percentageChange="10" :icon="TrendingDown" :date="'July 21, 2025'">
            Total Canceled Order
        </StatCard>
        <StatCard :amount="1200" :percentageChange="-5" :icon="TrendingDown" :date="'July 21, 2025'">
            Total Amount of Canceled Order
        </StatCard>
    </div>
</template>

<script setup>
import StatCard from './StatCard.vue'
import { usePage } from '@inertiajs/vue3'
import { TrendingDown, TrendingUp } from 'lucide-vue-next'

const { props } = usePage();
const reservationSummary = props.reservationSummary
</script>
