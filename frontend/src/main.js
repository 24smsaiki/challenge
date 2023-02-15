import "./index.css";

import {
  faCheck,
  faCirclePlus,
  faEye,
  faMessage,
  faPaperPlane,
  faPenToSquare,
  faRightFromBracket,
  faRobot,
  faTrash,
  faUsers,
  faXmark,
  fas,
} from "@fortawesome/free-solid-svg-icons";

import App from "./App.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { createApp } from "vue";
import { createPinia } from "pinia";
import { library } from "@fortawesome/fontawesome-svg-core";
import router from "./router/Router";

library.add(
  fas,
  faCheck,
  faCirclePlus,
  faEye,
  faMessage,
  faPaperPlane,
  faPenToSquare,
  faRightFromBracket,
  faRobot,
  faTrash,
  faUsers,
  faXmark
);

const app = createApp(App).component("font-awesome-icon", FontAwesomeIcon);

app.use(router);
app.use(createPinia());
app.mount("#app");
