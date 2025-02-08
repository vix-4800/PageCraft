import type { TemplateBlock } from '~/types/site_template';

export interface ChangeRecord {
    id: string;
    block: TemplateBlock;
    oldTemplate: string;
    newTemplate: string;
}
