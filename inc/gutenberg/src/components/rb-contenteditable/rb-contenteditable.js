const { useRef, useState } = wp.element;

export default function RBContentEditable(props = {}){
    const {
        disabled = false,
        content = '',
        placeholder = '',
        tagName = 'div',
        onInput = null,
        onBlur = null,
        sanitizePaste = true,
        className = '',
        ...childProps
    } = props;

    const [showPlaceholder, setShowPlaceholder] = useState(!content);
    const elementRef = useRef(null);
    const finalClassName = `${className} ${showPlaceholder ? 'placeholder' : ''}`;

    const pasteAsPlainText = event => {
        if(sanitizePaste){
            event.preventDefault();
            const text = event.clipboardData.getData('text/plain')
            document.execCommand('insertHTML', false, text);
        }
    }

    const handleContentEditableChange = event => {
        if(onInput)
            onInput(elementRef.current.textContent);
    };

    const handleBlur = event => {
        setShowPlaceholder(!elementRef.current.textContent);
        if(onBlur)
            onBlur(elementRef.current.textContent);
    };

    const handleFocus = event => {
        setShowPlaceholder(false);
    }

    return React.createElement( tagName, {
        ...childProps,
        className: finalClassName,
        onInput: handleContentEditableChange,
        onBlur: handleBlur,
        onFocus: handleFocus,
        onPaste: pasteAsPlainText,
        contentEditable: !disabled,
        ref: elementRef,
        //dangerouslySetInnerHTML: { __html: html }
    }, showPlaceholder ? placeholder : content );
}
