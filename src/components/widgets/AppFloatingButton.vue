<template>
    <a v-if="widgetData.widget_data.active" :href="`https://wa.me/${getPhone()}`" :class="getPosition()" class="floatingButton" target="_blank">
        <img src="@/assets/img/widgets/whatsAppIcon.png" alt="Icon do WhatsApp">
    </a>
</template>

<script>
import { widgetStore } from '@/store/widgetStore';
import { siteInfoStore } from '@/store/siteInfoStore';

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
        },

        getPhone() {
            return this.widgetData.widget_data.useBasicInformationPhone ? siteInfoStore.constants.phone : this.widgetData.widget_data.phone
        }
    }
}
</script>

<style scoped>
.floatingButton {
    position: fixed;
    bottom: 20px;
    width: 40px;
    height: 40px;
    object-fit: cover;
    transition: 0.2s ease-in;
}

.floatingButton:hover {
    width: 45px;
    height: 45px;
}

.floatingButton--right {
    right: 20px;
}

.floatingButton--left {
    left: 20px;
}

.floatingButton img{
    width: 100%;
}

</style>