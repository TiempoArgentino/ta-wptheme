import {useFetchAndStore} from '../useFetchAndStore/useFetchAndStore';
const { apiFetch } = wp;

export function fetchRBPosts(args){
    const { postsQueryArgs } = args;
    let path = `/rb/v1/posts`;
    return apiFetch({
        method: 'POST',
        path,
        parse: false,
        data: {
            args: postsQueryArgs,
        },
    })
    .then((data) => {
        return data.json();
    });
};

export const useRBPosts = (props) => {
    const { posts, postQueryField = 'post__in', postsQueryArgs = {}, onChange } = props;

    const fetchPost = async ({ index, value: postFieldValue }) => {
        const fetchResult = await fetchRBPosts({
            postsQueryArgs: {
                ...postsQueryArgs,
                [postQueryField]: [postFieldValue],
            },
        });
        return fetchResult && fetchResult.length == 1 ? fetchResult[0] : null;
    }

    const {
        storedData: postsData,
        setStoredData: setPostsData,
        loading,
        error,
    } = useFetchAndStore({
        values: posts,
        fetchData: fetchPost,
        onChange,
    });

    return {
        postsData,
        setPostsData,
        loading,
        error,
    };
}
