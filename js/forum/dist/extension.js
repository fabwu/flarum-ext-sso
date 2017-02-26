System.register("wuethrich44/sso/main", ["flarum/extend", "flarum/app", "flarum/components/HeaderSecondary", "flarum/components/SettingsPage"], function (_export) {
    "use strict";

    var extend, app, HeaderSecondary, SettingsPage;
    return {
        setters: [function (_flarumExtend) {
            extend = _flarumExtend.extend;
        }, function (_flarumApp) {
            app = _flarumApp["default"];
        }, function (_flarumComponentsHeaderSecondary) {
            HeaderSecondary = _flarumComponentsHeaderSecondary["default"];
        }, function (_flarumComponentsSettingsPage) {
            SettingsPage = _flarumComponentsSettingsPage["default"];
        }],
        execute: function () {

            app.initializers.add('wuethrich44-sso', function () {
                extend(HeaderSecondary.prototype, 'items', replaceLoginButton);
                extend(HeaderSecondary.prototype, 'items', replaceSignupButton);

                extend(SettingsPage.prototype, 'accountItems', removeProfileActions);

                function replaceLoginButton(items) {
                    if (!items.has('logIn')) {
                        return;
                    }

                    var loginUrl = app.forum.data.attributes['wuethrich44-sso.login_url'];

                    items.replace('logIn', m(
                        "a",
                        { href: loginUrl, className: "Button Button--link" },
                        app.translator.trans('core.forum.header.log_in_link')
                    ));
                }

                function replaceSignupButton(items) {
                    if (!items.has('signUp')) {
                        return;
                    }

                    var signupUrl = 'http://lanport.intra/';

                    items.replace('signUp', m(
                        "a",
                        { href: signupUrl, className: "Button Button--link" },
                        app.translator.trans('core.forum.header.sign_up_link')
                    ));
                }

                function removeProfileActions(items) {
                    items.remove('changeEmail');
                    items.remove('changePassword');
                }
            });
        }
    };
});