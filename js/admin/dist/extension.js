System.register('wuethrich44/sso/components/SSOSettingsModal', ['flarum/components/SettingsModal'], function (_export) {
    'use strict';

    var SettingsModal, SSOSettingsModal;
    return {
        setters: [function (_flarumComponentsSettingsModal) {
            SettingsModal = _flarumComponentsSettingsModal['default'];
        }],
        execute: function () {
            SSOSettingsModal = (function (_SettingsModal) {
                babelHelpers.inherits(SSOSettingsModal, _SettingsModal);

                function SSOSettingsModal() {
                    babelHelpers.classCallCheck(this, SSOSettingsModal);
                    babelHelpers.get(Object.getPrototypeOf(SSOSettingsModal.prototype), 'constructor', this).apply(this, arguments);
                }

                babelHelpers.createClass(SSOSettingsModal, [{
                    key: 'className',
                    value: function className() {
                        return 'Modal--small';
                    }
                }, {
                    key: 'title',
                    value: function title() {
                        return app.translator.trans('wuethrich44-sso.admin.settings.title');
                    }
                }, {
                    key: 'form',
                    value: function form() {
                        return [m(
                            'div',
                            { className: 'Form-group' },
                            m(
                                'label',
                                null,
                                app.translator.trans('wuethrich44-sso.admin.settings.signup_url')
                            ),
                            m('input', {className: 'FormControl', bidi: this.setting('wuethrich44-sso.signup_url')})
                        ), m(
                            'div',
                            {className: 'Form-group'},
                            m(
                                'label',
                                null,
                                app.translator.trans('wuethrich44-sso.admin.settings.login_url')
                            ),
                            m('input', {className: 'FormControl', bidi: this.setting('wuethrich44-sso.login_url')})
                        ), m(
                            'div',
                            {className: 'Form-group'},
                            m(
                                'label',
                                null,
                                app.translator.trans('wuethrich44-sso.admin.settings.logout_url')
                            ),
                            m('input', {className: 'FormControl', bidi: this.setting('wuethrich44-sso.logout_url')})
                        )];
                    }
                }]);
                return SSOSettingsModal;
            })(SettingsModal);

            _export('default', SSOSettingsModal);
        }
    };
});
System.register("wuethrich44/sso/main", ["flarum/app", "wuethrich44/sso/components/SSOSettingsModal"], function (_export) {
    "use strict";

    var app, SSOSettingsModal;
    return {
        setters: [function (_flarumApp) {
            app = _flarumApp["default"];
        }, function (_wuethrich44SsoComponentsSSOSettingsModal) {
            SSOSettingsModal = _wuethrich44SsoComponentsSSOSettingsModal["default"];
        }],
        execute: function () {

            app.initializers.add('wuethrich44-sso', function () {
                app.extensionSettings['wuethrich44-sso'] = function () {
                    return app.modal.show(new SSOSettingsModal());
                };
            });
        }
    };
});