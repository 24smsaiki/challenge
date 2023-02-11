import "./index.css";

import App from "./App.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { createApp } from "vue";
import { createPinia } from "pinia";
import { fas } from "@fortawesome/free-solid-svg-icons";
import { library } from "@fortawesome/fontawesome-svg-core";
import router from "./router/Router";


library.add(fas);

const app = createApp(App).component("font-awesome-icon", FontAwesomeIcon);

app.use(router);
app.use(createPinia());
app.mount("#app");
