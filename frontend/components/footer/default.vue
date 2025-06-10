<template>
    <div class="p-10 tracking-wide bg-gradient-to-br from-gray-900 to-gray-700">
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <div class="lg:flex lg:items-center">
                <nuxt-link to="/" class="flex items-center gap-4 group">
                    <img
                        src="/logo.png"
                        :alt="appName"
                        width="40px"
                        height="40px"
                    />
                    <span
                        class="text-2xl font-bold text-white group-hover:text-yellow-500"
                    >
                        {{ appName }}
                    </span>
                </nuxt-link>
            </div>

            <div class="lg:flex lg:items-center">
                <ul class="flex space-x-1">
                    <li
                        v-for="socialLink in settingsStore.getSocialLinks()"
                        :key="socialLink.key"
                    >
                        <u-button
                            :to="socialLink.value"
                            size="xl"
                            :icon="socialLink.icon"
                            target="_blank"
                            class="bg-transparent hover:bg-transparent hover:text-yellow-500"
                        />
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="mb-6 text-lg font-semibold text-white">
                    Contact Us
                </h4>
                <ul class="space-y-4">
                    <li>
                        <nuxt-link
                            :to="`mailto:${footerContacts.email}`"
                            class="text-sm text-gray-300 hover:text-yellow-500"
                        >
                            Email
                        </nuxt-link>
                    </li>
                    <li>
                        <nuxt-link
                            :to="`tel:${footerContacts.phone}`"
                            class="text-sm text-gray-300 hover:text-yellow-500"
                        >
                            Phone
                        </nuxt-link>
                    </li>
                    <li>
                        <nuxt-link
                            :to="`https://maps.google.com/?q=${footerContacts.address}`"
                            target="_blank"
                            class="text-sm text-gray-300 hover:text-yellow-500"
                        >
                            Address
                        </nuxt-link>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="mb-6 text-lg font-semibold text-white">
                    Information
                </h4>
                <ul class="space-y-4">
                    <li v-for="page in footerPages" :key="page.name">
                        <nuxt-link
                            :to="page.href"
                            class="text-sm text-gray-300 hover:text-yellow-500"
                        >
                            {{ page.name }}
                        </nuxt-link>
                    </li>
                </ul>
            </div>
        </div>

        <p class="mt-10 text-sm text-gray-300">
            ©{{ appName }}. All rights reserved.
        </p>
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
