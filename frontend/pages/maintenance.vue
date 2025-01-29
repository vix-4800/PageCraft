<template>
    <div
        class="flex flex-col items-center justify-center w-full gap-5 lg:pt-[180px] pt-12 lg:pb-28 pb-12"
    >
        <div class="flex flex-col items-center justify-center w-full gap-6">
            <div
                class="w-full flex-col justify-start items-center gap-2.5 flex"
            >
                <h2
                    class="text-3xl font-bold leading-normal text-center text-gray-800 font-manrope"
                >
                    {{ maintenanceTitle }}
                </h2>
                <p
                    class="text-base font-normal leading-relaxed text-center text-gray-500"
                >
                    {{ maintenanceMessage }}
                </p>
            </div>
        </div>
        <img
            src="https://pagedone.io/asset/uploads/1718004199.png"
            alt="under maintenance image"
            class="object-cover"
        />
    </div>
</template>

<script lang="ts" setup>
import { SettingKey } from '~/types/site_setting';

definePageMeta({
    layout: 'blank',
    middleware: [
        function () {
            const settingStore = useSiteSettingsStore();
            // const inMaintenance = settingStore.getSetting(SettingKey.Maintenance);

            // if (!inMaintenance) {
            //     return navigateTo('/');
            // }
        },
    ],
});

const settingStore = useSiteSettingsStore();

const maintenanceTitle = ref(
    "Please bear with us! We're currently under maintenance."
);
const maintenanceMessage = ref(
    "It's going to take some time to fix the error. We'll be back online as soon as possible."
);
</script>
