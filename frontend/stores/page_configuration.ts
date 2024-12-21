import { defineStore } from 'pinia';
import type { PageConfiguration } from '~/types/page_configuration';

export const usePageConfigurationStore = defineStore('page_configuration', {
    state: () => ({
        header: 'default',
        footer: 'default',
        product_list: 'default',
    }),
    actions: {
        async getConfig() {
            const apiUrl: string = useRuntimeConfig().public.apiUrl;

            const { data } = await $fetch<PageConfiguration>(
                `${apiUrl}/v1/page-configuration`,
                {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },
                }
            );

            this.header = data.header;
            this.footer = data.footer;
            this.product_list = data.product_list;
        },
        async saveConfiguration(pageConfiguration: PageConfiguration) {
            const apiUrl: string = useRuntimeConfig().public.apiUrl;

            await $fetch(`${apiUrl}/v1/page-configuration`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    Authorization: `Bearer ${useAuthStore().authToken}`,
                },
                body: pageConfiguration,
            });
        },
    },
    persist: true,
});
