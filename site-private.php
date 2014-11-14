<?php
/*
Plugin Name: Site Private
Plugin URI: http://gzep.ru/site-private-wordpress-plugin/
Description: Simplest plugin that redirects unauthorized users to login page.
Version: 1.0
Author: Gaiaz Iusipov
Author URI: http://gzep.ru
*/

defined('ABSPATH') or exit();

class SitePrivate
{
    private static $instance;

    private function __construct()
    {
        add_action('template_redirect', array($this, 'actionRedirect'));
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function actionRedirect()
    {
        global $pagenow;
        if ('wp-login.php' !== $pagenow
            && !is_user_logged_in()
            && !is_user_member_of_blog()) {
            auth_redirect();
        }
    }
}

add_action('plugins_loaded', 'SitePrivate::getInstance');
