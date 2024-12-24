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

            this.setConfiguration(data);
        },
        async saveConfiguration(pageConfiguration: PageConfiguration) {
            const { data } = await apiFetch<{ data: PageConfiguration }>(
                `v1/page-configuration`,
                {
                    method: 'PUT',
                    body: pageConfiguration,
                }
            );

            this.setConfiguration(data);
        },
        setConfiguration(pageConfiguration: PageConfiguration) {
            this.header = pageConfiguration.header;
            this.footer = pageConfiguration.footer;
            this.product_list = pageConfiguration.product_list;
        },
    },
    persist: true,
});
