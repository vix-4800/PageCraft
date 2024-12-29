import { defineStore } from 'pinia';
import type { SiteTemplate, TemplateBlock } from '~/types/site_template';

export const useSiteTemplatesStore = defineStore('site_templates', {
    state: () => ({
        templates: [] as SiteTemplate[],
    }),
    actions: {
        async fetch() {
            const { data } = await apiFetch<{ data: SiteTemplate[] }>(
                `v1/site-templates`
            );

            this.setTemplates(data);
        },
        async save(templates: SiteTemplate[]) {
            const { data } = await apiFetch<{ data: SiteTemplate[] }>(
                `v1/site-templates`,
                {
                    method: 'PUT',
                    body: templates,
                }
            );

            this.setTemplates(data);
        },
        setTemplates(templates: SiteTemplate[]) {
            this.templates = templates;
        },
        getTemplate(block: TemplateBlock) {
            return this.templates.find((template) => template.block === block)
                ?.template;
        },
    },
    persist: true,
});
