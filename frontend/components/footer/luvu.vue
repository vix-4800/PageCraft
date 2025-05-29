<template>
    <div class="bg-[#ededed] pt-14 pb-7 px-6 mt-10">
        <div
            class="flex flex-col justify-between gap-8 mx-auto max-w-7xl md:flex-row"
        >
            <div>
                <span class="block mb-2 text-2xl font-bold tracking-widest">
                    {{ appName }}
                </span>
                <div class="flex flex-col gap-1 mt-3 text-sm text-gray-600">
                    <nuxt-link
                        v-for="page in footerPages"
                        :key="page.name"
                        :to="page.href"
                        class="hover:underline"
                    >
                        {{ page.name }}
                    </nuxt-link>
                </div>
            </div>
            <div class="flex flex-col gap-1 mt-1 text-sm text-gray-600">
                <a href="#" class="hover:underline">Instagram</a>
                <a href="#" class="hover:underline">Pinterest</a>
                <a href="#" class="hover:underline">Telegram</a>
            </div>
            <div class="flex flex-col gap-1 mt-1 text-sm text-gray-600">
                <div>Сотрудничество: {{ footerContacts.email }}</div>
                <a href="#" class="hover:underline">Доставка</a>
                <a href="#" class="hover:underline">Способ оплаты</a>
            </div>
        </div>
        <div
            class="flex items-center justify-center gap-2 mt-8 text-lg font-medium text-center text-gray-700"
        >
            <svg width="24" height="24" fill="none">
                <path
                    d="M12 20s-7-4.35-7-9.5A4.5 4.5 0 0112 6.5a4.5 4.5 0 017 4.5c0 5.15-7 9.5-7 9.5z"
                    stroke="#888"
                    stroke-width="1.5"
                />
            </svg>
            THE MOMENT YOU ACCEPT YOURSELF, YOU BECOME BEAUTIFUL
            <svg width="24" height="24" fill="none">
                <path
                    d="M12 20s-7-4.35-7-9.5A4.5 4.5 0 0112 6.5a4.5 4.5 0 017 4.5c0 5.15-7 9.5-7 9.5z"
                    stroke="#888"
                    stroke-width="1.5"
                />
            </svg>
        </div>
    </div>
</template>

<script lang="ts" setup>
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
