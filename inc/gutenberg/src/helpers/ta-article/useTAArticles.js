import {useFetchAndStore} from '../useFetchAndStore/useFetchAndStore';
const { apiFetch } = wp;

export function fetchTAArticles(args){
    const { postsQueryArgs } = args;
    let path = '/ta/v1/articles';
    return apiFetch({
        method: 'POST',
        path,
        parse: false,
        data: {
            args: {
                post_type: 'ta_article',
                ...postsQueryArgs,
            },
        },
    })
    .then((data) => {
        return data.json();
    });
};

export const useTAArticles = (props) => {
    const { posts, postQueryField = 'post__in', postsQueryArgs = {}, onChange } = props;

    const fetchPost = async ({ index, value: postFieldValue }) => {
        const fetchResult = await fetchTAArticles({
            postsQueryArgs: {
                ...postsQueryArgs,
                [postQueryField]: [postFieldValue],
            },
        });
        return fetchResult && fetchResult.length == 1 ? fetchResult[0] : null;
    }

    const {
        storedData: articlesData,
        setStoredData: setArticlesData,
        loading,
        error,
    } = useFetchAndStore({
        values: posts,
        fetchData: fetchPost,
        onChange,
    });

    return {
        articlesData,
        setArticlesData,
        loading,
        error,
    };
}
