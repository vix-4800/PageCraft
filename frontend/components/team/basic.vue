<template>
    <div
        class="grid gap-6 mt-12 lg:grid-cols-4 md:grid-cols-3 max-md:justify-center"
    >
        <div
            v-for="member in teamMembers"
            :key="member.id"
            class="overflow-hidden border rounded-lg"
        >
            <nuxt-img :src="member.image" class="object-cover w-full h-56" />

            <div class="p-4">
                <h4 class="text-base font-bold text-gray-800">
                    {{ member.name }}
                </h4>
                <p class="mt-1 text-xs text-gray-800">
                    {{ member.role }}
                </p>

                <div class="mt-4 space-x-4">
                    <u-button
                        icon="mdi:facebook"
                        color="blue"
                        :to="member.facebook"
                        target="_blank"
                        :ui="{ rounded: 'rounded-full' }"
                    />

                    <u-button
                        icon="mdi:twitter"
                        color="blue"
                        :to="member.twitter"
                        target="_blank"
                        :ui="{ rounded: 'rounded-full' }"
                    />

                    <u-button
                        icon="mdi:instagram"
                        color="blue"
                        :to="member.instagram"
                        target="_blank"
                        :ui="{ rounded: 'rounded-full' }"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
defineProps({
    teamMembers: {
        type: Array,
        required: true,
    },
});
</script>
