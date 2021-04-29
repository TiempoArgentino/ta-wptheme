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

        const authorsIds = useSelect(
            ( select ) => select( 'core/editor' ).getEditedPostAttribute('ta_article_author'),
            []
        );
        const {editPost} = useDispatch( 'core/editor' );
        const getEntityRecords = useSelect( ( select ) => select( 'core' ).getEntityRecords, [] );

        return (
            <TAAuthorsSelector
                terms = { authorsIds }
                sortable = { false }
                max = {0}
                onUpdate = { ({authors, dataBeingFetched}) => {
                    if(dataBeingFetched)
                        return;
                    editPost( {
                        [ authorTaxonomy.rest_base ]: authors.filter( author => author.data && !author.loading ).map( author => author.data.id )
                    } );
                } }
                onSubmit = { async ({search}) => {
                    const terms = await getEntityRecords( 'taxonomy', 'ta_article_author', {
                        search: search,
                    });
                    console.log(search, terms);
                }}
            />
        );
    };
}
wp.hooks.addFilter( 'editor.PostTaxonomyType', 'ta-author', authorsEditorControl );
