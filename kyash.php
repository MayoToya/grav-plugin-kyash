<?php
namespace Grav\Plugin;

use \Grav\Common\Plugin;
use \Grav\Common\Grav;
use \Grav\Common\Page\Page;

class KyashPlugin extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'onPageInitialized' => ['onPageInitialized', 0]
        ];
    }

    public function onPageInitialized()
    {
        if ($this->isAdmin()) {
            $this->active = false;
            return;
        }

        $defaults = (array) $this->config->get('plugins.kyash');

        $page = $this->grav['page'];
        if (isset($page->header()->kyash)) {
            $this->config->set('plugins.kyash', array_merge($defaults, $page->header()->kyash));
        }
        if ($this->config->get('plugins.kyash.enabled')) {
            $this->enable([
                'onTwigSiteVariables' => ['onTwigSiteVariables', 0]
            ]);
        }
    }

    /**
     * if enabled on this page, add javascript in its header
     */
    public function onTwigSiteVariables()
    {
        $this->grav['assets']->addInlineJs('window.kyash = (function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0],t = window.kyash || {};if (d.getElementById(id)) return t;js = d.createElement(s);js.id = id; js.src = "https://satetsu888.github.io/kyash-button/dest/widgets.js";fjs.parentNode.insertBefore(js, fjs); t._e = []; t.ready = function(f) { t._e.push(f); }; return t; }(document, "script", "kyash-wjs"));');
    }

}
