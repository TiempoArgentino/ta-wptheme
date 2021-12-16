<?php
/*
 *
 */
$defaults = array(
    /**
    *   @param string $title
    */
    'title'                     => "En Tiempo Argentino hacemos periodismo sin fines de lucro.",
    /**
    *   @param string $body
    */
    'body'                      => "<b>Nuestra agenda se guía por los temas socialmente relevantes</span>, por eso abordamos
                            problemáticas
                            habitualmente marginadas de los otros medios de comunicación masivos.",
    /**
    *   @param string $btn
    */
    'btn'                       => "SEAMOS SOCIOS",
);
extract( array_merge( $defaults, $args ) );
?>
<div class="container mt-3">
    <div class="ta-socios-block mx-auto px-3 py-4">
        <div class="socios-header-container d-flex flex-column">
            <div class="content">
                <div class="title">
                    <h2><?php echo $title; ?></h2>
                </div>
                <div class="subtitle">
                    <p><?php echo $body; ?></p>
                </div>
            </div>
            <div class="img-btn">
                <div class="img-container text-center mt-3">
                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/asociate.svg" alt="" class="w-100 h-auto" />
                </div>
                <div class="btns-container">
                    <div class="asociarme-btn d-flex justify-content-center mx-auto mt-3">
                    <a href="<?php echo get_permalink(get_option('subscriptions_loop_page')) ?>" class="text-light"><button><?php echo $btn; ?></button></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
