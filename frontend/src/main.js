import "./index.css";

import App from "./App.vue";
import { createApp } from "vue";
import { createPinia } from "pinia";
import router from "./router/Router";

const app = createApp(App);

app.use(router);
app.use(createPinia());
app.mount("#app");
