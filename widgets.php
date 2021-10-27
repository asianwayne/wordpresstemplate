<?php 

/**
 * Adds Newsletter Subscriber widget.
 */
class Newsletter_Subscriber_Widget extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  function __construct() {
    parent::__construct(
      'newsletter_subscriber_widget', // Base ID
      esc_html__( 'Newsletter Subscriber', 'text_domain' ), // Name
      array( 'description' => esc_html__( 'Newsletter Subscriber Widget', 'text_domain' ), ) // Args
    );
  }

 

  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form( $instance ) {

    $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
    $recipient = $instance['recipient'];
    $subject = $instance['subject'];
    ?>
    <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
     <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'recipient' ) ); ?>"><?php esc_attr_e( 'Recipient:', 'text_domain' ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'recipient' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'recipient' ) ); ?>" type="text" value="<?php echo esc_attr( $recipient ); ?>">
    </p>
     <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'subject' ) ); ?>"><?php esc_attr_e( 'Subject:', 'text_domain' ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'subject' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subject' ) ); ?>" type="text" value="<?php echo esc_attr( $subject ); ?>">
    </p>
    <?php 
  }

  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update( $new_instance, $old_instance ) {

    $instance = array(
      'title' => ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '',
      'recipient' => ( ! empty( $new_instance['recipient'] ) ) ? sanitize_text_field( $new_instance['recipient'] ) : '',
      'subject' => ( ! empty( $new_instance['subject'] ) ) ? sanitize_text_field( $new_instance['subject'] ) : '',
    );
   
    return $instance;
  }

   /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget( $args, $instance ) {
    echo $args['before_widget'];
    if ( ! empty( $instance['title'] ) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
    } ?>

    <div class="form-msg"></div>
    <form method="POST" id="subscriber-form" action="<?php echo plugin_dir_url( __DIR__ ) . 'inc/newsletter-subscriber-mailer.php'; ?>">
      

  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="theemail" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Name</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="thename">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <input type="hidden" name="recipient" value="<?php echo $instance['recipient'] ?>">
      <input type="hidden" name="subject" value="<?php echo $instance['subject'] ?>">
  <button type="submit" class="btn btn-primary">Subscribe</button>

  
</form>


    <?php 
    echo $args['after_widget'];
  }

} // class Foo_Widget
