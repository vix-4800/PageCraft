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
            const { data } = await apiFetch<{ data: PageConfiguration }>(
                `v1/page-configuration`
            );

            this.header = data.header;
            this.footer = data.footer;
            this.product_list = data.product_list;
        },
        async saveConfiguration(pageConfiguration: PageConfiguration) {
            await apiFetch(`v1/page-configuration`, {
                method: 'PUT',
                body: pageConfiguration,
            });
        },
    },
    persist: true,
});
