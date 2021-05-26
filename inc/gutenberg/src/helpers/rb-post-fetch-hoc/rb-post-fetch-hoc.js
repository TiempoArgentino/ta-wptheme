const { Component } = wp.element;

import RBFetchHOC, {useRbFetch} from '../rb-fetch-hoc/rb-fetch-hoc.js';

export function usePostsFetch(props){
    props = props ? props : {};
    const {
        postID = null,
        postType = 'posts',
        updatePostsOnArgsChange = true,
        postsQueryArgs = {},
        useRbEndpoint = true,
        ...fetchArgs
    } = props;

    const getRestPath = () => {
        if(useRbEndpoint){
            return `/rb/v1/posts`;
        }
        else{
            if(postID)
                return `/wp/v2/${postType}/${postID}?_embed`;
            else if(postType)
                return `/wp/v2/${postType}?_embed`;
        }
        return false;
    }

    const {response, responseData, status} = useRbFetch(getRestPath(), {
        ...fetchArgs,
        restPath: getRestPath(),
        method: useRbEndpoint ? 'POST' : 'GET',
        queryArgs: useRbEndpoint ? null : postsQueryArgs,
        data: useRbEndpoint ? {args: postsQueryArgs} : null,
    });

    return {
        posts: responseData,
        totalPages: response && response.headers ? parseInt(response.headers.get( 'X-WP-TotalPages' )) : 0,
        status,
        response,
    };
}

export default function RBPostsFetch(){
    return (WrappedComponent) => {
        return class extends Component{
            static defaultProps = {
                /**
                *   @property {int}             postID
                *   If specified, and 'useRbEndpoint' is false, the data retrieve from the fetch will be a json with the post data
                *   , instead of an array of posts data
                */
                postID: null,
                /**
                *   @property {string}          postType
                *   Post type to fetch. Necessary if 'useRbEndpoint' is false
                *   Tipo de posts a buscar. Necesario si 'useRbEndpoint' es falso.
                */
                postType: 'posts',
                /**
                *   @property {bool}            updatePostsOnArgsChange
                *   Whether the posts must be refetched after a change in postsFetchArgs
                *   If false, the fetch only runs onMount
                */
                updatePostsOnArgsChange: true,
                /**
                *   @property {array}           postsFetchArgs
                *   Arguments to use in the WP_Query. In addition to the core arguments, there are a few extra ones
                *
                *       @property {bool}    with_thumbnail              Whether the post thumbnail should be included (stored in thumbnail_url)
                *       @property {bool}    only_include                Only return posts if the 'posts__in' array is not empty, or
                *                                                       if posts where found that satisfy the condition
                */
                postsFetchArgs: {
                    per_page: 1,
                },
                /**
                *   @property {bool}            useRbEndpoint
                *   Whether to use the custom RB enpoint (rb/v1/posts) or the core wp rest api endpoint
                */
                useRbEndpoint: true,
            }

            constructor(props){
                super(props);

                this.initialState = {
                    posts: null,
                    needsUpdate: false,
                }

                this.state = this.initialState;
                this.RBFetch = RBFetchHOC('postsFetchData')(WrappedComponent);
            }

            checkNeedsUpdate(prevProps, prevState){
                return this.props.updatePostsOnArgsChange &&
                ((prevProps.postType !== this.props.postType) || (prevProps.postID !== this.props.postID) || this.restArgsChanged(prevProps));
            }

            restArgsChanged(prevProps){
                const newArgs = this.props.postsFetchArgs;
                const prevArgs = prevProps.postsFetchArgs;
                if(newArgs && !prevArgs || !newArgs && prevArgs)
                    return true;
                if(newArgs == prevArgs)
                    return false;

                return JSON.stringify(newArgs) != JSON.stringify(prevArgs);
            }

            getRestPath(){
                if(this.props.useRbEndpoint){
                    return `/rb/v1/posts`;
                }
                else{
                    if(this.props.postID)
                        return `/wp/v2/${this.props.postType}/${postID}?_embed`;
                    else if(this.props.postType)
                        return `/wp/v2/${this.props.postType}?_embed`;
                }
                return false;
            }

            getRestMethod(){ return this.props.useRbEndpoint ? 'POST' : 'GET'; }

            getRestData(){ return this.props.useRbEndpoint ? {args: this.props.postsFetchArgs} : null; }

            getQueryArg() { return this.props.useRbEndpoint ? null : this.props.postsFetchArgs; }

            onFetchSuccess(response, data){
                this.setState({
                    totalPages: response.headers ? parseInt(response.headers.get( 'X-WP-TotalPages' )) : 0,
                    posts: data,
                    needsUpdate: false,
                }, () => {
                    if(this.props.onFetchSuccess)
                        this.props.onFetchSuccess(response, data);
                });
            }

            fetchDataFilter(data){
                return {
                    ...data,
                    posts: this.state.posts,
                    totalPages: this.state.totalPages,
                };
            }

            render(){
                return(
                    <this.RBFetch
                        {...this.props}
                        queryArgs={this.getQueryArg()}
                        restPath={this.getRestPath()}
                        needsUpdateCheck={(prevProps, prevState) => this.checkNeedsUpdate(prevProps, prevState)}
                        onFetchSuccess={(response, data) => this.onFetchSuccess(response, data)}
                        fetchMethod={this.getRestMethod()}
                        requestData={this.getRestData()}
                        fetchDataFilter={(data) => this.fetchDataFilter(data)}
                    />
                );
            }
        }
    };
}
