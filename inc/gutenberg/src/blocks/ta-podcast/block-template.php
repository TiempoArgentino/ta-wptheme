<?php

$block = RB_Gutenberg_Block::get_block('ta/podcast');
$container_header_block = RB_Gutenberg_Block::get_block('ta/container-with-header');

if(!$block) return '';
$block_attributes = $block->get_render_attributes();
extract($block_attributes);

$anchor_response = @file_get_contents('https://anchor.fm/s/22943604/podcast/rss');
if($anchor_response === false)
    return;
$rss_xml = simplexml_load_string($anchor_response, "SimpleXMLElement", LIBXML_NOCDATA);

if(!$rss_xml || !$rss_xml->channel->item || empty($rss_xml->channel->item))
    return;

$episodes_xml = $rss_xml->channel->item;
$latest_episode = ta_get_podcast_episode_data($episodes_xml[0]);
$amount_of_episodes = count($episodes_xml);
ob_start();
?>

<div class="podcasts-block d-flex flex-column flex-md-row overflow-hidden">
    <div class="col-12 col-md-6 podcast-preview first-podcast pb-3 px-0" data-episode="<?php echo esc_attr(json_encode($latest_episode)); ?>">
        <div class="video-container position-relative">
            <div class="video-wrapper">
                <img src="<?php echo esc_attr($latest_episode['image']); ?>" alt="" class="img-fluid w-100" />
            </div>
            <!-- <div class="play-btn">
                <img src="<?php //echo TA_THEME_URL; ?>/markup/assets/images/play.svg" alt="" class="position-absolute" />
            </div> -->
        </div>
        <div class="content mt-3">
            <div class="d-flex align-items-center">
                <div class="article-info-container mr-2">
                    <div class="format-icon">
                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/audiovisual-icon.svg" alt="" />
                    </div>
                </div>
                <div class="title">
                        <div class="pr-2">
                            <p class="episode-number"><?php echo esc_html($latest_episode['title']); ?></p>
                        </div>
                        <div>
                            <p class="nota-title"></p>
                        </div>
                </div>
            </div>
            <div class="podcast-player mt-3">
                <figure>
                    <audio class="audio" controls src="<?php echo esc_attr($latest_episode['audio']); ?>"></audio>
                </figure>
            </div>
            <div class="article-info-container mt-2">
                <div class="author">
                    <p>Tiempo Argentino</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 podcast-preview-container podcast-playlist">
        <?php
        for($i = 0; $i < $amount_of_episodes; $i++):
            $episode = ta_get_podcast_episode_data($episodes_xml[$i]);
            $class = $i == 0 ? 'current' : '';
        ?>
        <div class="podcast-preview d-flex mb-3 <?php echo esc_attr($class); ?>" data-episode="<?php echo esc_attr(json_encode($episode)); ?>">
            <div class="col-5 pl-0 img-container d-none d-md-block">
                <div class="img-wrapper" style="background-image: url('<?php echo esc_attr($episode['image']); ?>');"></div>
            </div>
            <div class="col-12 col-md-7 content mt-3">
                <div class="d-flex justify-content-between">
                    <div class="title">
                            <div>
                                <p class="episode-number"><?php echo esc_html($episode['title']); ?></p>
                            </div>
                            <div>
                                <p class="nota-title"></p>
                            </div>
                    </div>
                </div>
                <div class="article-info-container mt-2">
                    <div class="author">
                        <p>Tiempo Argentino</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</div>
<div class="btns-container">
    <div class="blue-bordered-btn d-flex justify-content-center mx-auto mt-3">
        <a href="https://open.spotify.com/show/6hz0YpFvI9I7LggZT7bkM4" target="_blank"><button>SEGUIR EN SPOTIFY</button></a>
    </div>
</div>


<?php
$content = ob_get_clean();

if( $use_container && $container ){
    $container_header_block->render($container, $content);
}
else
    echo $content;
