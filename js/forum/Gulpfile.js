var flarum = require('flarum-gulp');

flarum({
    modules: {
        'wuethrich44/sso': [
            'src/**/*.js'
        ]
    }
});
