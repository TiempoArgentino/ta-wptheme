const { __ } = wp.i18n; // Import __() from wp.i18n
const { Component, Fragment, createRef } = wp.element;
const { Dashicon } = wp.components;
import arrayMove from 'array-move';

import {SortableContainer, SortableElement, SortableHandle} from 'react-sortable-hoc';
import RBList from "../rb-list/rb-list.js";
import styles from "./style.css";

const Handle = SortableHandle(() => { return(
    <div className="item-handle">
        <div className="icon">
            <Dashicon icon="move" label="Move"/>
        </div>
    </div>
)});
//Sortable list of items
export default class RBSortableList extends Component{
    static defaultProps = {
        // Check RBList for this property documentation
        items: [],
        // Check RBList for this property documentation
        getItemData: null,
        /**
        *   @property {bool}    useDragHandle
        *   Indicates if there should be a handler from wich the items will be moved.
        *   If not, the whole item container will be draggable
        */
        useDragHandle: true,
        /**
        *   @property {function}    onSortEnd
        *   Function to be runned when sorting ends
        *       @param {object}           data                Information about the new items order
        *           @property {int}         oldIndex            Old index of the item that was moved
        *           @property {int}         newIndex            New index of the item that was moved
        *           @property {int}         newList             A new array with the items reordered
        */
        onSortEnd: null,
        // Check RBList for this property documentation
        className: '',
    }

    constructor(props){
        super(props);
        this.containerRef = createRef();
    }

    /**
    *   Runs the 'onSortEnd' prop, providing data on the new items order
    *   @param {int} oldIndex                               Old index of the item that was moved
    *   @param {int} newIndex                               New index of the item that was moved
    */
    onSortEnd({oldIndex, newIndex}){
        if(this.props.onSortEnd){
            this.props.onSortEnd({
                oldIndex,
                newIndex,
                newList: arrayMove(this.props.items, oldIndex, newIndex),
            })
        }
    }

    /**
    *   Function that transform the list into a sortable list
    *   @param {jsx} list                                   The list jsx
    */
    composeListWithSortableContainer({list}){
        const SortableList = SortableContainer(({items}) => {
            return list;
        });
        return <SortableList
            onSortEnd={(data) => this.onSortEnd(data)}
            helperContainer={this.containerRef.current}
            helperClass='helper-item'
            useDragHandle={this.props.useDragHandle}
        />;
    }

    /**
    *   Function that transforms an item row element into a sortable element
    *   @param {mixed} item                                 Item data
    *   @param {jsx} rowElement                             Item row element
    *   @param {int} index                                  Item index
    */
    composeRowWithSortableElement({item, rowElement, index}){
        const SortableItem = SortableElement(({value}) => {
            return rowElement;
        });
        return <SortableItem key={item.id} index={index}/>
    }

    /**
    *   Adds a sortable handle to the list item content element
    *   @param {mixed} item                                 Item data
    *   @param {jsx} itemContentElement                     Item element
    */
    addSortableHandle({item, itemContentElement}){
        return (
            <Fragment>
                {this.props.useDragHandle &&
                <Handle/>
                }
                {itemContentElement}
            </Fragment>
        )
    }

    render(){
        return (
            <RBList
                containerRef={this.containerRef}
                className={`rb-sortable-list-container ${this.props.className}`}
                items={this.props.items}
                getItemData={(item) => this.props.getItemData(item)}
                filterList={(args) => this.composeListWithSortableContainer(args)}
                filterRow={(args) => this.composeRowWithSortableElement(args)}
                filterItemContent={(args) => this.addSortableHandle(args)}
            />
        );
    }
}
