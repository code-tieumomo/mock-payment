<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
import { onBeforeUnmount, onMounted, ref } from 'vue';

const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
});

const redirectAfter = ref(15);
const redirectInterval = ref(0);

onMounted(() => {
    redirectInterval.value = setInterval(() => {
        redirectAfter.value -= 1;
        if (redirectAfter.value <= 0) {
            clearInterval(redirectInterval.value);
            window.location.href = props.order.success_url;
        }
    }, 1000);
});

onBeforeUnmount(() => {
    clearInterval(redirectInterval.value);
});
</script>

<template>
    <Head title="Success">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] dark:bg-[#0a0a0a] lg:justify-center lg:p-8">
        <div class="duration-750 starting:opacity-0 flex w-full items-center justify-center opacity-100 transition-opacity lg:grow">
            <main
                class="flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg border border-gray-300 dark:border-gray-50 lg:max-w-4xl lg:flex-row"
            >
                <div
                    class="flex-1 rounded-bl-lg rounded-br-lg bg-white p-12 dark:bg-[#161615] dark:text-[#EDEDEC] lg:rounded-br-none lg:rounded-tl-lg"
                >
                    <div v-if="$page.props.order.status === 'paid'" class="flex h-full flex-col">
                        <h1 class="mb-1 text-3xl font-medium flex items-center gap-2 text-green-600">
                            <Icon icon="material-symbols:check-circle-outline" />
                            Success
                        </h1>
                        <p class="mt-8">
                            Your payment has been successfully completed. You will receive an email confirmation shortly with the details of your
                            order.
                        </p>
                        <p class="mt-4">Thank you for your purchase!</p>
                        <div class="grow mt-4 flex items-end">
                            <div class="flex items-center gap-2 text-sm">
                                <Icon icon="svg-spinners:bars-rotate-fade" class="text-indigo-600" />
                                Back to your website
                                <template v-if="redirectAfter > 0">
                                    after {{ redirectAfter }} seconds
                                </template>
                                <template v-else>
                                    now
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="p-4 relative -mb-px aspect-[335/376] w-full shrink-0 overflow-hidden rounded-t-lg bg-white lg:-ml-px lg:mb-0 lg:aspect-auto lg:w-[438px] lg:rounded-r-lg lg:rounded-t-none"
                >
                    <img
                        src="https://img.freepik.com/free-vector/credit-card-payment-concept-landing-page_52683-24768.jpg?t=st=1743280927~exp=1743284527~hmac=c6369f1b11c0741e101f11a257f710a10ce4efb91b9a1ed381ee89528df1ec52&w=1380"
                        alt=""
                    />
                </div>
            </main>
        </div>
        <div class="h-14.5 hidden lg:block"></div>
    </div>
</template>
