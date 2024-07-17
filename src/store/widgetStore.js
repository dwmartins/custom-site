import { reactive } from "vue";

export const widgetStore = reactive({
    widgets: [],
    widgetsLoaded: false,

    getWidgetByName(name) {
        return this.widgets.find(widget => widget.widget_name === name);
    },

    updateWidgetByName(name) {
        const widget = this.getWidgetByName(name);
        if (widget) {
            widget.widget_data = {
                ...widget.widget_data,
            };
        }
    },

    addWidget(newWidget) {
        newWidget.widget_data = JSON.parse(newWidget.widget_data);
        this.widgets.push(newWidget);
    }
})