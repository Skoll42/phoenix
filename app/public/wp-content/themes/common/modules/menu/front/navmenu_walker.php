<?php
class BT_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param array $args.
     * @param $id.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
	{
	    if ('category' == $item->object) {
            $category = get_category($item->object_id);
            $img_prefix = $category->slug;
        } else {
	        $img_prefix = strtolower($item->title);
        }

		global $wp_query;
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		
		$class_names = ' class="' . esc_attr( $class_names ) . '"';		
		
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		
		$item_id = $id;
		
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= '<li' . $id . $value . $class_names .'>';

		$item_id = strlen( $item_id ) ? ' id="' . esc_attr( $item_id ) .  '-inside'. '"' : '';
			
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= $item_id;
		$attributes .= ' data-id="' . esc_attr( $item->object_id ) . '"';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= '<img src="' . get_module_img(bt_header_get_section_logo($img_prefix)) . '" alt="logo"></a>';
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

add_filter('nav_menu_css_class', function($classes, $item, $args) {
	$arguments = get_object_vars($args);
	if($arguments['menu'] == 'header-menu') {
		$classes[] = 'col-sm-6';
	}
	return $classes;
}, 10, 3);

add_filter('wp_nav_menu_items', function($items, $args) {
	$arguments = get_object_vars($args);

	if($arguments['menu'] == 'header-menu') {
		$nth = 2;
		$items = explode('</li>',$items);
		$new_items = [];
		foreach($items as $index => $item)                  {
			if(($index+1) % $nth == 0){
				$new_items[] = $item;
				$new_items[] = '<div class="clearfix section-divider hidden-xs"></div>';
			} else {
				$new_items[]= $item;
			}
		}
		// finally put all the menu items back together into a string using the ending <li> tag and return
		$items = implode('</li>',$new_items);
	}

	return $items;
}, 10, 2);