<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, User } from '@/types';
import { Icon } from '@iconify/vue';
import { PageProps } from '@inertiajs/core';
import { Head, usePage, Link } from '@inertiajs/vue3';
import { useClipboard } from '@vueuse/core';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

defineProps({
    orderCount: {
        type: String,
        required: true,
    },
    revenue: {
        type: String,
        required: true,
    },
});

const pageProps = usePage().props as PageProps;
const user: User = pageProps?.auth?.user;

const { copy, copied, isSupported: isClipboardSupported } = useClipboard({ source: user.api_key });
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <div class="flex items-center gap-2">
                        <Icon icon="material-symbols:key-outline-rounded" class="size-5" />
                        <span class="font-semibold">Your public API key</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-sm">
                        {{ user.api_key }}
                        <button
                            v-if="isClipboardSupported"
                            @click="copy(user.api_key)"
                            class="rounded-md border border-gray-300 p-1 text-gray-500 transition-colors duration-200 ease-in-out hover:text-gray-700 disabled:opacity-50 dark:border-gray-600 dark:text-gray-400 dark:hover:text-gray-300"
                            :disabled="copied"
                        >
                            <Icon v-if="copied" icon="mdi:clipboard-check-multiple-outline" class="size-4" />
                            <Icon v-else icon="mdi:clipboard-multiple-outline" class="size-4" />
                        </button>
                    </div>
                </div>
                <div class="p-4 relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="flex items-center gap-2">
                        <Icon icon="tabler:transaction-dollar" class="size-5" />
                        <span class="font-semibold">
                            Transactions this week
                        </span>
                        <div class="grow text-right">
                            <Link :href="route('order.history')" class="text-xs underline">
                                View History
                            </Link>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        {{ orderCount }}
                    </div>
                </div>
                <div class="p-4 relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="flex items-center gap-2">
                        <Icon icon="tabler:moneybag-heart" class="size-5" />
                        <span class="font-semibold">
                            Revenue this week
                        </span>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        {{ revenue }} VND
                    </div>
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
