<?php
/**
 * Plugin Name: Image Widget Simple
 * Author: Vitor Hugo Rodrigues Merencio
 * Version: 1.0
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
    $url = sanitize_url( $instance['url'] );
    $alt = $instance['alt'];

    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];

    echo '<img src="' . $url . '" alt="' . $alt . '" />';

    echo $args['after_widget'];
  }

  // Widget Backend
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
      $url = $instance['url'];
      $alt = $instance['alt'];
    }
    else {
      $title = __('Imagem Widget');
      $url = sanitize_url('https://thumbs.dreamstime.com/x/milky-way-over-sea-long-time-exposure-night-landscape-galaxy-above-black-59118392.jpg');
      $alt = __('Apenas uma imagem');
    }
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    <label for="<?php echo $this->get_field_id( 'url' ); ?>">Caminho da imagem (URL)</label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" type="text" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo esc_attr( $url ); ?>" placeholder="URL.." />
    <label for="<?php echo $this->get_field_id( 'alt' ); ?>">Descrição da imagem</label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'alt' ); ?>" type="text" name="<?php echo $this->get_field_name( 'alt' ); ?>" value="<?php echo esc_attr( $alt ); ?>" placeholder="Alt.." />
    </p>
    <?php
  }

  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['url'] = ( ! empty( $new_instance['url'] ) ) ? sanitize_url( $new_instance['url'] ) : '';
    $instance['alt'] = ( ! empty( $new_instance['alt'] ) ) ? strip_tags( $new_instance['alt'] ) : '';
    return $instance;
  }
} // Class imageWidget ends here


// Register and load the widget
function imageWidgetLoad() {
	register_widget( 'imageWidget' );
}

register_activation_hook( __FILE__, add_action( 'widgets_init', 'imageWidgetLoad' ) );
