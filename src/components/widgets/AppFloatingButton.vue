<template>
    <a v-if="widgetData.widget_data.active" :href="`https://wa.me/${widgetData.widget_data.phone}`" :class="getPosition()" class="floatingButton" target="_blank">
        <img src="@/assets/img/widgets/whatsAppIcon.png" alt="Icon do WhatsApp">
    </a>
</template>

<script>
import { widgetStore } from '@/store/widgetStore';

export default {
    name: 'AppFloatingButton',

    data() {
        return {
            widgetName: 'floatingButton',
            widgetData: {
                id: null,
                widget_name: "",
                widget_data: {
                    active: false,
                    phone: "",
                    position: "right",
                    useBasicInformationPhone: false
                },
                createdAt: "",
                updatedAt: ""
            }
        }
    },

    created() {
        if(widgetStore.widgetsLoaded) {
            this.getWidget();
        } else {
            this.$watch(() => widgetStore.widgetsLoaded, (newValue) => {
                if (newValue) {
                    this.getWidget();
                }
            });
        }
    },

    methods: {
        getWidget() {
            const widget = widgetStore.getWidgetByName('floatingButton');
            this.widgetData = { ...widget };
            console.log(this.widgetData);
        },

        getPosition() {
            if(this.widgetData) {
                return {
                    'floatingButton--right': this.widgetData.widget_data.position === 'right',
                    'floatingButton--left': this.widgetData.widget_data.position === 'left',
                }
            }
        }
    }
}
</script>

<style scoped>
.floatingButton {
    position: fixed;
    bottom: 15px;
    width: 40px;
    height: 40px;
    object-fit: cover;
}

.floatingButton--right {
    right: 15px;
}

.floatingButton--left {
    left: 15px;
}

.floatingButton img{
    width: 100%;
}

</style>