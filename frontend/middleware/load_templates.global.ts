export default defineNuxtRouteMiddleware(async () => {
    const templateStore = useSiteTemplatesStore();

    if (templateStore.templates.length === 0) {
        await templateStore.fetch().catch(() => {
            throw new Error('Template fetch failed');
        });
    }
});
