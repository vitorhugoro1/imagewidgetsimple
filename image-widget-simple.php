<?php
/**
 * Plugin Name: Image Widget Simple
 * Author: Vitor Hugo Rodrigues Merencio
 * Version: 1.1
 * Description: Plugin que adiciona um Widget para mostrar imagens
 */

class imageWidget extends WP_Widget {

  function __construct(){
    parent::__construct(
      'imageWidget',
      __('Image Widget Simple'),
      array('description' => __('Show responsive image with URL, title and alt'))
    );
  }

  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    $img = $instance['img'];
    $alt = $instance['alt'];
    $url = $instance['url'];

    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];

    if( ! empty( $url )) :
      echo sprintf('<a href="%s" target="_blank"> <img src="%s" alt="%s" /> </a>', $url, $img, $alt);
    else :
      echo sprintf('<img src="%s" alt="%s" />', $img, $alt);
    endif;

    echo $args['after_widget'];
  }

  // Widget Backend
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
      $img = $instance['img'];
      $alt = $instance['alt'];
      $url = $instance['url'];
    }
    else {
      $title = __('Imagem Widget');
      $img = sanitize_url('https://thumbs.dreamstime.com/x/milky-way-over-sea-long-time-exposure-night-landscape-galaxy-above-black-59118392.jpg');
      $alt = __('Apenas uma imagem');
      $url = '';
    }
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    <label for="<?php echo $this->get_field_id( 'img' ); ?>">Caminho da imagem (URL)</label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'img' ); ?>" type="text" name="<?php echo $this->get_field_name( 'img' ); ?>" value="<?php echo esc_attr( $img ); ?>" placeholder="Caminho da imagem" />
    <label for="<?php echo $this->get_field_id( 'alt' ); ?>">Descrição da imagem</label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'alt' ); ?>" type="text" name="<?php echo $this->get_field_name( 'alt' ); ?>" value="<?php echo esc_attr( $alt ); ?>" placeholder="Alt.." />
    <label for="<?php echo $this->get_field_name('url')?>">Link externo</label>
    <input class="widefat" type="text" name="<?php echo $this->get_field_name('url')?>" id="<?php echo $this->get_field_id('url')?>" value="<?php echo esc_attr( $url ); ?>" placeholder="Link eterno" >
    </p>
    <?php
  }

  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['img'] = ( ! empty( $new_instance['img'] ) ) ? sanitize_url( $new_instance['img'] ) : '';
    $instance['alt'] = ( ! empty( $new_instance['alt'] ) ) ? strip_tags( $new_instance['alt'] ) : '';
    $instance['url'] = ( ! empty( $new_instance['url'] ) ) ? sanitize_url( $new_instance['url'] ) : '';
    return $instance;
  }
} // Class imageWidget ends here


// Register and load the widget
function imageWidgetLoad() {
	register_widget( 'imageWidget' );
}

register_activation_hook( __FILE__, add_action( 'widgets_init', 'imageWidgetLoad' ) );
