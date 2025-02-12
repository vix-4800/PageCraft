import { defineStore } from 'pinia';
import type { ChangeRecord } from '~/types/template-change-record';

export const useEditModeStore = defineStore('edit_mode', {
    state: () => ({
        enabled: false,
        hasChanges: false,
        history: [] as ChangeRecord[],
    }),
    actions: {
        toggle() {
            this.enabled = !this.enabled;
        },
        async save() {
            await useSiteTemplatesStore().save();

            this.hasChanges = false;
            this.history = [];
            this.enabled = false;
        },
        async resetChanges() {
            await useSiteTemplatesStore().fetch();

            this.hasChanges = false;
            this.history = [];
        },
        addToHistory(record: Omit<ChangeRecord, 'id'>) {
            this.hasChanges = true;

            this.history.unshift({
                id: crypto.randomUUID(),
                ...record,
            });
        },
    },
});
