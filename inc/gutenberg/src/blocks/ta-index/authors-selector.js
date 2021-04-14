/**
*   Replaces the terms selector for the ta_article_author taxonomy in gutenberg editor
*/
import TAAuthorsSelector from '../../components/TAAuthorsSelector/TAAuthorsSelector';

let authorTaxonomy = wp.data.select('core').getTaxonomy( 'ta_article_author' );

const authorTaxonomySetUnsubscribe = wp.data.subscribe(() => {
    authorTaxonomy = wp.data.select('core').getTaxonomy( 'ta_article_author' );
    if( !authorTaxonomy )
        return;

    authorTaxonomySetUnsubscribe();
});

function authorsEditorControl( OriginalComponent ) {
    return function( props = {} ) {
        const {
            slug: taxonomy,
            taxonomy: taxonomyData,
            terms,
            onUpdateTerms,
        } = props;

        if ( taxonomy !== 'ta_article_author' )
            return <OriginalComponent {...props} />;

        const initialAuthors = wp.data.select( 'core/editor' ).getCurrentPostAttribute('ta_article_author');

        return (
            <TAAuthorsSelector
                authorsIds = { initialAuthors }
                onUpdate = { ({authors}) => {
                    wp.data.dispatch( 'core/editor' ).editPost( {
                        [ authorTaxonomy.rest_base ]: authors.map( author => author.term.term_id )
                    } );
                } }
            />
        );
    };
}
wp.hooks.addFilter( 'editor.PostTaxonomyType', 'ta-author', authorsEditorControl );
