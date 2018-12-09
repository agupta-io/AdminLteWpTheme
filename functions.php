<?php

add_theme_support('post-thumbnails');
/* Adding Menu */
add_theme_support('nav-menus');
register_nav_menu('sidebar', 'Sidebar');
register_nav_menu('headermenu', 'Header Menu');
/* Breadcrums Function */
function breadcrums()
{
    if (!is_home() && !is_category()) {
        echo '<li><i class="fa fa-dashboard"></i> ';
        bloginfo('name');
        echo '</li><li  class="active">';
        if (is_single()) {
            echo get_the_title();
        } elseif (is_page()) {
            echo get_the_title();
        }
        echo "</li>";
    }
}
/* Making Submenu */
class Sidebar_Nav_Menu extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $arg = [])
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"treeview-menu\" >\n";
    }
    function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
    {   
        global $wp_query;
        $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
       
        // passed classes
        $classes = empty($item->classes) ? array() : (array)$item->classes;
        $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));
        
         // depth dependent classes
         $depth_classes = array(
            ((strpos($class_names,"menu-item-has-children")!==false) ? 'treeview' : 'sub-menu-item'),
            #($depth >= 2 && (strpos($class_names,"menu-item-has-children")!==false) ? 'treeview' : 'sub-sub-menu-item'),
            ($depth % 2 ? 'menu-item-odd' : 'menu-item-even'),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr(implode(' ', $depth_classes));
        // build html
        $output .= $indent . '<li id="nav-menu-item-' . $item->ID . '" class="' . $depth_class_names . ''.$class_names.'">';
        // link attributes
         $link_before = $args->link_before;
         
        if($link_before ==null && $link_before=="")
        {
            $title=esc_attr($item->attr_title);
            
            if($title!=null && $title!=""){
                $val=explode("|",$title);
                if($val[0]!=""){
                    $titledata=explode(",",$val[0]);
                    if(count($titledata)>1){
                        $link_before='<i class="text-'.$titledata[1].' fa fa-'.esc_attr($titledata[0]).'">&nbsp;</i>';
                    }
                    else{
                        $link_before='<i class="text-gray fa fa-'.esc_attr($titledata[0]).'">&nbsp;</i>';
                    }
                }
                
                
            }
            
        }
        $link_after=$args->link_after;
        if( $link_after==null){
            $link_after='<span class="pull-right-container">';
            if(strpos($class_names,"menu-item-has-children")!==false){
                $link_after.='<i class="fa fa-angle-left pull-right"></i>';
            }
            $title=esc_attr($item->attr_title);
            if($title!=null && $title!=""){
               $arr= explode("|",$title);
               $index=0;
               foreach($arr as &$value)
               {
                   if($index==0){
                    $index=$index+1;
                       continue;
                   }
                   $index=$index+1;
                   if($value!="")
                    {
                        $val=explode(",",$value);
                        if(count($val) > 1)
                        {
                            $link_after.='<small class="label pull-right bg-'.$val[1].'">'.$val[0].'</small>';
                        }
                        else if(count($val)>0){
                            $link_after.='<small class="label pull-right bg-primary">'.$val[0].'</small>';
                        }
                    }
               }
                
            }
            $link_after.='</span>';
        }
        //$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        // if((strpos($class_names,"menu-item-has-children")!==false) ){
        //     $attributes .= !empty($item->url) ? ' href="#"' : '';
        // }
        // else{
        //     $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        // }
       
        $attributes .= ' class="menu-link ' . ($depth > 0 ? 'sub-menu-link' : 'main-menu-link') . '"';
        $item_output = sprintf('%1$s<a%2$s>%3$s<span>%4$s</span>%5$s</a>%6$s',
            $args->before,
            $attributes,
            $link_before,
            apply_filters('the_title', $item->title, $item->ID),
            $link_after,
            $args->after
        );
        // build html
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
class Header_Nav_Menu extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $arg = [])
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }
    function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
    {
        global $wp_query;
        $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
        // depth dependent classes
        $depth_classes = array(
            ($depth == 0 ? 'dropdown' : 'sub-menu-item'),
            ($depth >= 2 ? 'sub-sub-menu-item' : ''),
            ($depth % 2 ? 'menu-item-odd' : 'menu-item-even'),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr(implode(' ', $depth_classes));
        // passed classes
        $classes = empty($item->classes) ? array() : (array)$item->classes;
        $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));
        // build html
        $output .= $indent . '<li id="nav-menu-item-' . $item->ID . '" class="' . $depth_class_names . '">';
        // link attributes
        //$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        if ($depth == 0) {
            $attributes .= ' class="dropdown-toggle" data-toggle="dropdown"';
        }
         // link attributes
         $link_before = $args->link_before;
         
        if($link_before ==null && $link_before=="")
        {
            $title=esc_attr($item->attr_title);
            
            if($title!=null && $title!=""){
                $val=explode("|",$title);
                if($val[0]!=""){
                    $link_before='<i class="fa fa-'.esc_attr($val[0]).'">&nbsp;</i>';
                }
                
                
            }
            else{
                $link_before=   $item->title;
            }
            
        }
        $link_after=$args->link_after;
        if( $link_after==null){
            // $link_after='<span class="pull-right-container">';
            // if(strpos($class_names,"menu-item-has-children")!==false){
            //     $link_after.='<i class="fa fa-angle-left pull-right"></i>';
            // }
            $title=esc_attr($item->attr_title);
            if($title!=null && $title!=""){
               $arr= explode("|",$title);
               $index=0;
               foreach($arr as &$value)
               {
                   if($index==0){
                    $index=$index+1;
                       continue;
                   }
                   $index=$index+1;
                   if($value!="")
                    {
                        $val=explode(",",$value);
                        if(count($val) > 1)
                        {
                            $link_after.='<span class="label label-'.$val[1].'">'.$val[0].'</span>';
                        }
                        else if(count($val)>0){
                            $link_after.='<span class="label label-success">'.$val[0].'</span>';
                        }
                    }
               }
                
            }
            $link_after.='</span>';
        }
        $item_output="";
        if($depth==0){
            $item_output = sprintf('<a%1$s>%2$s %3$s</a>%4$s',
            $attributes,
            $link_before,
            $link_after,
            $args->after
        );
        }else{
            $item_output = sprintf('%1$s<a%2$s>%3$s<span>%4$s</span>%5$s</a>%6$s',
            $args->before,
            $attributes,
            $link_before,
            apply_filters('the_title', $item->title, $item->ID),
            $link_after,
            $args->after
        );
        }
        
        // build html
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

//Removind ul elements
function wp_nav_menu_no_ul()
{
    $options = array(
        'echo' => false,
        'container' => false,
        'theme_location' => 'headermenu',
				'fallback_cb'=> 'default_page_menu'
    );
    $menu = wp_nav_menu($options);
    echo preg_replace(array(
        '#^<ul[^>]*>#',
        '#</ul>$#'
    ), '', $menu);
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}
//Register Sidebars
register_sidebar(array(
    'name' => 'Right Bar',
    'id' => 'right-bar',
    'before_widget' => '<div class="right-bar-widget">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="control-sidebar-heading">',
    'after_title' => '</h3>',
));
register_sidebar(array(
    'name' => 'Side Bar',
    'id' => 'side-bar',
    'before_widget' => '<div class="box box-widget side-bar-widget"><div class="box-body">',
    'after_widget' => '</div></div>',
    'before_title' => '<h3 class="profile-username text-center">',
    'after_title' => '</h3>',
));
//Infinite Scroll
function wp_infinitepaginate()
{
    $loopFile = $_POST['loop_file'];
    $paged = $_POST['page_no'];
    $action = $_POST['what'];
    $value = $_POST['value'];
    if ($action == 'author_name') {
        $arg = array('author_name' => $value, 'paged' => $paged, 'post_status' => 'publish');
    } elseif ($action == 'category_name') {
        $arg = array('category_name' => $value, 'paged' => $paged, 'post_status' => 'publish');
    } elseif ($action == 'search') {
        $arg = array('s' => $value, 'paged' => $paged, 'post_status' => 'publish');
    } else {
        $arg = array('paged' => $paged, 'post_status' => 'publish');
    }
    # Load the posts
    query_posts($arg);
    get_template_part($loopFile);
    exit;
}
add_action('wp_ajax_infinite_scroll', 'wp_infinitepaginate');           // for logged in user
add_action('wp_ajax_nopriv_infinite_scroll', 'wp_infinitepaginate');    // if user not logged in
// Theme Admin Panel
if (STYLESHEETPATH == TEMPLATEPATH) {
    define('OF_FILEPATH', TEMPLATEPATH);
    define('OF_DIRECTORY', get_bloginfo('template_directory'));
} else {
    define('OF_FILEPATH', STYLESHEETPATH);
    define('OF_DIRECTORY', get_bloginfo('stylesheet_directory'));
}
require_once(OF_FILEPATH . '/admin/admin-functions.php');
require_once(OF_FILEPATH . '/admin/admin-interface.php');
require_once(OF_FILEPATH . '/admin/theme-options.php');
require_once(OF_FILEPATH . '/admin/theme-functions.php');
