const { Fragment } = wp.element;
const { TextControl } = wp.components;
import TASeparator from '../TASeparator/TASeparator';
import RBContentEditable from '../../components/rb-contenteditable/rb-contenteditable';
import './css/editor.css';

const TAContainer = (props = {}) => {
    const {
        attributes = {},
        setAttributes,
        children = '',
        titleEditable = true,
    } = props;

    const {
        color_context = 'common',
        header_type = 'common',
        title = '',
    } = attributes;

    const headerClass = header_type == 'special' ? 'special' : '';
    const className = `ta-container ta-context ${color_context}`;

    return (
        <div className={className}>
            <div className = { `container-header wp-block ${headerClass}` } >
                <TASeparator/>
                <RBContentEditable
                    content = {title}
                    onBlur = { (title) => setAttributes({title}) }
                    className="text"
                    disabled = { !titleEditable }
                />
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
