<template>
    <div class="w-full py-8 mt-20 bg-white border-t border-gray-200">
        <div
            class="flex flex-col justify-between max-w-5xl gap-8 px-4 mx-auto md:flex-row"
        >
            <div class="flex flex-col gap-1 text-sm text-gray-600">
                <span class="font-medium">Навигация</span>
                <nuxt-link
                    v-for="page in footerPages"
                    :key="page.name"
                    :to="page.href"
                    class="hover:underline"
                >
                    {{ page.name }}
                </nuxt-link>
            </div>
            <div class="flex flex-col gap-1 text-sm text-gray-600">
                <span class="font-medium">Контакты</span>
                <nuxt-link :to="`tel:${footerContacts.phone}`">
                    Тел.: {{ footerContacts.phone }}
                </nuxt-link>
                <div class="flex gap-3 mt-2">
                    <u-button
                        v-for="socialLink in settingsStore.getSocialLinks()"
                        :key="socialLink.key"
                        :to="socialLink.value"
                        :icon="socialLink.icon"
                        color="white"
                        target="_blank"
                        class="hover:text-gray-700"
                        aria-label="Instagram"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
const settingsStore = useSiteSettingsStore();
const appName: string = useRuntimeConfig().public.appName;

defineProps({
    footerPages: {
        type: Array as () => {
            name: string;
            href: string;
        }[],
        required: true,
    },
    footerContacts: {
        type: Object as () => {
            email: string;
            phone: string;
            address: string;
        },
        required: true,
    },
});
</script>
