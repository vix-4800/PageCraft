import { defineStore } from 'pinia';
import type { SiteTemplate, TemplateBlock } from '~/types/site_template';

export const useSiteTemplatesStore = defineStore('site_templates', {
    state: () => ({
        templates: [] as SiteTemplate[],
    }),
    actions: {
        async fetch() {
            const { data } = await apiFetch<{ data: SiteTemplate[] }>(
                `v1/templates`
            );

            this.setTemplates(data);
        },
        async save(templates: SiteTemplate[]) {
            withPasswordConfirmation(
                async () => {
                    const { data } = await apiFetch<{ data: SiteTemplate[] }>(
                        `v1/templates`,
                        {
                            method: 'PUT',
                            body: templates,
                        }
                    );

                    this.setTemplates(data);
                },
                'Confirm site templates update',
                'Are you sure you want to save the changes?',
                false,
                'Templates saved successfully'
            );
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
