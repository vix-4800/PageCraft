<template>
    <div
        class="grid gap-6 mx-auto mt-16 md:grid-cols-2 lg:grid-cols-3 max-lg:gap-12 max-md:justify-center max-lg:max-w-3xl max-md:max-w-lg"
    >
        <div v-for="review in reviews" :key="review.id">
            <div class="flex flex-col items-center">
                <nuxt-img
                    :src="review.user.image"
                    class="w-24 h-24 border-2 border-purple-600 rounded-full"
                />
                <div class="mt-6">
                    <h4 class="text-sm font-bold text-gray-800">
                        {{ review.user.name }}
                    </h4>
                </div>
            </div>

            <div class="flex justify-center space-x-1 mt-2.5">
                <u-icon
                    v-for="i in review.rating"
                    :key="i"
                    name="mdi:star"
                    size="20"
                    class="text-yellow-400"
                />

                <u-icon
                    v-for="i in 5 - review.rating"
                    :key="i"
                    name="mdi:star"
                    size="20"
                    class="text-gray-400"
                />
            </div>

            <div class="mt-4">
                <p class="text-sm leading-relaxed text-gray-800">
                    {{ review.text }}
                </p>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
defineProps({
    reviews: {
        type: Array,
        required: true,
    },
});
</script>
