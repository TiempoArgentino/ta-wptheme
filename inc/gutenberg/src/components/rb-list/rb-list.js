const { Component } = wp.element;

import styles from "./style.css";

//A simple list of items that can be extended using the content filters provided through the props
export default class RBList extends Component{
    static defaultProps = {
        /**
        *   @property {mixed[]} items
        *   @required
        *   Array of items. There will be a row with action buttons for each one. The content of each item
        *   is not restricted to any format or type. The extra data for the item will be retrieved using the
        *   'getItemData' method provided through the props.
        */
        items: [],
        /**
        *   @property {function}    getItemData
        *   Function that returns an items data
        *   @required
        *   @param {mixed}          item                    Item from items array
        *   @returns {object}
        *       @property {string}    id                          Item identifier
        *       @property {mixed}     detail                      Content to show in the html element
        *       @property {string}    class                       Class to add to the item element
        */
        getItemData: null,
        /**
        *   @property {string} rowClassName
        *   Extra class to use in the list element
        */
        className: '',
        /**
        *   @property {function} filterItemContent
        *   A function that filters an item content to be shown in the list row.
        *   @param {object}   data                    Data
        *       @property {mixed}   item                            Item from wich the content comes from
        *       @property {object}    itemData                        Item data from 'getItemData'
        *       @property {jsx}     itemContentElement              The jsx for the item content element
        *       @property {int}     index                           Item index
        */
        filterItemContent: null,
        /**
        *   @property {function} filterRow
        *   A function to filter an item row.
        *   @param {object}   data                    Data
        *       @property {mixed}   item                            Row item
        *       @property {object}    itemData                        Item data from 'getItemData'
        *       @property {jsx}     rowElement                      The jsx for the row
        *       @property {int}     index                           Item index
        */
        filterRow: null,
        /**
        *   @property {function} filterList
        *   A function to filter the list element.
        *   @param {object}   data                    Data
        *       @property {jsx}     list                            The jsx for the list
        */
        filterList: null,
        /**
        *   @property {object} containerRef
        *   A ref that is associated with the list container
        */
        containerRef: null,
    }

    constructor(props){
        super(props);
    }

    /*
    *   Generates the item data using the 'getItemData' prop.
    *   If 'getItemData' is not provided, a simple object, that indicates that the
    *   item will be taken as the content to be shown in the row, will be return
    */
    getItemData(item){
        if(this.props.getItemData)
            return this.props.getItemData(item);
        return {
            detail: item,
        }
    }

    //Returns an item row
    getRow({item, index}){
        const itemData = this.getItemData(item);
        let itemContentElement = <div className="item-content">{itemData.detail}</div>;
        if(this.props.filterItemContent)
            itemContentElement = this.props.filterItemContent({item, itemData, itemContentElement, index});

        const rowClass = itemData.class ? itemData.class : '';
        let rowElement = <div className={`row item ${rowClass}`}>{itemContentElement}</div>;
        if(this.props.filterRow)
            rowElement = this.props.filterRow({item, itemData, rowElement, index});

        return rowElement;
    }

    //Returns all the rows for the list
    getRows(){
        return !this.props.items ? [] : this.props.items.map((item, index) => {
            return this.getRow({item, index});
        });
    }

    //Returns the comple list
    getList(){
        let list = <div class="rb-list">{this.getRows()}</div>;
        if(this.props.filterList)
            list = this.props.filterList({list});
        return list;
    }

    render(){
        const rows = this.getRows();

        return (
            <div className={`rb-list-container ${this.props.className}`} ref={this.props.containerRef}>
                 {this.getList()}
            </div>
        );
    }
}
