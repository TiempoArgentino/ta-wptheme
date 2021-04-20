import RBAutocompleteList from '../../components/RBAutocompleteList/RBAutocompleteList';
import TAArticleAuthorMetaBlock from '../../components/TAArticleAuthorMetaBlock/TAArticleAuthorMetaBlock';
import RBTermsSelector from '../../components/RBTermsSelector/RBTermsSelector';
import { fetchAuthors, useTAAuthors } from '../../helpers/useTAAuthors/useTAAuthors';
const { addQueryArgs } = wp.url;
const { Spinner } = wp.components;
const { apiFetch } = wp;

const TAAuthorsSelector = (props) => {
    const {
        terms,
        termsQueryField = 'include',
        onUpdate,
        onSubmit,
        onNewAuthor,
        max = 0,
        sortable = false,
        disabled = false,
    } = props;

    const {
        authors,
        setAuthors,
        loading,
    } = useTAAuthors({ terms, termsQueryField });

    const onChange = ({termsData, dataBeingFetched}) => {
        // setAuthors( items );
        if(onUpdate){
            onUpdate({
                authors: termsData,
                dataBeingFetched,
            });
        }
    }

    const renderAuthorItem = ({item, key, index, removeItem}) => {
        const { data: author, loading } = authors[index] ? authors[index] : {};
        return <TAArticleAuthorMetaBlock key = {key} author = {author} onRemove = { removeItem } loading = {loading}/>;
    };

    return (
        <RBTermsSelector
            taxonomy = "ta_article_author"
            terms = {terms}
            termsQueryField = {termsQueryField}
            onUpdate = {onChange}
            renderItem = { renderAuthorItem }
        />
    )
};

export default TAAuthorsSelector;
