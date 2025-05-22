import { defineStore } from 'pinia';
import type { SiteTemplate, TemplateBlock } from '~/types/template';

export const useSiteTemplatesStore = defineStore('templates', {
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
        async setTemplateForBlock(name: TemplateBlock, template: string) {
            const templateIndex = this.templates.findIndex(
                (template) => template.name === name
            );

            if (templateIndex === -1) return;

            this.templates[templateIndex].template = template;
        },
        setTemplates(templates: SiteTemplate[]) {
            this.templates = templates;
        },
        getTemplate(name: TemplateBlock) {
            return this.templates.find((template) => template.name === name)
                ?.template;
        },
        isBlockVisible(name: TemplateBlock) {
            return this.templates.find((template) => template.name === name)
                ?.is_visible;
        },
    },
    persist: true,
});
