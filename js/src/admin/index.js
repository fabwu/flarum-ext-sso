import app from "flarum/app";
import SSOSettingsModal from "./components/SSOSettingsModal";

app.initializers.add('wuethrich44-sso', () => {
    app.extensionSettings['wuethrich44-sso'] = () => app.modal.show(new SSOSettingsModal());
});
