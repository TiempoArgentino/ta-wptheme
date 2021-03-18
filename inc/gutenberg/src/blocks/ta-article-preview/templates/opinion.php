<?php

$author = $article->first_author;
$thumb_cont_class = $desktop_horizontal ? 'col-5 col-md-6 p-0' : 'col-5 col-md-12 p-0';
$info_class = $desktop_horizontal ? 'col-7 col-md-6' : 'col-7 col-md-12 text-md-center';
$title_class = $desktop_horizontal ? '' : 'w-75 mx-auto';
$preview_class = $desktop_horizontal ? 'd-flex py-3' : 'py-2 d-flex flex-row flex-md-column';
?>

<div class="article-preview autor light-blue-bg mb-3">
    <div class="<?php echo esc_attr($preview_class); ?>">
        <div class="<?php echo esc_attr($thumb_cont_class); ?>">
            <a href="">
                <div class="img-container position-relative">
                    <div class="img-wrapper" style='background-image: url("<?php echo $author->photo; ?>")' alt="<?php echo esc_attr($author->name); ?>"></div>
                </div>
            </a>
        </div>
        <div class="content <?php echo esc_attr($info_class); ?>">
            <div class="title">
                <a href="<?php echo esc_attr($url); ?>">
                    <p class="nota-title <?php echo esc_attr($title_class); ?>">“<?php echo $title; ?>”</p>
                </a>
            </div>
            <div class="article-info-container d-block">
                <div class="author">
                    <p>Por:
                    <?php
                        $authors = [$author];
                        include plugin_dir_path( __FILE__ ) . "/authors-links.php";
                    ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
