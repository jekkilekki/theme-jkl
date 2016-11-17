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
		esc_html( '%s' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html( '%s' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

        // Display the author avatar if the author has a Gravatar
        $author_id = get_the_author_meta( 'ID' );
        // if( jkl_validate_gravatar( $author_id ) ) {
            echo '<div class="meta-content has-avatar">';
            echo '<div class="author-avatar">' . get_avatar( $author_id ) . '</div>';
        // } else {
            echo '<div class="meta-content-text">';
            
        // Byline
	echo '<span class="byline">';
        if( 'status' !== get_post_format() ) {
            echo __( 'by', 'jkl' );
        }
        echo ' ' . $byline . '</span>';
        
        // Posted on date
        echo '<span class="posted-on">';
        if( 'status' !== get_post_format() ) {
            echo __( 'on', 'jkl' );
        }
        echo ' ' . $posted_on . '</span>'; // WPCS: XSS OK.

//        // Add Category list below (except on Status Post Formats)
//        if ( 'post' === get_post_type() && 'status' !== get_post_format() ) {
//		/* translators: used between list items, there is a space after the comma */
//		$categories_list = get_the_category_list( esc_html__( ', ', 'jkl' ) );
//		if ( $categories_list && jkl_categorized_blog() ) {
//			printf( '<span class="cat-links">' . esc_html( '%1$s' ) . '</span>', $categories_list ); // WPCS: XSS OK.
//		}
//        }
        
        // Categories
        if( 'status' !== get_post_format() ) {
            //jkl_better_taxonomy_listing( 'category', 1 );
        }

        // Add Comments Link (except on Status Post Formats)
        if ( ! post_password_required() && ( comments_open() || get_comments_number() ) && 'status' !== get_post_format() ) {
                echo '<span class="comments-link">';
                comments_popup_link( esc_html__( 'Leave a comment', 'jkl' ), esc_html__( '1 Comment', 'jkl' ), esc_html__( '% Comments', 'jkl' ) );
                echo '</span>';
        }

        echo '</div><!-- .meta-content -->';
        echo '</div><!-- .meta-content-text -->';
}
endif;

if ( ! function_exists( 'jkl_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function jkl_entry_footer() {
	// Hide category and tag text for pages.
//	if ( 'post' === get_post_type() && ! is_archive() && ! is_home() ) {
//		/* translators: used between list items, there is a space after the comma */
//		$categories_list = get_the_category_list( esc_html__( ', ', 'jkl' ) );
//		if ( $categories_list && jkl_categorized_blog() ) {
//			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'jkl' ) . '</span>', $categories_list ); // WPCS: XSS OK.
//		}
//
                //jkl_better_taxonomy_listing( 'category', 4 );
                
		/* translators: used between list items, there is a space after the comma */
                //jkl_better_taxonomy_listing( 'tag', 12 );
                
//		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'jkl' ) );
//		if ( $tags_list ) {
//			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'jkl' ) . '</span>', $tags_list ); // WPCS: XSS OK.
//		}
//	}

	if ( ! is_home() && ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
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
 * Better Categories (displays them as a dropdown menu)
 */
function jkl_better_taxonomy_listing( $taxonomy_type, $length = -1 ) {
    if ( 'post' === get_post_type() ) {
        
        // If the taxonomy type is 'category'
        if( 'category' === $taxonomy_type ) {
            
            /* translators: used between list items <li> */
            $list = get_the_category_list( __( '</li><li>', 'jkl' ) );
            $search = '</a>';
            $separator = ', ';
            $test = $list && jkl_categorized_blog();
            $class = 'cat-links';
            $string = esc_attr__( 'Filed under: ', 'jkl' );
            
        } 
        
        // If the taxonomy type is 'tag'
        else if( 'tag' === $taxonomy_type ) {
            
            /* translators: used between list items, there is a space after the comma */
            $list = get_the_tag_list( '', esc_html__( ', ', 'jkl' ) );
            $search = ',';
            $separator = '';
            $test = $list;
            $class = 'tags-links';
            $string = esc_attr__( 'Tagged: ', 'jkl' );
            
        }
                
                if ( $test ) {
                        echo '<ul class="' . $class . '">';
                        echo $string;
                        
                        // So long as the Category list contains more items than our specified length, 
                        // we'll display the number of items specified, followed by a dropdown menu
                        // that houses the rest of the Categories
                        // Also note: -1 means we show ALL the categories without a dropdown
                        if( substr_count( $list, $search ) > $length && $length !== -1 ) {
                            
                            // For the number of specified items
                            for( $i = 1; $i <= $length; $i++ ) {
                                
                                // The Category will be the substring from the beginning of the string to the end of the first link </a> tag
                                $item = substr( $list, 0, ( strpos( $list, $search ) + strlen( $search ) ) );
                                
                                // If the NEXT item is the last item, give it a special CSS class to specify that
                                // just in case we want to style that one individually
                                if( $i == $length ) {
                                    echo str_replace( '<a ', '<a class="final-tax-link" ', $item );
                                } else {
                                    // otherwise, separate every Category with a comma
                                    echo $item . $separator;
                                }
                                // Now, remove that first category from the list (string) and continue the loop
                                $list = substr( $list, ( strpos( $list, $search ) + strlen( $search ) ) );
                            }
                            
                            // After looping through our specified number of Categories, output the rest of them in a dropdown menu
                            if( ! empty( $list ) ) {
                                echo '<span class="jkl-tax-switch"><i class="fa fa-angle-down"></i></span>';
                                printf( '<ul class="submenu dropdown">' . $list . '</ul>', $list ); // WPCS: XSS OK.     
                            }
                            
                        }
                            
                        // Else, in the case that our Category list is shorter than the specified $length
                        // OR  if we've specified -1 as the $length (to show all values)
                        else {
                            
                            // So long as we have Categories left in the string
                            while( $list !== '' ) {
                                
                                // Do the same as above, find the first Category and get ready to output it
                                $item = substr( $list, 0, ( strpos( $list, $search ) + strlen( $search ) ) );
                                
                                // If the Category list has only ONE Category (we check for a single </a> tag)
                                if( substr_count( $list, $search ) == 1 ) {
                                    // Output it without a comma
                                    echo $item;
                                } else {
                                    // Otherwise, separate the Categories with commas
                                    echo $item . $separator;
                                }
                                // Now, remove that first category from the list (string) and continue the loop
                                $list = substr( $list, ( strpos( $list, $search ) + strlen( $search ) ) );
                            }
                        }
                        
                        // Close the links list
                        echo '</ul>';
                        
		}
                
        } // END taxonomy list
        
        // If the taxonomy type is 'tag'
//        else if ( 'tag' === $taxonomy_type ) {
//                /* translators: used between list items, there is a space after the comma */
//                $tags_list = get_the_tag_list( '', esc_html__( ', ', 'jkl' ) );
//                
//                if( substr_count( $categories_list, '</a>' ) > $length && $length !== -1 ) {
//                if ( $tags_list ) {
//                    printf( '<span class="tags-links">' . esc_html__( 'Tagged: %1$s', 'jkl' ) . '</span>', $tags_list ); // WPCS: XSS OK.
//                }
//                
//        }
                
//                $first = strpos( $categories_list, '</a>' );
//                $first_cat = substr( $categories_list, 0, ( $first + 4 ) );
//                $replaced = str_replace( '<a ', '<a class="first-cat-link" ', $first_cat );
//                $the_rest = substr( $categories_list, ( $first + 4 ) );
//
//		if ( $categories_list && jkl_categorized_blog() ) {
//                        echo '<span class="cat-links">';
//                        
//                        esc_attr_e( 'Filed under: ', 'jkl' );
//                        
//                        echo $replaced;
//                        if( ! empty( $the_rest ) ) {
//                            echo '<span class="jkl-cat-switch"><i class="fa fa-angle-down"></i></span>';
//                            printf( '<ul class="submenu dropdown">' . $the_rest . '</ul>', $the_rest ); // WPCS: XSS OK.     
//                        }
//                        echo '</span>';
//		}
	
            
        
//    }
}

/**
 * DYNAMIC Copyright for the footer
 */
 function jkl_dynamic_copyright() {

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
function jkl_split_main_nav( $menu_name = null, $raw = false ) {

    if ( $menu_name == null || !is_string( $menu_name ) ) {
        return false;
    }
    $output = new stdClass();

    // Check if the menu exists and is set
    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {

        $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
        $menu_items = wp_get_nav_menu_items( $menu->term_id );

        // Create new array with only top level objects
        $newMenu = array();
        foreach( $menu_items as $item ) {
            if( $item->menu_item_parent != 0 ) continue;

            // get subnav
            $parentID = $item->ID;
            $item->subnav = array_filter( $menu_items, function( $v ) use ( $parentID ) {
                if ( $v->menu_item_parent == $parentID ) return $v;
            });

            array_push( $newMenu, $item );
        }

        // Split menu array in half
        $len = count( $newMenu );
        $firstThis = array_slice( $newMenu, 0, $len / 2 );
        $thenThat = array_slice( $newMenu, $len / 2 );


        if( $raw==true ) {
            $output->left_menu = $firstThis;
            $output->right_menu = $thenThat;
        } else {

            // Create LEFT menu
            $menuMarkup = '';
            $menuMarkup .= '<div id="main-nav-left" class="medium-6">
                            <ul class="nav-menu">';

                    foreach( $firstThis as $item ) {

                        // Add subnav if there is one
                        if( $item->subnav ) {
                            $menuMarkup .= '<li class="menu-item-has-children">
                                            <a href="' .$item->url . '">' . $item->title . '</a>';

                                    $menuMarkup .= '<ul class="sub-menu">';
                                        foreach( $item->subnav as $subitem ) {

                                            // Add SECOND LEVEL subnav if there is one (deepest possible level)
                                            if( $subitem->subnav ) {
                                                $menuMarkup .= '<li class="menu-item-has-children">
                                                                <a href="' . $subitem->url . '">' . $subitem->title . '</a>';

                                                $menuMarkup .= '<ul class="sub-menu">';
                                                foreach( $subitem->subnav as $subsubitem ) {
                                                    $menuMarkup .= '<li><a href="' . $subsubitem->url . '">' . $subsubitem->title . '</a></li>';
                                                }
                                                $menuMarkup .= '</ul>';

                                            } else {
                                                $menuMarkup .= '<li><a href="' . $subitem->url .'">' . $subitem->title . '</a></li>';
                                            }
                                        }
                                    $menuMarkup .= '</ul>';

                        } else {
                            $menuMarkup .= '<li><a href="' .$item->url . '">' . $item->title . '</a>';
                        }
                        $menuMarkup .= '</li>';

                    }

            $menuMarkup .= '</ul>
                            </div>';

            $output->left_menu = $menuMarkup;


            // Create RIGHT menu
            $menuMarkup = '';
            $menuMarkup .= '<div id="main-nav-right" class="medium-6">
                            <ul class="nav-menu">';

                    foreach( $thenThat as $item ) {

                        // Add subnav if there is one
                        if( $item->subnav ) {
                            $menuMarkup .= '<li class="menu-item-has-children">
                                            <a href="' .$item->url . '">' . $item->title . '</a>';

                                    $menuMarkup .= '<ul class="sub-menu">';
                                        foreach( $item->subnav as $subitem ) {

                                            // Add SECOND LEVEL subnav if there is one (deepest possible level)
                                            if( $subitem->subnav ) {
                                                $menuMarkup .= '<li class="menu-item-has-children">
                                                                <a href="' . $subitem->url . '">' . $subitem->title . '</a>';

                                                $menuMarkup .= '<ul class="sub-menu">';
                                                foreach( $subitem->subnav as $subsubitem ) {
                                                    $menuMarkup .= '<li><a href="' . $subsubitem->url . '">' . $subsubitem->title . '</a></li>';
                                                }
                                                $menuMarkup .= '</ul>';

                                            } else {
                                                $menuMarkup .= '<li class="no-subitem-i-guess"><a href="' . $subitem->url .'">' . $subitem->title . '</a></li>';
                                            }
                                        }
                                    $menuMarkup .= '</ul>';

                        } else {
                            $menuMarkup .= '<li><a href="' .$item->url . '">' . $item->title . '</a>';
                        }
                        $menuMarkup .= '</li>';

                    }

            $menuMarkup .= '</ul>
                            </div>';

            $output->right_menu = $menuMarkup;
        }

        return $output;

    }

    else {

        echo '<em>' . __( 'Please select a menu for your Split navigation.', 'jkl') . '</em>';

    }

}

/**
 * Social Menu
 */
function jkl_social_menu() {

    if ( has_nav_menu( 'social' ) ) {
        wp_nav_menu(
                array(
                    'theme_location'    => 'social',
                    'container'         => 'div',
                    'container_id'      => 'menu-social-container',
                    'container_class'   => 'menu-social',
                    'menu_id'           => 'menu-social-items',
                    'menu_class'        => 'menu-items',
                    'depth'             => 1,
                    'link_before'       => '<span class="screen-reader-text">',
                    'link_after'        => '</span>',
                    'fallback_cb'       => '',
                )
        );
    }

}

/*
 * Validate Gravatar
 * @link: original: https://gist.github.com/justinph/5197810
 * @link: WP.org: http://codex.wordpress.org/Using_Gravatars#Checking_for_the_Existence_of_a_Gravatar
 */

/**
 * Utility function to check if a gravatar exists for a given email or id
 * @param int|string|object $id_or_email A user ID,  email address, or comment object
 * @return bool if the gravatar exists or not
 */

function jkl_validate_gravatar($id_or_email) {
  //id or email code borrowed from wp-includes/pluggable.php
	$email = '';
	if ( is_numeric($id_or_email) ) {
		$id = (int) $id_or_email;
		$user = get_userdata($id);
		if ( $user )
			$email = $user->user_email;
	} elseif ( is_object($id_or_email) ) {
		// No avatar for pingbacks or trackbacks
		$allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
		if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) )
			return false;

		if ( !empty($id_or_email->user_id) ) {
			$id = (int) $id_or_email->user_id;
			$user = get_userdata($id);
			if ( $user)
				$email = $user->user_email;
		} elseif ( !empty($id_or_email->comment_author_email) ) {
			$email = $id_or_email->comment_author_email;
		}
	} else {
		$email = $id_or_email;
	}

	$hashkey = md5(strtolower(trim($email)));
	$uri = 'http://www.gravatar.com/avatar/' . $hashkey . '?d=404';

	$data = wp_cache_get($hashkey);
	if (false === $data) {
		$response = wp_remote_head($uri);
		if( is_wp_error($response) ) {
			$data = 'not200';
		} else {
			$data = $response['response']['code'];
		}
	    wp_cache_set($hashkey, $data, $group = '', $expire = 60*5);

	}
	if ($data == '200'){
		return true;
	} else {
		return false;
	}
}



if ( ! function_exists( 'jkl_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * Improve the post_nav() with post thumbnails. Help from this
 * @link: http://www.measureddesigns.com/adding-previous-next-post-wordpress-post/
 * @link: http://wpsites.net/web-design/add-featured-images-to-previous-next-post-nav-links/
 */
function jkl_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
        $prevID   = $previous ? $previous->ID : '';
        $nextID   = $next ? $next->ID : '';

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation clear" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Post navigation', 'jkl' ); ?></h2>

                <div class="nav-links">
                    <?php // My custom code below FIRST, then _s code

                    // PREVIOUS POST LINK
                    if ( ! empty( $previous ) ) { ?>
                    <div class="nav-previous">
                        <a href="<?php echo get_permalink( $prevID ); ?>" rel="prev">

                            <?php if ( ( has_post_thumbnail( $prevID ) && has_post_thumbnail( $nextID ) ) /* || ( has_post_thumbnail( $prevID ) && empty( $next ) )*/ ) { 
                                    $prev_thumb = get_the_post_thumbnail_url( $prevID, 'medium' );
                                    $prev_thumb = $prev_thumb ? $prev_thumb : get_header_image();
                                    ?>
                                    <div class="post-nav-thumb" style="background-image: url( <?php echo $prev_thumb; ?> )">
                                        <!-- Placeholder for image -->
                                    </div>
                            <?php } ?>

                            <span class="meta-nav" aria-hidden="true"><?php _e( 'Previously', 'jkl' ); ?></span>
                            <span class="screen-reader-text"><?php _e( 'Previous Post', 'jkl' ); ?></span>
                            <span class="post-title"><?php echo $previous->post_title; ?></span>

                        </a>
                    </div>
                    <?php }

                    // NEXT POST LINK
                    if ( ! empty( $next ) ) { ?>
                    <div class="nav-next">
                        <a href="<?php echo get_permalink( $nextID ); ?>" rel="next">

                            <?php if ( ( has_post_thumbnail( $prevID ) && has_post_thumbnail( $nextID ) ) ) { 
                                    $next_thumb = get_the_post_thumbnail_url( $nextID, 'medium' );
                                    $next_thumb = $next_thumb ? $next_thumb : get_header_image();
                                    ?>
                                    <div class="post-nav-thumb"style="background-image: url( <?php echo $next_thumb; ?> )">
                                        <!-- Placeholder for image -->
                                    </div>
                            <?php } ?>

                            <span class="meta-nav" aria-hidden="true"><?php _e( 'Next time', 'jkl' ); ?></span>
                            <span class="screen-reader-text"><?php _e( 'Next Post', 'jkl' ); ?></span>
                            <span class="post-title"><?php echo $next->post_title; ?></span>

                        </a>
                    </div>
                    <?php } ?>

                </div><!-- .nav-links -->

	</nav><!-- .navigation -->
	<?php
}
endif;


/*
 * Customize the read-more indicator for excerpts
 */
function jkl_excerpt_more( $more ) {
    return " …";
}
add_filter( 'excerpt_more', 'jkl_excerpt_more' );


/*
 * Special Index Posted On Meta info for Index pages only
 */
if ( ! function_exists( 'jkl_index_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function jkl_index_posted_on() {
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
        
        $byline = sprintf(
		esc_html( '%s' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">@' . esc_html( get_the_author() ) . '</a></span>'
	);
        
        if( 'chat' === get_post_format() ||
            'image' === get_post_format() ||
            'gallery' === get_post_format() ||
            'audio' === get_post_format() ||
            'video' === get_post_format() ) {
            $string = ucwords( get_post_format() );
            $posted_on = $string . ': <a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';
        } else {
            $posted_on = sprintf(
		esc_html_x( 'Date: %s', 'post date', 'jkl' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
            );
        }
        
        $meta_class = is_single() ? 'format-small-meta' : 'meta-content-index';
        echo '<div class="' . $meta_class . '">';
	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
        if( is_single() ) {
            //echo '<span class="entry-footer-index">';
            echo '<span class="byline">' . $byline . '</span>';
            //jkl_better_taxonomy_listing('category', 1);
            //echo '</span>';
        }
        echo '</div><!-- .meta-content-index -->';
}
endif;


if ( ! function_exists( 'jkl_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Twenty Fourteen 1.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 */
function jkl_paging_nav() {
	global $wp_query, $wp_rewrite;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $wp_query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 3,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&larr; Previous', 'jkl' ),
		'next_text' => __( 'Next &rarr;', 'jkl' ),
                'type'      => 'list',
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'jkl' ); ?></h1>
                <?php echo $links; ?>
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;


if ( ! function_exists( 'jkl_breadcrumbs' ) ) :
/**
 * Display Post breadcrumbs when applicable.
 *
 * @since JKL 1.0
 *
 * @link: https://www.thewebtaylor.com/articles/wordpress-creating-breadcrumbs-without-a-plugin
 */
function jkl_breadcrumbs() {

    if (!is_home()) {

        // Settings
        $separator          = '<span class="breadcrumb-separator">&raquo;</span>';
        $breadcrumb_id      = 'breadcrumbs';
        $breadcrumb_class   = 'breadcrumbs';
        $post               = get_post();

        if( is_category() || is_single() || ( is_page() && $post->post_parent ) ) {
        // Build the breadcrumbs
        echo "<div aria-label='You are here:' id='$breadcrumb_id' class='$breadcrumb_class'>";
		echo '<a aria-label="Home" title="Home" class="breadcrumb-home" href="';
		echo esc_url( home_url() );
		echo '"><span class="screen-reader-text">';
		bloginfo('name');
		echo "</span></a>$separator";

                $categories = get_the_category();
                $categories = array_slice( $categories, 0, 5 );

                foreach ( $categories as $category ) {
                    printf( '<a href="%1$s">%2$s</a>',
                        esc_url( get_category_link( $category->term_id ) ),
                        esc_html( $category->name )
                    );
                    echo $separator;
                }
			
        echo '</div>';
        }
    }

}
endif;

function jkl_link_screenshot( $width = 150 ) {
    global $post;
    $first_link = substr( $post->post_content, strpos( $post->post_content, '<a>' ), strpos( $post->post_content, '</a>' ) + 4 );
 
    preg_match_all( '/<a[^>]+href=([\'"])(.+?)\1[^>]*>/i', $first_link, $site );

    if( !empty( $site[2] ) ) {
        $query_url = 'http://s.wordpress.com/mshots/v1/';
        $site_url = $site[2][0]; // something like www.example.com
        $image_tag = '<img class="link-screenshot-img" alt="' . $site_url . '" width="' . $width . '" src="' . $query_url . urlencode(  $site_url ) . '?w=' . $width .'">';

        $text = '<figure class="featured-image"><a class="link-screenshot" href="http://' . $site_url . '">' . $image_tag . '<figcaption class="wp-caption-text">' . $first_link . '</figcaption></a></figure>';
        
        echo $text;
    }
}
