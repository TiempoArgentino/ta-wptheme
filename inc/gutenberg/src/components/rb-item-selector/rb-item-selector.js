const { Component } = wp.element;

import RBListWithActions  from "../rb-list-with-actions/rb-list-with-actions.js";
import styles from "./style.css";

export default class RBItemSelector extends Component{
    static defaultProps = {
        /**
        *   @property {mixed[]} items
        *   @required
        *   Array of items. Is not restricted to any format or type. The extra data for the item
        *   will be retrieved using the 'getItemData' method provided through the props.
        */
        items: [],
        /**
        *   @property {mixed[]} selected
        *   Array of selected items.
        */
        selected: [],
        /**
        *   @property {int} max
        *   Max amount of items to select. max = 0 means no limit of items
        */
        max: 1,
        /**
        *   @property {function} getItemData
        *   Function that returns and item data. See RBList component documentation for more info
        *   @required
        */
        getItemData: null,
        /**
        *   @property {function} onSelectionChange
        *   Function to be runned every time a change happens to the selected list
        *   @param {object} data                             Change data
        *       @param {mixed} item                             The affected item
        *       @param {mixed[]} selected                       The selected items array
        *       @param {mixed[]} items                          The items array
        *       @param {bool} wasSelected                       Wheter the item was added (true) or removed (false)
        */
        onSelectionChange: null,
        /**
        *   @property {bool} disabled
        *   Indicates if the selection functionality is disabled or not
        */
        disabled: false,
        /**
        *   Content to show in between the selection list and the selected items list
        */
        middleContent: null,
        /**
        *   Content to show on top of the selection list
        */
        topContent: null,
        selectedLabel: 'Selected Items',
        noItemsLabel: 'There is not a list of items to select from',
    }

    constructor(props){
        super(props);
    }

    /**
    *   Gets the 'add button' action data
    *   @param {bool} disabled                              If the button should be disabled or not
    *   @return {object}
    */
    getAddAction(disabled){
        return {
            disabled: disabled,
            icon: 'plus',
            label: 'Add',
            callback: (item) => this.onSelectionChange(item, true),
        };
    }

    /**
    *   Get complete data for and item in the selectable items list
    *   @param {mixed} item                                 Item to retrieve data from
    *   @return {object}
    */
    getSelectableItemData(item){
        let itemData = this.props.getItemData(item);
        const isSelected = this.isSelected(item);
        let selectedClass = isSelected ? 'selected' : '';
        itemData.class = itemData.class ? itemData.class : '';
        itemData.class = `${itemData.class} ${selectedClass}`;
        if(isSelected)
            itemData.actions = [this.getAddAction(true)];
        return itemData;
    }

    /**
    *   Get the data for an item in the selected items list
    *   @param {mixed} item                                 Item to retrieve data from
    *   @return {object}
    */
    getSelectedItemData(item){
        return this.props.getItemData(item);
    }

    /**
    *   Checks if an item is selected
    *   @param {mixed} item                                 Item to check
    *   @return {bool}
    */
    isSelected(item){
        const itemData = this.props.getItemData(item);
        return this.props.selected && (typeof this.props.selected.find((selectedItem) => {
            const selectedItemData = this.props.getItemData(selectedItem);
            return selectedItemData.id == itemData.id;
        }) != typeof undefined);
    }

    /**
    *   Modifies the items selection based on the change and runs 'onSelectionChange' prop
    *   @param {mixed} item                                 Item affected
    *   @param {bool} wasSelected                           Wheter the item was added (true) or removed (false)
    */
    //wasSelected indicates if the item was added (true) or removed(false) from the selected list
    onSelectionChange(item, wasSelected){
        const itemData = this.props.getItemData(item);
        let newSelected;
        if(wasSelected)
            newSelected = [...this.props.selected, item];
        else{
            newSelected = this.props.selected.filter(selectedItem => {
                const selectedItemData = this.props.getItemData(selectedItem);
                return selectedItemData.id != itemData.id;
            });
        }

        if(this.props.onSelectionChange){
            this.props.onSelectionChange({
                item,
                selected: newSelected,
                items: this.props.items,
                wasSelected,
            });
        }
    }

    hasItems(){ return this.props.items && this.props.items.length; }

    render(){
        // console.log(this.props.items, this.props.noItemsLabel, this.hasItems());
        const actionsDisabled = this.props.disabled || (this.props.max != 0 && (this.props.selected && this.props.selected.length >= this.props.max));
        return (
            <div class="rb-items-selector">
                {this.props.topContent ? this.props.topContent : ''}
                <div className="columns-container">
                    <div className="selector-column">
                        {!!this.hasItems() &&
                        <RBListWithActions
                            items={this.props.items}
                            getItemData={(item) => this.getSelectableItemData(item)}
                            actions={[this.getAddAction(actionsDisabled)]}
                            rowClassName={"item"}
                            listClassName={"items-selector-list"}
                        />
                        }
                        {!this.hasItems() &&
                        <div className="no-items-container">
                            <p>{this.props.noItemsLabel}</p>
                        </div>
                        }
                        {this.props.middleContent ? this.props.middleContent : ''}
                    </div>
                    <div className="selected-column">
                        <div className="selected-posts">
                            <h2 class="title" style={{marginTop: 0}}>{this.props.selectedLabel}</h2>
                            <RBListWithActions
                                items={this.props.selected}
                                getItemData={(item) => this.getSelectedItemData(item)}
                                actions={[{
                                    icon: 'minus',
                                    label: 'Remove',
                                    isDestructive: true,
                                    className: 'is-destructive',
                                    callback: (item) => {this.onSelectionChange(item, false)},
                                }]}
                            />
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}
