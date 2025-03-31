<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Order } from '@/types';
import { Icon } from '@iconify/vue';
import { Head } from '@inertiajs/vue3';
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible';
import { Button } from '@/components/ui/button';
import { ChevronsUpDown } from 'lucide-vue-next';

defineProps({
    orders: {
        type: Array as () => Order[],
        required: true,
    },
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'History',
        href: '/history',
    },
];
</script>

<template>
    <Head title="History" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">
            <div
                v-if="orders.length > 0"
                v-for="order in orders"
                :key="order.id"
                class="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border text-sm"
            >
                <div class="flex items-center gap-2">
                    <Icon v-if="order.status === 'paid'" icon="material-symbols:check-circle-outline-rounded" class="text-green-500" />
                    <Icon v-else icon="tabler:exclamation-circle" class="text-orange-500" />
                    <Badge :class="order.status === 'paid' ? 'bg-green-500 hover:bg-green-700' : 'bg-orange-500 hover:bg-orange-700'">
                        {{ order.status.toUpperCase() }}
                    </Badge>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-4">
                    <div class="col-span-1 font-bold">
                        <div class="w-fit border rounded-lg px-2 py-1" :class="order.status === 'paid' ? 'border-green-500' : 'border-orange-500'">
                            <span>Total amount:</span>
                            {{ order.grand_total }} {{ order.currency }}
                        </div>
                    </div>
                    <div class="col-span-1 flex items-center gap-2">
                        <span class="font-medium">Payment method:</span>
                        <img class="size-5" src="@/assets/momo.svg" alt="MOMO">
                    </div>
                    <div class="col-span-1">
                        <span class="font-medium">Created at:</span>
                        {{ order.created_at }}
                    </div>
                    <div class="col-span-1">
                        <span class="font-medium">Total discount:</span>
                        {{ order.total_discount }} {{ order.currency }}
                    </div>
                    <div class="col-span-1">
                        <span class="font-medium">Total tax:</span>
                        {{ order.total_tax }} {{ order.currency }}
                    </div>
                    <div class="col-span-1">
                        <span class="font-medium">Shipping cost:</span>
                        {{ order.shipping_cost }} {{ order.currency }}
                    </div>
                </div>
                <div class="relative mt-8 rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <div class="px-2 py-0.5 font-medium absolute -top-3 left-3 bg-gray-400 text-white rounded text-xs">
                        Order Detail
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <span class="font-medium">Order discount:</span>
                            {{ order.discount }} {{ order.currency }}
                        </div>
                        <div class="col-span-1">
                            <span class="font-medium">Order tax:</span>
                            {{ order.tax }} {{ order.currency }}
                        </div>
                    </div>
                </div>
                <div class="relative mt-8 rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <div class="px-2 py-0.5 font-medium absolute -top-3 left-3 bg-gray-400 text-white rounded text-xs">
                        Order Items
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <span class="font-medium">Total item's amount:</span>
                            {{ order.total_price }} {{ order.currency }}
                        </div>
                        <div class="col-span-1">
                            <span class="font-medium">Total item's discount:</span>
                            {{ order.total_item_discount }} {{ order.currency }}
                        </div>
                        <div class="col-span-1">
                            <span class="font-medium">Total item's tax:</span>
                            {{ order.total_item_tax }} {{ order.currency }}
                        </div>
                    </div>
                    <hr class="mt-4">
                    <Collapsible
                        v-for="item in order.order_items"
                        :key="item.id"
                        v-model:open="item.isOpen"
                        class="space-y-2 mt-4"
                    >
                        <div class="flex items-center justify-between space-x-4">
                            <h4 class="text-sm" :class="{ 'font-semibold': item.isOpen }">
                                {{ item.name }}
                            </h4>
                            <CollapsibleTrigger as-child>
                                <Button variant="ghost" size="sm" class="w-9 p-0">
                                    <ChevronsUpDown class="h-4 w-4" />
                                    <span class="sr-only">Toggle</span>
                                </Button>
                            </CollapsibleTrigger>
                        </div>
                        <CollapsibleContent class="space-y-2">
                            <div class="mt-3 relative rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                                <div class="px-2 py-0.5 font-medium absolute -top-3 left-3 bg-gray-400 text-white rounded text-xs">
                                    Item Detail
                                </div>
                                <div class="flex items-center gap-8">
                                    <img :src="item.thumbnail" alt="THUMBNAIL" class="h-16">
                                    <div class="grid grid-cols-3 grow gap-4">
                                        <div class="col-span-1">
                                            <span class="font-medium">Amount:</span>
                                            {{ item.total_price }} {{ order.currency }}
                                        </div>
                                        <div class="col-span-1">
                                            <span class="font-medium">Price:</span>
                                            {{ item.price }} {{ order.currency }}
                                        </div>
                                        <div class="col-span-1">
                                            <span class="font-medium">Quantity:</span>
                                            {{ item.quantity }}
                                        </div>
                                        <div class="col-span-1">
                                            <span class="font-medium">Discount:</span>
                                            {{ item.discount }} {{ order.currency }}
                                        </div>
                                        <div class="col-span-1">
                                            <span class="font-medium">Tax:</span>
                                            {{ item.tax }} {{ order.currency }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </CollapsibleContent>
                    </Collapsible>
                </div>
            </div>
            <div v-else>
                <div class="flex h-full items-center justify-center gap-2 rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <Icon icon="tabler:exclamation-circle" class="text-orange-500" />
                    <p class="text-sm">No orders found.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
