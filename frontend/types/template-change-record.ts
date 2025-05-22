import type { TemplateBlock } from '~/types/template';

export interface ChangeRecord {
    id: string;
    name: TemplateBlock;
    oldTemplate: string;
    newTemplate: string;
}
