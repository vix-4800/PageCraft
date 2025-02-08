import { defineStore } from 'pinia';

export const useEditModeStore = defineStore('edit_mode', {
    state: () => ({
        enabled: false,
        hasChanges: false,
        history: [] as string[],
    }),
    actions: {
        toggle() {
            this.enabled = !this.enabled;

            if (!this.enabled && this.hasChanges) {
                this.resetChanges();
            }
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
        addToHistory(record: string) {
            this.hasChanges = true;
            this.history.unshift(record);
        },
    },
});
