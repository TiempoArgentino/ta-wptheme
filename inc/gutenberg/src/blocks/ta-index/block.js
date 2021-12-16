import './required-taxonomies';
import './etiquetador';
import './authors-selector';
import './article-alt-img-meta';
import './article-meta-nota-hermana';
import './article-meta-edicion-impresa';
import './media-popup-photographer';
import './commentary-author-selector';
import './article-meta-participation';

wp.domReady( () => {
	wp.blocks.unregisterBlockType( 'core/quote' );
    wp.blocks.unregisterBlockType( 'ta/container-with-header' );
} );

// import {hookComponentToNode} from './admin-components';

// setTimeout( () => {
//     // render(<TAAuthorsSelector/>, document.querySelector('.wp-admin.index-php #wpbody'));
//     render(<TAAuthorsSelector/>, document.getElementById('wpbody'));
// }, 2000)
