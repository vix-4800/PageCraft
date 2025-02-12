import type { TemplateBlock } from '~/types/template';
import TemplateChange from '~/components/modals/template-change.vue';

export const useContextMenu = () => {
    const editModeStore = useEditModeStore();
    const modal = useModal();

    const isOpen = ref(false);
    const virtualElement = ref({ getBoundingClientRect: () => ({}) });
    const { x, y } = useMouse();
    const { y: windowY } = useWindowScroll();

    const openMenu = () => {
        if (!editModeStore.enabled) return;

        const top = unref(y) - unref(windowY);
        const left = unref(x);

        virtualElement.value.getBoundingClientRect = () => ({
            width: 0,
            height: 0,
            top,
            left,
        });

        isOpen.value = true;
    };

    const changeTemplate = (name: TemplateBlock) => {
        isOpen.value = false;

        modal.open(TemplateChange, {
            name,
        });
    };

    return {
        isOpen,
        virtualElement,
        openMenu,
        changeTemplate,
    };
};
