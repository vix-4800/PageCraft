<template>
    <div v-if="article">
        <div class="pt-16 text-center">
            <p class="text-sm font-bold text-green-500 md:text-base">
                {{ article.created_at }} <span class="text-gray-900">/</span>
                {{ article.author.toUpperCase() }}
            </p>
            <h1 class="text-3xl font-bold break-normal md:text-5xl">
                {{ article.title }}
            </h1>
        </div>

        <img
            :src="article.image"
            :alt="article.title"
            class="container w-full mt-8 bg-white bg-cover rounded"
        />

        <div
            v-html="article.content"
            class="w-full max-w-full p-8 px-16 text-xl leading-normal prose text-gray-800 bg-white md:text-2xl"
        ></div>
    </div>
</template>

<script lang="ts" setup>
import type { Article } from '~/types/article';

defineProps({
    article: {
        type: Object as () => Article,
        required: true,
    },
});
</script>
