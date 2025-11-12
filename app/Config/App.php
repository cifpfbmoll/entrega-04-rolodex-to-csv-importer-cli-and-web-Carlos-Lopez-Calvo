<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    /**
     * -------------------------------------------------------------------
     * Base Site URL
     * -------------------------------------------------------------------
     *
     * URL to your CodeIgniter root. Typically this will be your base URL,
     * WITH a trailing slash:
     *
     *    http://example.com/
     */
    public $baseURL = 'http://localhost:8080/';

    /**
     * -------------------------------------------------------------------
     * Allowed Hostnames
     * -------------------------------------------------------------------
     *
     * When running under a reverse proxy, you might want to restrict
     * which hostnames are allowed. This is a security measure to prevent
     * host header injection attacks.
     */
    public array $allowedHostnames = [];

    /**
     * -------------------------------------------------------------------
     * Index File
     * -------------------------------------------------------------------
     *
     * Typically this will be your index.php file, unless you've renamed it to
     * something else. If you are using mod_rewrite to remove the page set this
     * variable so that it is blank.
     */
    public $indexPage = '';

    /**
     * -------------------------------------------------------------------
     * URI PROTOCOL
     * -------------------------------------------------------------------
     *
     * This item determines which server global should be used to retrieve the
     * URI string.  The default setting of 'REQUEST_URI' works for most servers.
     * If your links do not seem to work, try one of the other delicious flavors:
     *
     * 'REQUEST_URI'    Uses $_SERVER['REQUEST_URI']
     * 'QUERY_STRING'   Uses $_SERVER['QUERY_STRING']
     * 'PATH_INFO'      Uses $_SERVER['PATH_INFO']
     *
     * WARNING: If you set this to 'PATH_INFO', URIs will always be URL-decoded!
     */
    public $uriProtocol = 'REQUEST_URI';

    /**
     * -------------------------------------------------------------------
     * Default Locale
     * -------------------------------------------------------------------
     *
     * The Locale roughly represents the language and location that your
     * visitor is viewing the site from. It affects the language strings
     * and other settings (like time formatting).
     */
    public $defaultLocale = 'en';

    /**
     * -------------------------------------------------------------------
     * Negotiate Locale
     * -------------------------------------------------------------------
     *
     * If true, the current Request object will automatically determine the
     * language to use based on the value of the Accept-Language header.
     *
     * If false, the system will use the defaultLocale setting.
     */
    public $negotiateLocale = false;

    /**
     * -------------------------------------------------------------------
     * Supported Locales
     * -------------------------------------------------------------------
     *
     * If $negotiateLocale is true, this array lists the locales supported
     * by the application in descending order of priority. If no match is
     * found, the first locale in the array will be used.
     */
    public $supportedLocales = ['en'];

    /**
     * -------------------------------------------------------------------
     * Application Timezone
     * -------------------------------------------------------------------
     *
     * The default timezone that will be used in your application to display
     * dates with the date helper, and can be retrieved through app_timezone()
     */
    public $appTimezone = 'UTC';

    /**
     * -------------------------------------------------------------------
     * Default Character Set
     * -------------------------------------------------------------------
     *
     * This determines which character set is used by default in various methods
     * that require a character set to be provided.
     */
    public $charset = 'UTF-8';

    /**
     * -------------------------------------------------------------------
     * Force Global Secure Requests
     * -------------------------------------------------------------------
     *
     * If true, this will force every request made to this application over HTTPS,
     * even when testing locally.
     *
     * WARNING: This can cause issues when running locally with self-signed
     * certificates, so you may want to disable this for development environments.
     */
    public $forceGlobalSecureRequests = false;

    /**
     * -------------------------------------------------------------------
     * Session Driver & Cookie
     * -------------------------------------------------------------------
     *
     * The session storage driver to use:
     * - `CodeIgniter\Session\Handlers\FileHandler`
     * - `CodeIgniter\Session\Handlers\DatabaseHandler`
     * - `CodeIgniter\Session\Handlers\MemcachedHandler`
     * - `CodeIgniter\Session\Handlers\RedisHandler`
     *
     * The cookie name to use for the session cookie.
     */
    public $sessionDriver = 'CodeIgniter\Session\Handlers\FileHandler';
    public $sessionCookieName = 'ci_session';
    public $sessionExpiration = 7200;
    public $sessionSavePath = WRITEPATH . 'session';
    public $sessionMatchIP = false;
    public $sessionTimeToUpdate = 300;
    public $sessionRegenerateDestroy = false;

    /**
     * -------------------------------------------------------------------
     * Cookie Prefix
     * -------------------------------------------------------------------
     *
     * Set a cookie name prefix if you need to avoid collisions
     */
    public $cookiePrefix = '';

    /**
     * -------------------------------------------------------------------
     * Cookie Domain
     * -------------------------------------------------------------------
     *
     * Set to `.your-domain.com` for site-wide cookies.
     */
    public $cookieDomain = '';

    /**
     * -------------------------------------------------------------------
     * Cookie Path
     * -------------------------------------------------------------------
     *
     * Typically will be a forward slash.
     */
    public $cookiePath = '/';

    /**
     * -------------------------------------------------------------------
     * Cookie Secure
     * -------------------------------------------------------------------
     *
     * Cookie will only be set if a secure HTTPS connection exists.
     */
    public $cookieSecure = false;

    /**
     * -------------------------------------------------------------------
     * Cookie HTTPOnly
     * -------------------------------------------------------------------
     *
     * Cookie will only be accessible via HTTP(S) (no JavaScript).
     */
    public $cookieHTTPOnly = true;

    /**
     * -------------------------------------------------------------------
     * Cookie SameSite
     * -------------------------------------------------------------------
     *
     * Configure cookie SameSite setting. Allowed values are:
     * - None
     * - Lax
     * - Strict
     */
    public $cookieSameSite = 'Lax';

    /**
     * -------------------------------------------------------------------
     * Reverse Proxy IPs
     * -------------------------------------------------------------------
     *
     * If your server is behind a reverse proxy, you must whitelist the
     * proxy IP addresses from which CodeIgniter should trust headers such as
     * HTTP_X_FORWARDED_FOR and HTTP_CLIENT_IP.
     */
    public $proxyIPs = [];

    /**
     * -------------------------------------------------------------------
     * CSRF Token Name
     * -------------------------------------------------------------------
     *
     * Token name for Cross Site Request Forgery protection cookie.
     */
    public $CSRFTokenName = 'csrf_test_name';

    /**
     * -------------------------------------------------------------------
     * CSRF Header Name
     * -------------------------------------------------------------------
     *
     * Header name for Cross Site Request Forgery protection cookie.
     */
    public $CSRFHeaderName = 'X-CSRF-TOKEN';

    /**
     * -------------------------------------------------------------------
     * CSRF Cookie Name
     * -------------------------------------------------------------------
     *
     * Cookie name for Cross Site Request Forgery protection cookie.
     */
    public $CSRFCookieName = 'csrf_cookie_name';

    /**
     * -------------------------------------------------------------------
     * CSRF Expire
     * -------------------------------------------------------------------
     *
     * Number of seconds for the CSRF token to expire.
     */
    public $CSRFExpire = 7200;

    /**
     * -------------------------------------------------------------------
     * CSRF Regenerate
     * -------------------------------------------------------------------
     *
     * Regenerate CSRF Token on every request.
     */
    public $CSRFRegenerate = true;

    /**
     * -------------------------------------------------------------------
     * CSRF Exclude URIs
     * -------------------------------------------------------------------
     *
     * List of URIs to ignore for CSRF protection.
     */
    public $CSRFExcludeURIs = [];

    /**
     * -------------------------------------------------------------------
     * Content Security Policy
     * -------------------------------------------------------------------
     *
     * Enables the Response's Content Secure Policy to restrict the sources that
     * the browser is allowed to load resources from. Helps prevent XSS attacks.
     */
    public $CSPEnabled = false;
}
