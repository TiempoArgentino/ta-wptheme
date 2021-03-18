const { Component, Fragment } = wp.element;
const { Spinner, Popover, IconButton, Button, Modal  } = wp.components;

import styles from "./style.css";

class Pagination extends Component{
    static defaultProps = {
        total: 1,
        current: 1,
        disabled: false,
    }

    constructor(props){
        super(props);
    }

    pageClick(page){
        if(!this.props.disabled && this.props.pageClick)
            this.props.pageClick(page);
    }

    render(){
        var pages = [];
        for(let page = 1; page <= this.props.total; page++){
            let dist = Math.abs( this.props.current - page);
            let espClass = dist == 0 ? "current" : "dist-" + dist;
            let style = {
                left: `calc(50% - ${this.props.current * 11}px)`,
            };

            pages.push(<div style={style} onClick={() => this.pageClick(page)} className={`pag ${espClass}`}><span>{page}</span></div>);
        }
        const className = this.props.disabled ? 'disabled' : '';
        return <div className={"pagination " + className}>{pages}</div>
    }
}

export default class RBPaginator extends Component{
    // Set default props
    static defaultProps = {
        page: 1,
        totalPages: 1,
        nextLabel: "Next Page",
        prevLabel: "Previous Page",
        disabled: false,
    }

    constructor(props){
        super(props);
    }

    componentDidUpdate(prevProps, prevState) {
        if(prevProps.totalPages != this.props.totalPages && this.props.page > this.props.totalPages){
            this.changePage(this.props.totalPages);
        }
    }

    onFirstPage(){ return this.props.page <= 1 }

    onLastPage(){ return this.props.page >= this.props.totalPages }

    previousPage(){
        if(this.onFirstPage())
            return false;
        this.changePage(this.props.page - 1);
    }

    nextPage(){
        if(this.onLastPage())
            return false;
        this.changePage(this.props.page + 1);
    }

    changePage(page){
        if( this.props.onPageChange )
            this.props.onPageChange({page});
    }

    render(){
        return(
            <div className="rb-paginator">
                <Button isDefault disabled={this.onFirstPage() || this.props.disabled} onClick={() => this.previousPage()}>{this.props.prevLabel}</Button>
                <Pagination total={this.props.totalPages} current={this.props.page} disabled={this.props.disabled} pageClick={(page) => this.changePage(page)}/>
                <Button isDefault disabled={this.onLastPage() || this.props.disabled} onClick={() => this.nextPage()}>{this.props.nextLabel}</Button>
            </div>
        );
    }

}
