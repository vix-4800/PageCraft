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
            const config = useRuntimeConfig();
            const apiUrl: string = config.public.apiUrl;

            const response = await $fetch(
                `${apiUrl}/v1/page-configuration`
            ).catch((error) => error.data);

            const pageConfig: PageConfiguration = response.data;

            this.header = pageConfig.header;
            this.footer = pageConfig.footer;
            this.product_list = pageConfig.product_list;
        },
        async saveConfiguration({
            header,
            footer,
            product_list,
        }: PageConfiguration) {
            const config = useRuntimeConfig();
            const apiUrl: string = config.public.apiUrl;

            await $fetch(`${apiUrl}/v1/page-configuration`, {
                method: 'PUT',
                body: {
                    header: header,
                    footer: footer,
                    product_list: product_list,
                },
            });
        },
    },
});
