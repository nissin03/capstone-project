import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp, Link, Head, router } from "@inertiajs/vue3";
import NProgress from "nprogress";

import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import AppLayout from "./Layouts/AppLayout.vue";
import AdminLayout from "./Layouts/AdminLayout.vue";

let timeout = null;

router.on("start", () => {
    timeout = setTimeout(() => NProgress.start(), 250);
});

router.on("progress", (event) => {
    if (NProgress.isStarted() && event.detail.progress.percentage) {
        NProgress.set((event.detail.progress.percentage / 100) * 0.9);
    }
});
router.on("finish", (event) => {
    clearTimeout(timeout);
    if (!NProgress.isStarted()) return;

    if (event.detail.visit.completed) {
        NProgress.done();
    } else if (event.detail.visit.interrupted || event.detail.visit.cancelled) {
        NProgress.remove();
    }
});
createInertiaApp({
    title: (title) => `CvSU BaRG ${title}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        const isAdmin = name.startsWith("Admin/");
        page.default.layout =
            page.default.layout ?? (isAdmin ? AdminLayout : AppLayout);
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component("Link", Link)
            .component("Head", Head)
            .mount(el);
    },
    progress: {
        delay: 250,
        color: "#00c951",
        includeCSS: true,
        showSpinner: true,
    },
});
