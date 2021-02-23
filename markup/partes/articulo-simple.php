<?php
$article = TA_Article_Factory::get_article($post);

$date = $article->get_date_day('d/m/Y');

$thumbnail = $article->get_thumbnail();
$section = $article->section;
$author = $article->first_author;
?>
<div class="articulo-simple text-right my-4">
    <div class="container">
        <div class="text-left mx-auto">
            <?php if( $section ): ?>
            <div class="categories d-flex">
                <a href="<?php echo esc_attr($section->archive_url); ?>"><h4 class="theme mr-2"><?php echo esc_html($section->name); ?></h4></a>
            </div>
            <?php endif; ?>
            <div class="pl-lg-5">
                <div class="title mt-2">
                    <h1><?php echo esc_html($article->title); ?></h1>
                </div>
                <?php if( $article->excerpt ): ?>
                <div class="subtitle">
                    <h3><?php echo esc_html($article->excerpt); ?></h3>
                </div>
                <?php endif; ?>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <?php if( $date ): ?>
                    <p class="date mb-0"><?php echo $date; ?></p>
                    <?php endif; ?>
                    <div class="social-btns">
                        <a href="">
                            <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/comentar.svg" alt="" />
                        </a>
                        <a href="">
                            <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/compartir.svg" alt="" />
                        </a>
                        <a href="">
                            <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/guardar.svg" alt="" />
                        </a>
                    </div>
                </div>
            </div>
            <?php if( $thumbnail ): ?>
            <div class="img-container mt-3">
                <div class="img-wrapper">
                    <img src="<?php echo esc_attr($thumbnail['url']); ?>" alt="<?php echo esc_attr($thumbnail['alt']); ?>" class="img-fluid w-100" />
                </div>
                <?php if( $thumbnail['author'] ): ?>
                <div class="credits text-right mt-2">
                    <p>Foto: <?php echo esc_html($thumbnail['author']); ?></p>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if($author && $author->name): ?>
            <div class="d-flex flex-column flex-md-row">
                <div class="author d-flex mx-2">
                    <div class="author-icon mr-2">
                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/author-pen.svg" alt="" />
                    </div>
                    <div class="author-info">
                        <p>Por: <a href="<?php echo esc_attr($author->archive_url); ?>"><?php echo esc_html($author->name); ?></a></p>
                        <?php if($author->position): ?>
                        <p><?php echo esc_html($author->position); ?></p>
                        <?php endif; ?>
                        <?php if($author->social): ?>
                        <a href="">@<?php echo esc_html($author->social); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

            <div class="article-body mt-3">
                <div class="pl-lg-5">
                    <?php //echo $article->content;
                        echo apply_filters( 'the_content', $article->content );
                     ?>
                    <div class="d-none">
                        <p>Durante el siglo XIV, la denominada peste negra se extendió por Asia Menor, Oriente Medio,
                            el norte de Africa y Europa, alcanzando su pico máximo entre 1346 y 1353 con un saldo aproximado
                            de
                            20
                            millones de muertes.
                            <span>En algunos estados de la península ibérica, la Santa Inquisición impulsó.</span>
                        </p>

                        <div class="img-container mt-4">
                            <div class="img-wrapper">
                                <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/foto-nota.png" alt="" class="img-fluid w-100" />
                            </div>
                            <div class="credits text-right mt-2 d-flex justify-content-end align-items-center">
                                <div class="credits-info d-flex flex-column mr-2">
                                    <p>Foto: Mister Fotógrafe</p>
                                    <a href="">@holafotografe</a>
                                </div>
                                <div class="credits-icon">
                                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/camera-icon.svg" alt="" />
                                </div>
                            </div>
                        </div>
                        <div class="bajada mt-3">
                            <p>Una bajadita de texto con comentario sencillo sobre la foto, donde explique de que se trata,
                                por
                                las dudas se necesite explicar algo. </p>
                        </div>
                        <p class="mt-3"><span>Este es un ejemplo de subtítulo</span></p>
                        <p class="mt-3">Durante el siglo XIV, la denominada peste negra se extendió por Asia Menor, Oriente
                            Medio, el norte
                            de Africa y Europa, alcanzando su pico máximo entre 1346 y 1353 con un saldo aproximado de 20
                            millones de muertes. En algunos estados de la península ibérica, la Santa Inquisición impulsó.El
                            gobernador sobreactuó su gesta por la salud pública con dos medidas sorprendentes: la súbita
                            expulsión de 61 migrantes de países.</p>

                        <div class="featured-quote mt-4">
                            <div class="quote-body">
                                <p>“Todo reclamo de la provincia que estime tener en relación con un Estado extranjero debe
                                    remitirlo al gobierno nacional.“
                                </p>
                            </div>
                            <div class="author-quoted mt-2">
                                <p>Felipe Solá, Canciller Argentino. Abril 2020</p>
                            </div>
                        </div>
                        <p class="mt-3">El gobernador sobreactuó su gesta por la salud pública con dos medidas
                            sorprendentes: la
                            súbita
                            expulsión de 61 migrantes de países latinoamericanos –quienes fueron arreados en un micro hacia
                            Buenos Aires– y el anunció de poner una faja en las casas de posibles infectados.</p>
                        <div class="anuncio-seccion text-center mt-3">
                            <div class="separator my-2"></div>
                            <div class="anuncio-container">
                                <div>
                                    <p>El autor <a href="">@RRagendorfer</a> estará respondiendo prenguntas relacionadas a
                                        este
                                        tema en el
                                        bloque <span>PREGUNTÁ Y PARTICIPÁ</span></p>
                                </div>
                                <div>
                                    <a href="">> Click aquí para ir a la sección < </a>
                                </div>
                            </div>
                            <div class="separator my-3"></div>
                        </div>
                        <p class="mt-3"><span>Puede haber más de un subtítulo por nota</span></p>
                        <p class="mt-3">El gobernador sobreactuó su gesta por la salud pública con dos medidas
                            sorprendentes: la
                            súbita
                            expulsión de 61 migrantes de países latinoamericanos –quienes fueron arreados en un micro hacia
                            Buenos Aires– y el anunció de poner una faja en las casas de posibles infectados.</p>
                        <div class="ta-subnote-block mt-4">
                            <div class="separator"></div>
                            <div class="p-3">
                                <div class="title">
                                    <h2>Subnota: cambio de tema dentro de la nota principal</h2>
                                </div>
                                <div class="content">
                                    <p>El gobernador sobreactuó su gesta por la salud pública con dos medidas sorprendentes:
                                        “la
                                        súbita expulsión de 61 migrantes de países latinoamericanos –quienes fueron arreados
                                        en
                                        un
                                        micro hacia Buenos Aires–” y el anunció de poner una faja en las casas de posibles
                                        infectados.
                                    </p>
                                    <p class="mt-2">Durante el siglo XIV, la denominada peste negra se extendió por
                                        <span>Asia
                                            Menor, Oriente
                                            Medio,
                                            el norte de Africa y Europa,</span> alcanzando su pico máximo entre 1346 y 1353
                                        con
                                        un
                                        saldo
                                        aproximado de 20 millones de muertes. En algunos estados de la península ibérica, la
                                        Santa
                                        Inquisición impulsó.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="ta-event-block mt-4">
                            <div class="p-3">
                                <div class="title">
                                    <h2 class="bold">Título o Títulos del evento</h2>
                                </div>
                                <div class="content">
                                    <p><span>Actúan:</span> Sandra Mihanovich, Paula Maffia,
                                        Quinteto Astor Piazzolla, Yamile Burich y el Trío Luminar.
                                    </p>
                                    <p><span>Sábado 26 de Septiembre,
                                            20:00 hs Vía:</span> <a href="" class="red-font">experienciapiazzolla.com</a> y
                                        <a href="" class="red-font">página de YouTube
                                            del CC
                                            Konex.</a>
                                    </p>
                                    <p class="bold red-font">ACCESO GRATUITO</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="social-btns text-right mt-3">
                <a href="">
                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/comentar.svg" alt="" />
                </a>
                <a href="">
                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/compartir.svg" alt="" />
                </a>
                <a href="">
                    <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/guardar.svg" alt="" />
                </a>
            </div>
        </div>
    </div>
    <div class="container-md mb-2 p-0">
        <div class="separator"></div>
    </div>
</div>
