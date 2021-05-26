<?php if(!$authors || empty($authors) ) return ?>

<?php for ($i=0; $i < count($authors); $i++): ?>
    <a href="<?php echo esc_attr($authors[$i]->archive_url); ?>"><?php echo esc_html($authors[$i]->name); ?></a>
    <?php if( isset($authors[$i + 1]) ): ?> y<?php endif; ?>
<?php endfor; ?>
