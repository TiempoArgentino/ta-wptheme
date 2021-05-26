const { Component } = wp.element;

//import styles from "./style.css";
import RBSelectorFromFetch from '../../components/rb-selector-from-fetch/rb-selector-from-fetch.js';
import {useTermsFetch} from '../../helpers/rb-terms-fetch-hoc/rb-terms-fetch-hoc.js';

function termsFetchHook({
    filters,
    termsArgs = {},
    fetchArgs = {updateOnArgsChange: true},
}){
    let termsQueryArgs = {
        number: 10,
        page: filters.page,
    };

    if(filters.searchQuery)
        termsQueryArgs.search = filters.searchQuery;

    termsQueryArgs = {...termsQueryArgs, ...termsArgs};
    // termsQueryArgs = queryModifier ? queryModifier(termsQueryArgs) : termsQueryArgs;

    const {
        terms: items,
        status: {loading, error},
        totalPages,
    } = useTermsFetch({termsQueryArgs, fetchArgs});

    return { items, loading, error, totalPages };
}

export default class RBTermsSelector extends Component{
    static defaultProps = {
        /**
        *  Selected terms
        */
        terms: [],
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
        getItemData: (term) => {
            return {
                id: term.term_id,
                detail: term.name,
            };
        },
        disabled: false,
        pagination: true,
        initialPage: 1,
        labels: {},
        modalLabels: {},
        itemsSelectorLabels: {},
        termsArgs: {},
        sortable: true,
        useSearch: false,
    }

    constructor(props){
        super(props);
        this.setLabels();
    }

    setLabels(){
        this.labels = {
            noSelectedItems: 'No Term has been selected',
            ...this.props.labels
        };
        this.modalLabels = {
            submitLabel: 'Accept',
            openerLabel: 'Select Terms',
            modalTitle: 'Terms',
            ...this.props.modalLabels,
        };
        this.itemsSelectorLabels = {
            noSelectableItemsLabel: 'No term has been found',
            selectedItemsLabel: 'Selected Terms:',
            loadingItemsLabel: 'Loading Terms',
            ...this.props.itemsSelectorLabels
        };
    }

    selectionChange(newSelection){
        this.props.onSelectionChange ? this.props.onSelectionChange(newSelection) : false;
    }

    render(){
        return (
            <RBSelectorFromFetch
                items={this.props.terms}//initial selection
                onSelectionChange={(newSelection) => this.selectionChange(newSelection)}
                getItemData={(item) => this.props.getItemData(item)}
                itemsFetch={(data) => termsFetchHook({...data, termsArgs: this.props.termsArgs}) }
                max={this.props.max}
                labels={this.labels}
                modalLabels={this.modalLabels}
                itemsSelectorLabels={this.itemsSelectorLabels}
                disabled={this.props.disabled}
                pagination={this.props.pagination}
                initialPage={this.props.initialPage}
                sortable={this.props.sortable}
                useSearch = {this.props.useSearch}
            />
        )
    }
}
