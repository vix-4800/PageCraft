export const useVersionStore = defineStore('version', {
    state: () => ({
        current: {},
        latest: {},
    }),
    actions: {
        async fetch() {
            await apiFetch<{ data: { latest: Array; current: Array } }>(
                'v1/versions'
            )
                .then((response) => {
                    this.current = response.data.current;
                    this.latest = response.data.latest;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    getters: {
        updateAvailable: (state) => {
            return (
                state.latest.name !== state.current.name &&
                state.latest.name !== ''
            );
        },
        fetched: (state) => {
            return Object.keys(state.current).length > 0;
        },
    },
});
