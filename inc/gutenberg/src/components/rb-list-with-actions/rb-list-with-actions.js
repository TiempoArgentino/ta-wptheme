const { Component } = wp.element;

import RBList from "../rb-list/rb-list.js";
import RBSortableList from "../rb-sortable-list/rb-sortable-list.js";
import RBRowActions from "../rb-row-actions/rb-row-actions.js";
import styles from "./style.css";

//Generates a list of items with action buttons
export default class RBListWithActions extends Component{
    static defaultProps = {
        // Check RBList for this property documentation
        items: [],
        /** Check RBList for this property documentation. Some extra properties are taken in account
        *   @property {object[]}  actions                     See the 'items' prop
        *   @property {bool}    disabled                    Indicates if the item action buttons are to be disabled
        */
        getItemData: null,
        /**
        *   @property {object[]} items
        *   Set of action buttons to be used in each of the rows. It can be overriden by the 'actions' property
        *   of the 'getItemData' of each item
        */
        actions: [],
        /**
        *   @property {string} rowClassName
        *   Extra class to use in the item row element
        */
        rowClassName: '',
        /**
        *   @property {string} listClassName
        *   Extra class to use in the list element
        */
        listClassName: '',
        /**
        *   @property {bool} sortable
        *   Indicates if the list has to be sortable
        */
        sortable: false,
        /**
        *   @property {function} onSortEnd
        *   Function to be run when the sort ends. It is required if 'sortable' is set to true
        */
        onSortEnd: null,
    }

    constructor(props){
        super(props);
    }

    /**
    *   Returns the class to be used in an item row element
    *   @param {object} itemData                        Item from wich the data will be generated
    *   @return {string}
    */
    getRowClass(itemData){
        const disabledClass = itemData.disabled ? 'disabled' : '';
        const itemClass = itemData.class ? itemData.class : '';
        return `${this.props.rowClassName} ${disabledClass} ${itemClass}`;
    }

    /**
    *   Given an item, it returns the data to be used by the list component
    *   @param {mixed} item                             Item from wich the data will be generated
    *   @return {object}
    */
    getListItemData(item){
        const itemData = this.props.getItemData(item);
        const actions = itemData.actions ? itemData.actions : this.props.actions;

        return {
            id: itemData.id,
            class: this.getRowClass(itemData),
            detail: (
                <RBRowActions
                    className=""
                    key={itemData.id}
                    item={item}
                    data={itemData.detail}
                    actions={actions}
                    disableAll={itemData.disabled}
                />
            ),
        };
    }

    render(){
        const List = this.props.sortable ? RBSortableList : RBList;
        return (
            <div>
                <List
                    items={this.props.items}
                    className={"rb-list-with-actions " + this.props.listClassName}
                    onSortEnd={(data) => this.props.onSortEnd(data)}
                    getItemData={(item) => this.getListItemData(item)}
                />
            </div>
        );
    }
}
