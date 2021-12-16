<?php
if( !class_exists('RB_Filter_Panel') ){
    class RB_Filter_Panel{
        public $id;
        public $filters = array();
        public $settings = array();

        public function __construct( $id, $filters, $options = array() ) {
            $this->id = $id;
            $this->settings = array_merge( $this->settings, $options );

            foreach( $filters as $filter_id => $filter_settings ){
                $new_filter = new RB_Radio_Filter( $filter_id, $filter_settings['title'], $filter_settings['options'], $filter_settings['settings'] );
                array_push( $this->filters, $new_filter );
            }
        }

        public function get_setting( $name ){
            $setting = '';
            if( isset($this->settings[$name]) )
                $setting = $this->settings[$name];
            return $setting;
        }

        public function render(){
            ?>
            <div id="<?php echo $this->id; ?>" class="rb-wp-filters <?php echo $this->get_setting('class'); ?>">
                <div class="filters <?php echo $this->get_setting('filter-class'); ?>">
                    <?php
                    foreach( $this->filters as $filter ){
                        $filter->render();
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    }

    abstract class RB_Filter_Type{
        public $id;
        public $title;
        public $type;
        public $options;
        public $settings = array();

        public function __construct( $id, $title, $options, $settings = array() ) {
            $this->id = $id;
            $this->title = $title;
            $this->options = $options;
            $this->settings = array_merge( $this->settings, $settings );
        }

        public function get_setting( $name ){
            $setting = '';
            if( isset($this->settings[$name]) )
                $setting = $this->settings[$name];
            return $setting;
        }

        final public function render(){
            ?>
            <div class="filter <?php echo $this->get_setting('class'); ?>" data-filter data-id="<?php echo $this->id; ?>" data-type="<?php echo $this->type; ?>">
                <h2 class="title"><?php echo $this->title; ?></h4>
                <?php $this->render_options(); ?>
            </div>
            <?php
        }

        abstract function render_options();
    }

    class RB_Radio_Filter extends RB_Filter_Type{
        public $type = 'radio';

        public function render_options(){
            ?>
            <ul class="filter-options">
                <?php foreach( $this->options as $option ): ?>
                <li data-option data-value="<?php echo $option['value']; ?>"><?php echo $option['title']; ?></li>
                <?php endforeach; ?>
            </ul>
            <?php
        }
    }
}
