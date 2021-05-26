const { __ } = wp.i18n; // Import __() from wp.i18n
const { Component, Fragment, useState, useEffect } = wp.element;
const { Spinner } = wp.components;

import styles from "./style.css";
import RBListWithActions  from "../rb-list-with-actions/rb-list-with-actions.js";
import RBItemSelector from '../rb-item-selector/rb-item-selector.js';
import RBPaginator from '../rb-paginator/rb-paginator.js';
import RBModal from '../rb-modal/rb-modal.js';
//import noImageJPGUrl from './assets/no-image.jpg';
const noImageJPGUrl = '';

export default class RBSelectorFromFetch extends Component {
    static defaultProps = {
        /**
        *   @property {mixed[]} items
        *   Selected Items.
        */
        items: [],
        /**
        *   @property {function} onSelectionChange
        *   Function to call when the selection ends
        *   @required
        */
        onSelectionChange: null,
        /**
        *   @property {function} getItemData
        *   Function that returns neccesary data of an item to use in the lists
        *   @required
        */
        getItemData: null,
        /**
        *   @property {function} itemsFetch
        *   Function that returns the items to show in the selection list. It recieves
        *   filters data (pagination and other filters)
        *   @required
        *   @param {object} {data}
        *       @property {object} filters                      Filters data at the moment of fetch
        *           @property {int} page                            Page that was requested
        *   @returns {object}
        *       @property {mixed} item                  The items to show in the selectable items list
        *       @property {bool} loading                If the fetch is taking place
        *       @property {bool} error                  IF the fetch failed
        */
        itemsFetch: null,
        /**
        *   @property {int}  max
        *   Max amount of items to select
        */
        max: 0,
        /**
        *   @property {bool} pagination
        *   Whether to use a pagination filter
        */
        pagination: true,
        /**
        *   @property {int} initialPage
        *   The page to use the first time the pagination renders
        */
        initialPage: 1,
        /**
        *   Whether to use a search filter or not
        *   @property {bool} useSearch
        */
        useSearch: false,
        /**
        *   The initial search query
        *   @property {string} initialSearch
        */
        initialSearch: '',
        disabled: false,
        labels: {},
        modalLabels: {},
        itemsSelectorLabels: {},
        sortable: true,
        /**
        *   @param {jsx} filtersContent - Content for the custom filters.
        */
        filtersContent: null,
    }

    constructor(props){
        super(props);
        this.setLabels();
    }

    //Sets the labels
    setLabels(){
        this.labels = {
            noSelectedItems: 'No item has been selected',
            ...this.props.labels,
        };
    }

    // Calls onSelectionChange callback
    selectionChange(newSelection){
        this.props.onSelectionChange ? this.props.onSelectionChange(newSelection) : false;
    }

    // Removes an item from the selection and passes the new selection to selectionChange
    removeItem(itemToRemove){
        const itemData = this.props.getItemData(itemToRemove);
        const newSelection = this.props.items.filter((selectedItem) => {
            const selectedItemData = this.props.getItemData(selectedItem);
            return selectedItemData.id != itemData.id;
        });
        this.selectionChange(newSelection);
    }

    render(){
      return (
        <div className="rb-post-selector">
            {(!this.props.items || !this.props.items.length) &&
            <div class="no-selected">
                <p>{this.labels.noSelectedItems}</p>
            </div>
            }
            {this.props.items && this.props.items.length > 0 &&
            <RBListWithActions
                items={this.props.items}
                getItemData={(item) => this.props.getItemData(item)}
                actions={[{
                    icon: 'trash',
                    label: 'Remove Post',
                    callback: (item) => this.removeItem(item),
                }]}
                sortable={true}
                onSortEnd={({newList}) => this.selectionChange(newList)}
            />
            }
            <ItemsSelectionModal
                itemsFetch={this.props.itemsFetch}
                max={this.props.max}
                getItemData={this.props.getItemData}
                disabled={this.props.disabled}
                pagination={this.props.pagination}
                initialPage={this.props.initialPage}
                useSearch={this.props.useSearch}
                initialSearch={this.props.initialSearch}
                initialSelection={this.props.items}//initial selection
                onSubmit={(newSelection) => this.selectionChange(newSelection)}
                labels={this.props.modalLabels}
                itemsSelectorLabels={this.props.itemsSelectorLabels}
                filtersContent={this.props.filtersContent}
            />
        </div>
      );
  }
}

//Manages the state of the current selection in the modal
const ItemsSelectionModal = (props) => {
    const {
        /**
        *   @property {mixed[]} initialSelection
        *   Initial selection of items. It will be the first state of 'selected'
        *   when opening the modal
        */
        initialSelection = null, //initial selection
        /**
        *   @property {function} onSubmit
        *   Function to call when the modal is submited
        *   @param {mixed[]}    selected                            Array of select items
        */
        onSubmit = null,
        /**
        *   @property {object} labels
        *   Texts to show in the modal
        */
        labels = {},
        itemsSelectorLabels = {},
        //The rest of the props go straight to the items selector component
        ...itemsSelectorProps
    } = props;

    const {
        submitLabel = 'Accept',
        openerLabel = 'Select items',
        modalTitle = 'Items',
        ...propLabels
    } = labels;

    //Current selection state
    const [selected, setSelectedItems] = useState(null);

    //Runs onSubmit callback passing the current selection as parameter
    const submitSelection = () => {
        onSubmit ? onSubmit(selected) : false;
    };

    return (
        <RBModal
            openerLabel={openerLabel}
            submitLabel={submitLabel}
            title={modalTitle}
            submitDisabled={!selected || !selected.length}
            onSubmit={() => submitSelection()}
            onClose={() => setSelectedItems([])}
            onOpen={() => setSelectedItems(initialSelection)}
        >
            <ItemSelector
                {...itemsSelectorProps}
                selected={selected}
                labels={itemsSelectorLabels}
                onSelectionChange={(newSelection) => setSelectedItems(newSelection)}
            />
        </RBModal>
    );
}

//Manages the fetch of new items when the filters change
const ItemSelector = (props) => {
    const {
        /**
        *   @property {mixed[]} selected
        *   Current selection of items.
        */
        selected = null,
        /**
        *   @property {function} itemsFetch
        *   A function that must return a set of items, and fetch data, according to the
        *   filter state sent by parameter
        *   @param {object} data
        *       @property {object} filters                      Filters data at the moment of fetch
        *           @property {int} page                            Page that was requested
        */
        itemsFetch = null,
        /**
        *   @property {function} getItemData
        *   Function that returns neccesary item data to show in the list of items
        *   @param {mixed} item
        */
        getItemData = null,
        /**
        *   @property {function} onSelectionChange
        *   Function to run when the selection changes
        *   @required
        *   @param {mixed[]} selected                           Array of selected items
        */
        onSelectionChange = null,
        /**
        *   @property {bool} pagination
        *   Whether to use a pagination filter
        */
        pagination = true,
        /**
        *   @property {int} initialPage
        *   The page to use the first time the pagination renders
        */
        initialPage = 1,
        /**
        *   Whether to use a search filter or not
        *   @property {bool} useSearch
        */
        useSearch = false,
        /**
        *   The initial search query
        *   @property {string} initialSearch
        */
        initialSearch = '',
        /**
        *   @property {int} max
        *   The page to use the first time the pagination renders
        */
        max,
        /**
        *   @param {jsx} filtersContent - Content for the custom filters.
        */
        filtersContent = null,
        disabled = true,
        labels = {},
    } = props;

    const {
        noSelectableItemsLabel = 'There are no items to select from',
        selectedItemsLabel = 'Selected Items:',
        itemsFetchErrorMessage = 'An error ocurred while trying to retrieve neccesary data to render the control',
        loadingItemsLabel = 'Loading Items',
    } = labels;

    //Pagination State
    const [page, setPage] = useState(initialPage);
    //Pagination State
    const [searchQuery, setSearchQuery] = useState(initialSearch);
    //Filters State
    const [filters, setFilters] = useState({page, searchQuery});
    //Items fetch data
    let {items, totalPages, loading, error, errorMessage = itemsFetchErrorMessage, errorContent} = itemsFetch({filters});

    useEffect(() => {
        //Set the filter state when on of the filters has changed
        filtersChange();
    }, [page, searchQuery]);

    //Sets the 'filters' state based on each individual filter
    const filtersChange = () => {
        setFilters({page, searchQuery});
    };

    return (
        <Fragment>
            {!error &&
                <RBItemSelector
                    items={items}
                    selected={selected}
                    getItemData={(item) => getItemData(item)}
                    max={max}
                    onSelectionChange={({selected}) => onSelectionChange(selected)}
                    disabled={loading || disabled}
                    selectedLabel={selectedItemsLabel}
                    noItemsLabel={noSelectableItemsLabel}
                    topContent = { useSearch &&
                        <Fragment>
                            <div class="rb-search-filter">
                                <input
                                type="text"
                                class="search-input"
                                placeholder="Buscar..."
                                value={searchQuery}
                                onChange={(event) => setSearchQuery(event.target.value)}
                                />
                            </div>
                            {filtersContent}
                        </Fragment>
                    }
                    middleContent={pagination &&
                        <RBPaginator
                            page={page}
                            onPageChange={({page: pageTo}) => setPage(pageTo)}
                            totalPages={totalPages}
                            disabled={loading || disabled}
                        />
                    }
                />
            }
            {loading &&
                <div className="loading-box">
                    <p>{loadingItemsLabel}</p>
                    <Spinner/>
                </div>
            }
            {error &&
                <div class="error-notice">
                    {errorMessage &&
                    <p class="error-message">{errorMessage}</p>
                    }
                    {errorContent &&
                    <p class="error-content">{errorContent}</p>
                    }
                </div>
            }
        </Fragment>
    );
};
