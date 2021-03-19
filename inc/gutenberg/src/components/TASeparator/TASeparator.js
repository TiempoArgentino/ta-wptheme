import './css/editor.css';

const TASeparator = (props = {}) => {
    const {
        alignment = "left",
    } = props;

    return (
        <div className = { `ta-separator ${alignment}` }>
            <div className="separator"></div>
        </div>
    );
};

export default TASeparator;
