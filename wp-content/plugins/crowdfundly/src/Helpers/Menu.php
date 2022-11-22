<?php

namespace Crowdfundly\App\Helpers;

/**
 * Helper class for creating menu/submenu items.
 * 
 * @package     crowdfundly
 * @author      Nazmul, Keramot UL Islam <sourav926>, 
 * @since       2.0.0
 */
class Menu
{
    protected $title;

    protected $menu_title;

    protected $permission;

    protected $slug;

    protected $icon_url = 'none';

    protected $position = 40;

    protected $callback;

    /**
     * @var bool|static
     */
    protected $parent = false;

    protected $hide = false;

    protected $children = [];

    public static function make($title, $menu_title = false)
    {
        if ( ! $menu_title ) {
            $menu_title = $title;
        }
        return new static($title, $menu_title);
    }

    public function __construct($title, $menu_title)
    {
        $this->title = $title;
        $this->menu_title = $menu_title;
        $this->slug($title);
    }

    public function permission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    public function slug($slug)
    {
        $this->slug = strtolower( CROWDFUNDLY . "-{$slug}" );

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function icon($url)
    {
        $this->icon_url = $url;

        return $this;
    }

    public function position($position)
    {
        $this->position = $position;

        return $this;
    }

    public function parent($parent = false)
    {
        if ( ! $parent && $this->parent ) {
            return $this->parent;
        }
        $this->parent = $parent;

        return $this;
    }

    public function children($children)
    {
        $this->children = $children;

        return $this;
    }

    public function hide() 
    {
        $this->hide = true;
        return $this;
    }

    public function shouldBeHiden()
    {
        return $this->hide;
    }

    public function view($controller, $method = false)
    {
        $this->callback = cf_view($controller, $method);

        return $this;
    }

    public function render()
    {
        $function = 'add_menu_page';
        $args = [$this->title, $this->menu_title, $this->permission, $this->slug, $this->callback];

        if ( $this->parent ) {
            array_unshift($args, $this->parent->getSlug());
            $function = 'add_submenu_page';
        } else {
            $args[] = $this->icon_url;
        }
        $args[] =  $this->position;

        call_user_func_array( $function, $args );

        foreach ( $this->children as $child ) {
            $child->parent($this)->render();

            if (  $child->shouldBeHiden() ) {
                add_action( 'admin_head', function() use ($child) {
                    remove_submenu_page( $child->parent()->getSlug(), $child->getSlug() );
                } );
            }
        }
    }
}
