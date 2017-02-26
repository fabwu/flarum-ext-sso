import SettingsModal from "flarum/components/SettingsModal";

export default class SSOSettingsModal extends SettingsModal {
    className() {
        return 'Modal--small';
    }

    title() {
        return 'Test';
    }

    form() {
        return [
            <div className="Form-group">
                <label>Test</label>
                <input className="FormControl" bidi={this.setting('flarum-auth-twitter.api_key')}/>
            </div>,
        ];
    }
}