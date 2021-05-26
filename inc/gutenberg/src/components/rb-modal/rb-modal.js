//Fragment: A component which renders its children without any wrapping element.
const { __ } = wp.i18n; // Import __() from wp.i18n
const { Component, Fragment } = wp.element;
const { Button, Modal  } = wp.components;

export default class RBModal extends Component{
    static defaultProps = {
        openerLabel: 'Open Modal',
        submitLabel: 'Acept',
        title: 'Modal',
        onClose: null,
        onOpen: null,
        onSubmit: null,
        submitDisabled: true,
    }

    constructor(props){
        super(props);

        this.initialState = {
            isOpen: false,
        }
        this.state = this.initialState;
        //this.loadInitialPost();
    }

    close(callback){
        this.setState( { isOpen: false }, () => {
            if(callback)
                callback();
            if(this.props.onClose)
                this.props.onClose();
        });
    }

    open(){
        this.setState( { isOpen: true }, () => {
            if(this.props.onOpen)
                this.props.onOpen();
        });
    }

    submit(){
        this.close(() => {
            if(this.props.onSubmit)
                this.props.onSubmit();
        });
    }

    render(){
        return(
            <Fragment>
                <Button className="modal-opener" isPrimary onClick={ () => this.open() }>{this.props.openerLabel}</Button>
                {this.state.isOpen &&
                <Modal
                    title={this.props.title}
                    onRequestClose={ () => this.close() }
                >
                    <div class="modal-content">
                    {this.props.children}
                    </div>
                    <div className="end-buttons">
                        <Button isPrimary
                        disabled={this.props.submitDisabled}
                        onClick={ () => this.submit() }>
                            {this.props.submitLabel}
                        </Button>
                    </div>
                </Modal>
                }
            </Fragment>
        );
    }
}
