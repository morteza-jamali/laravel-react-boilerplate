import lodash from "lodash";
import axios from "axios";
import React from "react";
import ReactDOM from "react-dom";
import App from "../views/App";

declare global {
  interface Window {
    _: typeof lodash;
    axios: typeof axios;
  }
}

(() => {
  window._ = lodash;
  window.axios = axios;
  window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
})();

ReactDOM.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>,
  document.getElementById("root")
);
