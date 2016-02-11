<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package jkl
 */

if ( ! function_exists( 'jkl_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function jkl_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'jkl' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'jkl' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'jkl_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function jkl_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'jkl' ) );
		if ( $categories_list && jkl_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'jkl' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'jkl' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'jkl' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'jkl' ), esc_html__( '1 Comment', 'jkl' ), esc_html__( '% Comments', 'jkl' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'jkl' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function jkl_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'jkl_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'jkl_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so jkl_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so jkl_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in jkl_categorized_blog.
 */
function jkl_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'jkl_categories' );
}
add_action( 'edit_category', 'jkl_category_transient_flusher' );
add_action( 'save_post',     'jkl_category_transient_flusher' );


/* 
 * #############################################################################
 * 
 * Custom Template Tags
 * 
 * ############################################################################# 
 */

/**
 * DYNAMIC Copyright for the footer
 */
 function dynamic_copyright() {

    global $wpdb;

    $copyright_dates = $wpdb->get_results( "SELECT YEAR(min(post_date_gmt)) AS firstdate, YEAR(max(post_date_gmt)) AS lastdate FROM $wpdb->posts WHERE post_status = 'publish' " );
    $output = '';
    $blog_name = get_bloginfo();

    if ( $copyright_dates ) {
        $copyright = "&copy; " . $copyright_dates[0]->firstdate;
        if ( $copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate ) {
            $copyright .= " &ndash; " . $copyright_dates[0]->lastdate;
        }
        $output = $copyright . " " . $blog_name;
    }
    return $output;
}

/**
 * Attempting to split the main nav menu with the logo
 * @link: Courtesy: http://pateason.com/horizontal-split-nav/
 */
function split_main_nav() {
    
    // Get menu 
    $menu_name = 'primary';
    
    // Check if the menu exists and is set
    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
        
        $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
        $menu_items = wp_get_nav_menu_items( $menu->term_id );
        
        // Create new array with only top level objects
        $newMenu = array();
        foreach( $menu_items as $item ) {
            if( $item->menu_item_parent != 0 ) continue;
            array_push( $newMenu, $item );
        }
        
        // Split menu array in half
        $len = count( $newMenu );
        $firstThis = array_slice( $newMenu, 0, $len / 2 );
        $thenThat = array_slice( $newMenu, $len / 2 );
        
        // Create left menu
        echo '<div id="main-nav-left"><ul>';
        foreach( $firstThis as $item ) {
            echo '<li><a href="' . $item->url . '">' . $item->title . '</a></li>';
        }
        echo '</ul></div>';
        
        // Add logo (site icon)
        echo '<div class="site-logo">';
        $site_title = get_bloginfo( 'name' ); ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <div class="screen-reader-text">
                <?php printf( esc_html( 'Go to the homepage of %1$s', 'jkl' ), $site_title ); ?>
            </div>
            <?php
            $site_icon = esc_url( get_site_icon_url( 150 ) ); ?>
            <img class="site-icon" src="<?php echo $site_icon; ?>" alt="">
        </a>
        
        <?php
        // Create right menu
        echo '<div id="main-nav-right"><ul>';
        foreach( $thenThat as $item ) {
            echo '<li><a href="' . $item->url . '">' . $item->title . '</a></li>';
        }
        echo '</ul></div>';
    }
    
    else {
        
        echo '<em>Please select a menu for your primary navigation.</em>';
        
    }
    
}