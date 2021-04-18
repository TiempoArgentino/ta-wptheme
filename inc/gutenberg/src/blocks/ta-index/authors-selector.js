/**
*   Replaces the terms selector for the ta_article_author taxonomy in gutenberg editor
*/
import TAAuthorsSelector from '../../components/TAAuthorsSelector/TAAuthorsSelector';
const { useSelect, useDispatch } = wp.data;

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

        const initialAuthors = useSelect(
            ( select ) => select( 'core/editor' ).getCurrentPostAttribute('ta_article_author'),
            []
        );
        const {editPost} = useDispatch( 'core/editor' );

        return (
            <TAAuthorsSelector
                authorsIds = { initialAuthors }
                sortable = { false }
                max = {0}
                onUpdate = { ({authors}) => {
                    editPost( {
                        [ authorTaxonomy.rest_base ]: authors.map( author => author.term.term_id )
                    } );
                } }
            />
        );
    };
}
wp.hooks.addFilter( 'editor.PostTaxonomyType', 'ta-author', authorsEditorControl );
