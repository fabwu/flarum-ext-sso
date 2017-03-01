# Flarum Single Sign On

This extension equip Flarum with Single Sign On. The workflow is based on this 
[post](https://discuss.flarum.org/d/2808-how-i-implemented-cross-authentication-with-flarum).
The extension is useful if you run Flarum on a subdomain but you want to use the login mechanism 
of your main website. A dummy main website is provided in the `sample-website/` folder.

## Installation

1. Create a random token and put it into the `api_keys` table of your Flarum database.

2. Go into `sample-website` folder and copy `config.php.dist` to `config.php`:
  ```
  cd sample-website/
  cp config.php.dist config.php
  ```
3. Open `config.php` with an editor of your choice and configure all settings.

4. Upload the `Forum.php` class and `config.php` to your main website and setup the `Forum.php` class. An example is given in `index.php` / `logout.php`.

5. Install and activate the extension. Fill in redirect urls for login, signup and logout.
  ```
  composer require wuethrich44/flarum-ext-sso
  ```
6. Now you should able to log in with your existing users.
