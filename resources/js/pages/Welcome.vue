<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
</script>

<template>
    <Head title="Welcome">
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
                    <div class="flex h-full flex-col">
                        <h1 class="mb-1 text-xl font-medium flex items-center gap-2">
                            <img src="@/assets/logo.png" alt="LOGO" class="size-8">
                            Mock Payment
                        </h1>

                        <p class="mt-8">
                            Welcome to Mock Payment! This is a demo payment page where you can test the payment process without making any real transactions.
                            <br />
                            <br />
                            To get started, simply click on the "Get Started" button below. You can use any of the available payment methods to complete your transaction.
                        </p>

                        <Link :href="route('dashboard')">
                            <Button class="mt-8 w-fit px-8">
                                Get Started
                            </Button>
                        </Link>
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
