const { Fragment } = wp.element;
import TASeparator from '../TASeparator/TASeparator';
import './css/editor.css';

const TAContainer = (props = {}) => {
    const {
        attributes = {},
        setAttributes,
        children = '',
    } = props;

    const {
        color_context = 'common',
        header_type = 'common',
        title = '',
    } = attributes;

    const headerClass = header_type == 'special' ? 'special' : '';

    return (
        <div className="ta-container">
            <div className = { `container-header wp-block ${headerClass}` } >
                <TASeparator/>
                <div className="text">{title}</div>
            </div>
            <div className="container-content wp-block">
                {children}
            </div>
            <div className="container-footer wp-block">
                <TASeparator
                    alignment = "right"
                />
            </div>
        </div>
    );
};

export default TAContainer;
