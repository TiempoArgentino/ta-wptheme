<div class="mx-3">
    <div class="line-height-0">
        <div class="separator m-0"></div>
    </div>
    <div class="container-with-header ta-context dark-blue blue-border py-3">
        <div class="context-color">
            <div class="container d-block d-md-none">
                <div class="section-title">
                    <h4>FOTOGALERÍA</h4>
                </div>
            </div>
            <div class="container d-md-flex my-2 my-md-4 p-0">
                <div id="carousel" class="col-12 col-md-8 fotogaleria carousel slide" data-ride="carousel"
                    data-interval="false">

                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="../../assets/images/slide-photo.jpg" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="../../assets/images/autor-photo.jpg" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="../../assets/images/mineria.jpg" alt="Third slide">
                        </div>
                    </div>
                </div>
                <div id="carousel2"
                    class="col-12 col-md-4 d-flex flex-column flex-md-column-reverse justify-content-between  fotogaleria carousel slide"
                    data-ride="carousel" data-interval="false">
                    <div class="d-flex justify-content-between align-items-center my-3">
                        <a class="carousel-control-prev" href=".carousel" role="button" data-slide="prev">
                            <img src="../../assets/images/right-arrow.png" alt="" />
                            <span class="sr-only">Previous</span>
                        </a>
                        <ol class="carousel-indicators m-0">
                            <li data-target="#carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel" data-slide-to="1"></li>
                            <li data-target="#carousel" data-slide-to="2"></li>
                        </ol>
                        <a class="carousel-control-next" href=".carousel" role="button" data-slide="next">
                            <img src="../../assets/images/right-arrow.png" alt="" />
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <div>
                        <div class="container d-none d-md-block">
                            <div class="article-border"></div>
                            <div class="section-title">
                                <h4>FOTOGALERÍA</h4>
                            </div>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class=" ml-md-3 text-left">
                                    <p class="slide-title">Sideral</p>
                                    <p class="slide-content">Elijamos la palabra: mito, héroe, leyenda, crack,
                                        invencible….
                                        Todas
                                        son apropiadas para
                                        definir a Diego Maradona. Y si en estos días no se mezquinan para exaltarlo, es
                                        válido
                                        pensar que se reiterarán a través del tiempo.</p>
                                    <p class="slide-author">Por: Nombre Autor</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class=" ml-md-3 text-left">
                                    <p class="slide-title">Sideral2</p>
                                    <p class="slide-content">Elijamos la palabra: mito, héroe, leyenda, crack,
                                        invencible….
                                        Todas
                                        son apropiadas para
                                        definir a Diego Maradona. Y si en estos días no se mezquinan para exaltarlo, es
                                        válido
                                        pensar que se reiterarán a través del tiempo.</p>
                                    <p class="slide-author">Por: Nombre Autor</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class=" ml-md-3 text-left">
                                    <p class="slide-title">Sideral3</p>
                                    <p class="slide-content">Elijamos la palabra: mito, héroe, leyenda, crack,
                                        invencible….
                                        Todas
                                        son apropiadas para
                                        definir a Diego Maradona. Y si en estos días no se mezquinan para exaltarlo, es
                                        válido
                                        pensar que se reiterarán a través del tiempo.</p>
                                    <p class="slide-author">Por: Nombre Autor</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<script>
const carousel1 = $('#carousel').carousel();
const carousel2 = $('#carousel2').carousel();
carousel1.on('slide.bs.carousel', function(event) {
    const to = $(event.relatedTarget).index();
    carousel2.carousel(to);
});
</script>