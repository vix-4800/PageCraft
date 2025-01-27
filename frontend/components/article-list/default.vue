<template>
    <div class="max-w-6xl mx-auto">
        <h2 class="mb-6 text-4xl font-extrabold text-gray-800">
            {{ title }}
        </h2>

        <div v-if="loading">
            <u-skeleton v-for="i in 6" :key="i" class="h-96 rounded-xl" />
        </div>
        <div
            v-if="!loading"
            class="grid grid-cols-1 gap-4 mx-auto md:grid-cols-2 lg:grid-cols-3 max-lg:max-w-3xl max-md:max-w-md"
        >
            <nuxt-link
                v-for="article in articles"
                :key="article.id"
                :to="`/articles/${article.slug}`"
                class="bg-white cursor-pointer rounded overflow-hidden shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] relative top-0 hover:-top-2 transition-all duration-300"
            >
                <nuxt-img
                    :src="article.image"
                    :alt="article.title"
                    class="object-cover w-full h-60"
                />

                <div class="p-6">
                    <span class="block mb-2 text-sm text-gray-400">
                        {{ article.created_at }} | BY
                        {{ article.author.toUpperCase() }}
                    </span>
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ article.title }}
                    </h3>
                    <hr class="my-4" />
                    <p class="text-sm text-gray-400">
                        {{ article.description }}
                    </p>
                </div>
            </nuxt-link>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Article } from '~/types/article';

defineProps({
    articles: {
        type: Array as () => Article[],
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    loading: {
        type: Boolean,
        default: false,
    },
});
</script>
