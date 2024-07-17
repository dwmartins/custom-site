<template>
    <section id="publicLayout" class="position-relative" >
        <AppHeader />
        <main>
            <router-view></router-view>
        </main>
        <AppFooter />
        <AppFloatingButton />
    </section>
</template>

<script>
import AppFooter from '@/components/public/AppFooter.vue';
import AppHeader from '@/components/public/AppHeader.vue';
import AppFloatingButton from '@/components/widgets/AppFloatingButton.vue';
import WidgetService from '@/services/WidgetService';
import { widgetStore } from '@/store/widgetStore';

export default {
    name: 'PublicLayout',
    components: {
        AppFooter,
        AppHeader,
        AppFloatingButton
    },

    created() {
        this.loadWidgets();
    },

    methods: {
        async loadWidgets() {
            try {
                const response = await WidgetService.getWidgets();

                if(response.data) {
                    response.data.forEach(widget => {
                        widgetStore.addWidget(widget);
                    });
                }

                widgetStore.widgetsLoaded = true;
            } catch (error) {
                console.error('Erro ao carregar widgets:', error);
            }
        }
    }
};
</script>

<style>

</style>