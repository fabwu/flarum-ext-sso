import {extend, override} from "flarum/extend";
import app from "flarum/app";
import HeaderSecondary from "flarum/components/HeaderSecondary";
import SettingsPage from "flarum/components/SettingsPage";
import LogInModal from "flarum/components/LogInModal";

app.initializers.add('wuethrich44-sso', function () {
    override(LogInModal.prototype, 'init', redirectWhenLoginModalIsOpened);

    extend(HeaderSecondary.prototype, 'items', replaceLoginButton);
    extend(HeaderSecondary.prototype, 'items', replaceSignupButton);

    extend(SettingsPage.prototype, 'accountItems', removeProfileActions);
    extend(SettingsPage.prototype, 'settingsItems', checkRemoveAccountSection);

    function redirectWhenLoginModalIsOpened() {
        window.location.href = app.forum.data.attributes['wuethrich44-sso.login_url'];
        throw new Error('Stop execution');
    }

    function replaceLoginButton(items) {
        if (!items.has('logIn')) {
            return;
        }

        let loginUrl = app.forum.data.attributes['wuethrich44-sso.login_url'];

        items.replace('logIn',
            <a href={loginUrl} className="Button Button--link">
                {app.translator.trans('core.forum.header.log_in_link')}
            </a>
        );
    }

    function replaceSignupButton(items) {
        if (!items.has('signUp')) {
            return;
        }

        let signupUrl = app.forum.data.attributes['wuethrich44-sso.signup_url'];

        items.replace('signUp',
            <a href={signupUrl} className="Button Button--link">
                {app.translator.trans('core.forum.header.sign_up_link')}
            </a>
        );
    }

    function removeProfileActions(items) {
        items.remove('changeEmail');
        items.remove('changePassword');
    }

    function checkRemoveAccountSection(items) {
        if (items.has('account')
            && items.get('account').props.children.length === 0) {
            items.remove('account');
        }
    }
});
