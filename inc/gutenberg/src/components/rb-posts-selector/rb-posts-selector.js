const { Component } = wp.element;

//import styles from "./style.css";
import RBSelectorFromFetch from '../../components/rb-selector-from-fetch/rb-selector-from-fetch.js';
import {usePostsFetch} from '../../helpers/rb-post-fetch-hoc/rb-post-fetch-hoc.js';

function usePostsFetchMiddle(props){
    const {
        posts: items,
        status: {loading, error},
        totalPages,
    } = usePostsFetch(props);

    return {
        items, loading, error, totalPages
    };
}

function postsFetchHook({filters, postsArgs = {}}, {filtersModifier = null, queryModifier = null, fetchHook = usePostsFetchMiddle}){
    //Modifies the filters based on a function
    filters = filtersModifier ? filtersModifier(filters) : filters;

    let postsQueryArgs = {
        post_type: 'post',
        posts_per_page: 10,
        paged: filters.page,
    };

    if(filters.searchQuery)
        postsQueryArgs.s = filters.searchQuery;

    postsQueryArgs = {...postsQueryArgs, ...postsArgs};
    postsQueryArgs = queryModifier ? queryModifier(postsQueryArgs) : postsQueryArgs;

    const {
        items,
        loading,
        error,
        totalPages,
    } = fetchHook({
        postsQueryArgs,
        fetchArgs: {
            updateOnArgsChange: true,
        },
    });

    return { items, loading, error, totalPages };
}

export default class RBPostsSelector extends Component{
    static defaultProps = {
        /**
        *  Selected posts
        */
        posts: [],
        /**
        *  @property {int}  max
        *   Max amount of items to select
        */
        max: 0,
        /**
        *   Function to call when the selection ends
        *   @required
        */
        onSelectionChange: null,
        /**
        *   Function that returns neccesary data of an item to use in the lists
        *   @required
        */
        getItemData: (post) => {
            return {
                id: post.ID,
                detail: post.post_title,
            };
        },
        disabled: false,
        pagination: true,
        initialPage: 1,
        labels: {},
        modalLabels: {},
        itemsSelectorLabels: {},
        postsArgs: {},
        sortable: true,
        /**
        *   @param {function} filtersModifier - Function that takes the filters
        *   for the post fetch, and returns a modified version
        */
        filtersModifier: null,
        /**
        *   @param {function} filtersContent - Custom filters manager jsx
        */
        filtersContent: null,
        fetchHook: usePostsFetchMiddle,
    }

    constructor(props){
        super(props);
        this.setLabels();
    }

    setLabels(){
        this.labels = {
            noSelectedItems: 'No Post has been selected',
            ...this.props.labels
        };
        this.modalLabels = {
            submitLabel: 'Accept',
            openerLabel: 'Select Posts',
            modalTitle: 'Posts',
            ...this.props.modalLabels,
        };
        this.itemsSelectorLabels = {
            noSelectableItemsLabel: 'No post has been found',
            selectedItemsLabel: 'Selected Posts:',
            loadingItemsLabel: 'Loading Posts',
            ...this.props.itemsSelectorLabels
        };
    }

    selectionChange(newSelection){
        this.props.onSelectionChange ? this.props.onSelectionChange(newSelection) : false;
    }

    render(){
        return (
            <RBSelectorFromFetch
                items={this.props.posts}//initial selection
                onSelectionChange={(newSelection) => this.selectionChange(newSelection)}
                getItemData={(item) => this.props.getItemData(item)}
                itemsFetch={(data) => postsFetchHook({...data, postsArgs: this.props.postsArgs}, this.props) }
                max={this.props.max}
                labels={this.labels}
                modalLabels={this.modalLabels}
                itemsSelectorLabels={this.itemsSelectorLabels}
                disabled={this.props.disabled}
                sortable={this.props.sortable}
                pagination={this.props.pagination}
                initialPage={this.props.initialPage}
                filtersContent={this.props.filtersContent}
                useSearch={true}
            />
        )
    }
}
