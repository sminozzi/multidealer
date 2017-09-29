<?php 
/**
 * @author Bill Minozzi
 * @copyright 2017
 */
function multidealer_RecentWidget() {
	register_widget( 'multidealer_RecentWidget' );
}
add_action( 'widgets_init', 'multidealer_RecentWidget' );
class multidealer_RecentWidget extends WP_Widget {
       public function __construct() {
        parent::__construct(
        'RecentWidget',         
        'Recent products',                
        array( 'description' => __('A list of Recent products', 'multidealer'), ) 
        );
    }   
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'amount' => '','Fwidth' => '','Fheight' => '') );
        if(isset($instance['Ramount']))
          {$Ramount = $instance['Ramount'];}
        else
          {$Ramount = 3;}
		echo '<p>
			<label for="'.$this->get_field_id('Ramount').'">
				Number of products to show: <input maxlength="1" size="1" id="'. $this->get_field_id('Ramount') .'" name="'. $this->get_field_name('Ramount') .'" type="text" value="'. esc_attr($Ramount) .'" />
			</label>
		</p>';
	}
    
	function update($new_instance, $old_instance) { 
		$instance = $old_instance;
        if(is_numeric($new_instance['Ramount']))
		    {$instance['Ramount'] = $new_instance['Ramount'];}
      	return $instance;
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$Ramount = empty($instance['Ramount']) ? ' ' : apply_filters('widget_title', $instance['Ramount']); 
		if($Ramount == '') {$Ramount = 3; }
        ?>
	    <div class="sideTitle"> <?php echo __('New Arrivals', 'multidealer');?> </div><?php 
		$args = array(
			'post_type'      => 'products',
			'order'    => 'DESC',
			'showposts' => $Ramount,
		);
        $_query3 = new WP_Query( $args );
    $output = '<div class="MultiDealer-listing-wrap"> <div class="multiGallery">';
	while ($_query3->have_posts()) : $_query3->the_post();
		$image_id = get_post_thumbnail_id();
		$image_url = wp_get_attachment_image_src($image_id,'medium', true);	
        $price = get_post_meta(get_the_ID(), 'multi-price', true);
            if (!empty($price))
                 {$price =   number_format_i18n($price,0);}
		$image = str_replace("-".$image_url[1]."x".$image_url[2], "", $image_url[0]);
		$featured = trim(get_post_meta(get_the_ID(), 'multi-featured', true));
        $thumb = MultiDealer_theme_thumb($image, 800, 400, 'br'); // Crops from bottom right
        $year = get_post_meta(get_the_ID(), 'multi-year', true);
            $output .= '<div>';
            $output .=  '<a href="' . get_permalink() . '">';
            $output .= '<div class="MultiDealer_gallery_2016_widget">';
            $output .=  '<img class="MultiDealer_caption_img_widget" src="' . $thumb .'" alt="'. get_the_title() . '" />';
            $output .= '<div class="MultiDealer_caption_text_widget">';
            $output .= ($price <> '' ? multidealer_currency() . $price : __('Call for Price', 'multidealer'));
            $output .= '<br />';
            $output .= ($year <> '' ? __('Year', 'multidealer') .': '. $year.'<br />' : '');
            $output .= '</div>';
            $output .= '<div class="multiTitle-widget">' . get_the_title() . '</div>';
            $output .= '</div>';
            $output .= '</a>';
            $output .= '</div>';     
            $output .= '<br />';        
		endwhile; 
        $output .= '</div></div>'; 
        echo $output;
	}
}
function multidealer_FeaturedWidget() {
	register_widget( 'multidealer_FeaturedWidget' );
}
add_action( 'widgets_init', 'multidealer_FeaturedWidget' );
class multidealer_featuredWidget extends WP_Widget {
    public function __construct() {
        parent::__construct(
        'FeaturedWidget',         
        'Featured products',                
        array( 'description' => __('A list of Featured products', 'multidealer'), ) 
        );
    } 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'amount' => '') );
		$amount = $instance['amount'];
		echo '<p>
			<label for="'.$this->get_field_id('amount').'">
				Number of products to show: <input maxlength="1" size="1" id="'. $this->get_field_id('amount') .'" name="'. $this->get_field_name('amount') .'" type="text" value="'. esc_attr($amount) .'" maxlength="3" size="3" />
			</label>
		</p>';
	}
	function update($new_instance, $old_instance) { 
		$instance = $old_instance;
        if(is_numeric($new_instance['amount']))
		    {$instance['amount'] = $new_instance['amount'];}       
		return $instance;
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$amount = empty($instance['amount']) ? ' ' : apply_filters('widget_title', $instance['amount']); 
		if($amount == '') {$amount = 3; }
    ?>
        <div class="sideTitle"> 
        <?php echo __('Featured products', 'multidealer');?> 
        </div><?php 
		$args = array(
			'post_type'      => 'products',
			'order'    => 'DESC',
			'showposts' => $amount,
			'meta_query' => array(
								array(
										'key' => 'product-featured',
										'value' => 'enabled',
									  )
								   )
		);
        $_query2 = new WP_Query( $args );
		$output = '<div class="MultiDealer-listing-wrap"> <div class="multiGallery">';
		while ($_query2->have_posts()) : $_query2->the_post();
		$image_id = get_post_thumbnail_id();
		$image_url = wp_get_attachment_image_src($image_id,'medium', true);	
        $price = trim(get_post_meta(get_the_ID(), 'multi-price', true));
        if(! empty($price))
           $price = number_format_i18n($price);
        $image = str_replace("-".$image_url[1]."x".$image_url[2], "", $image_url[0]);
        $featured = get_post_meta(get_the_ID(), 'multi-featured', true);
        $thumb = MultiDealer_theme_thumb($image, 800, 400, 'br'); // Crops from bottom right
        $year = get_post_meta(get_the_ID(), 'multi-year', true);
            $output .= '<div>';
            $output .=  '<a href="' . get_permalink() . '">';
            $output .= '<div class="MultiDealer_gallery_2016_widget">';
            $output .=  '<img class="MultiDealer_caption_img_widget" src="' . $thumb .'" alt="'. get_the_title() . '" />';
            $output .= '<div class="MultiDealer_caption_text_widget">';
            $output .= ($price <> '' ? multidealer_currency() . $price : __('Call for Price', 'multidealer'));
            $output .= '<br />';
            $output .= ($year <> '' ? __('Year', 'multidealer') .': '. $year : '');
            $output .= '</div>';
            $output .= '<div class="multiTitle-widget">' . get_the_title() . '</div>';
            $output .= '</div>';
            $output .= '</a>';
            $output .= '</div>';     
            $output .= '<br />';
        endwhile; 
        $output .= '</div></div>'; 
        echo $output;
	}
}
add_action( 'widgets_init', create_function('', 'return register_widget("multidealer_SearchWidget");') );
class multidealer_SearchWidget extends WP_Widget {
public function __construct() {
        parent::__construct(
        'SearchWidget',         
        'Search products',                
        array( 'description' => __('Search products', 'multidealer'), ) 
        );
}     
	function SearchWidget()	{
		$widget_ops = array('classname' => 'SearchWidget', 'description' => 'Search Cars' );
		$this->WP_Widget('SearchWidget', 'Search Widget', $widget_ops);
	}
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'MultiDealer_search_name' => '') );
		$MultiDealer_search_name = $instance['MultiDealer_search_name'];
		echo '<p>
			<label for="'.$this->get_field_id('MultiDealer_search_name').'">';
				echo __('Title', 'multidealer');
                echo ': <input class="widefat" id="'. $this->get_field_id('MultiDealer_search_name') .'" name="'. $this->get_field_name('MultiDealer_search_name') .'" type="text" value="'. esc_attr($MultiDealer_search_name) .'" />
			</label>
		</p>';
	}
	function update($new_instance, $old_instance) { 
		$instance = $old_instance;
		$instance['MultiDealer_search_name'] = $new_instance['MultiDealer_search_name'];
		return $instance;
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$MultiDealer_search_name = empty($instance['MultiDealer_search_name']) ? ' ' : apply_filters('widget_title', $instance['MultiDealer_search_name']); 
		if(trim($MultiDealer_search_name) == '') {$MultiDealer_search_name = __('Search', 'multidealer'); }        
        echo '<div class="sideTitle">';
        echo $MultiDealer_search_name;
        echo '</div>';        
		echo MultiDealer_search(0);
	}   
}