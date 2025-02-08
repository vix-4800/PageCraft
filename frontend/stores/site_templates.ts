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
        async save() {
            withPasswordConfirmation(
                async () => {
                    const { data } = await apiFetch<{ data: SiteTemplate[] }>(
                        `v1/templates`,
                        {
                            method: 'PUT',
                            body: this.templates,
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
        async setTemplateForBlock(block: TemplateBlock, template: string) {
            const templateIndex = this.templates.findIndex(
                (template) => template.block === block
            );

            if (templateIndex === -1) return;

            this.templates[templateIndex].template = template;
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
