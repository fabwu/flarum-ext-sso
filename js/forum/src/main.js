import {extend} from "flarum/extend";
import app from "flarum/app";
import HeaderSecondary from "flarum/components/HeaderSecondary";
import SettingsPage from "flarum/components/SettingsPage";

app.initializers.add('wuethrich44-sso', function () {
    extend(HeaderSecondary.prototype, 'items', replaceLoginButton);
    extend(HeaderSecondary.prototype, 'items', replaceSignupButton);

    extend(SettingsPage.prototype, 'accountItems', removeProfileActions);

    function replaceLoginButton(items) {
        if (!items.has('logIn')) {
            return;
        }

        let loginUrl = 'http://lanport.intra';

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

        let signupUrl = 'http://lanport.intra/';

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
});
