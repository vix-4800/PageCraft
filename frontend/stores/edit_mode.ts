import { defineStore } from 'pinia';

export const useEditModeStore = defineStore('edit_mode', {
    state: () => ({
        enabled: false,
    }),
    actions: {
        toggle() {
            this.enabled = !this.enabled;
        },
        enable() {
            this.enabled = true;
        },
        disable() {
            this.enabled = false;
        },
    },
});
