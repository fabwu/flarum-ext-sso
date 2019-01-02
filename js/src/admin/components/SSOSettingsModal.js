import SettingsModal from "flarum/components/SettingsModal";

export default class SSOSettingsModal extends SettingsModal {
    className() {
        return 'Modal--small';
    }

    title() {
        return app.translator.trans('wuethrich44-sso.admin.settings.title');
    }

    form() {
        return [
            <div className="Form-group">
                <label>{app.translator.trans('wuethrich44-sso.admin.settings.signup_url')}</label>
                <input className="FormControl" bidi={this.setting('wuethrich44-sso.signup_url')}/>
            </div>,
            <div className="Form-group">
                <label>{app.translator.trans('wuethrich44-sso.admin.settings.login_url')}</label>
                <input className="FormControl" bidi={this.setting('wuethrich44-sso.login_url')}/>
            </div>,
            <div className="Form-group">
                <label>{app.translator.trans('wuethrich44-sso.admin.settings.logout_url')}</label>
                <input className="FormControl" bidi={this.setting('wuethrich44-sso.logout_url')}/>
            </div>
        ];
    }
}