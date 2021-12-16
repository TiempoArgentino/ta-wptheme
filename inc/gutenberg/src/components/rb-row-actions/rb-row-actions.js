const { Component } = wp.element;
const { IconButton } = wp.components;

import './style.css';

export default class RBRowActions extends Component{
    static defaultProps = {
        disableAll: false,
    }

    constructor(props){
        super(props);
    }

    renderActionButtons(){
        const buttons = this.props.actions.map((action, index) => {
            return (
                <IconButton isDefault
                    className={action.className ? action.className : ''}
                    disabled={this.props.disableAll || action.disabled}
                    icon={action.icon ? action.icon : ''}
                    label={action.label ? action.label : ''}
                    onClick={() => {action.callback(this.props.item)}}
                />
            )
        });

        return buttons;
    }

    render(){
        return(
            <div className={'rb-actions-row ' + this.props.className}>
                <div className="data">
                    {this.props.data}
                </div>
                <div className="actions">
                    {this.renderActionButtons()}
                </div>
            </div>
        )
    }
}
