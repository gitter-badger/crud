<?php
/**
 * Created by IntelliJ IDEA.
 * User: Meki
 * Date: 2015.04.01.
 * Time: 7:20
 */

namespace BlackfyreStudio\CRUD;

    /**
     * This file was largely part of the KraftHaus Bauhaus package.
     *
     * (c) KraftHaus <hello@krafthaus.nl>
     *
     * For the full copyright and license information, please view the LICENSE
     * file that was distributed with this source code.
     */

/**
 * Class MenuBuilder
 * @package BlackfyreStudio\CRUD
 */
class MenuBuilder {
    /**
     * Holds the menu items.
     * @var array
     */
    protected $items = ['left' => [], 'top' => []];

    /**
     * Public class constructor.
     *
     * @access public
     */
    public function __construct()
    {
        $config = \Config::get('crud-menu');
        if ($config !== null) {
            $this->items['left'] = \Config::get('crud-menu');
        }
    }
    /**
     * Get the menu items.
     *
     * @access public
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add new items to the menu array.
     *
     * @param  array $menu
     *
     * @access public
     * @return MenuBuilder
     */
    public function addMenu($position, array $menu)
    {
        array_push($this->items[$position], $menu);
        return $this;
    }
    /**
     * Build the menu html.
     *
     * @access public
     * @return string
     */
    public function build()
    {
        $menu = $this->items;
        $html = '';
        if (isset($menu['right'])) {
            $html.= '<ul class="nav navbar-nav navbar-right">';
            $html.= $this->buildMenu($menu['right']);
            $html.= '</ul>';
        }
        $html.= '<ul class="nav navbar-nav">';
        $html.= sprintf('<li><a href="%s">Dashboard</a></li>', route('admin.dashboard'));
        $html.= $this->buildMenu($menu['left']);
        $html.= '</ul>';
        return $html;
    }
    /**
     * Iterator method for the build() function.
     *
     * @param  array $menu
     *
     * @access public
     * @return string
     */
    private function buildMenu($menu)
    {

        /* TODO: Find/Create suitable permission manager */

        $html = '';
        /*
        $user = \Sentry::getUser();
        */
        foreach ($menu as $value) {
            /*
                Check if the current item should be filtered by permissions
                If there's a permission requirement we check it, if fails we skip this iteration
            */

            /*
            if (isset($value['permission'])) {
                if (is_array($value['permission'])) {
                    $permissions = [];
                    foreach ($value['permission'] as $p) {
                        $p = str_replace('.','-',$p);
                        $permissions[] = $p;
                        $permissions[] = $p . '.read';
                    }
                    if (!$user->hasAnyAccess($permissions)) {
                        continue;
                    }
                } else {
                    if (!$user->hasAnyAccess([$value['permission'],$value['permission'].'.view'])) {
                        continue;
                    }
                }
            }
            */

            /* TODO: modify html for the new template */

            $icon = '';
            if (isset($value['icon'])) {
                $icon = sprintf('<i class="fa fa-%s"></i> ', $value['icon']);
            }
            if (isset($value['children'])) {
                $html.= '<li class="dropdown">';
                $html.= sprintf('<a href="#" class="dropdown-toggle" data-toggle="dropdown">%s%s<b class="caret"></b></a>', $icon, $value['title']);
                $html.= '<ul class="dropdown-menu">';
                $html.= $this->buildMenu($value['children']);
                $html.= '</ul>';
                $html.= '</li>';
                continue;
            }
            $url = '';
            if (isset($value['class'])) {
                $url = route('admin.model.index', urlencode($value['class']));
            } elseif (isset($value['url'])) {
                $url = url($value['url']);
            } elseif (isset($value['route'])) {
                $url = route($value['route']);
            }
            if (isset($value['text'])) {
                $html.= sprintf('<li><p class="navbar-text">%s</p></li>', $value['text']);
            } elseif (isset($value['image'])) {
                $html.= sprintf('<li><img src="%s" class="navbar-image"></li>', $value['image']);
            } elseif (isset($value['title'])) {
                $html.= sprintf('<li><a href="%s">%s%s</a></li>', $url, $icon, $value['title']);
            }
        }
        return $html;
    }
}