const { Fragment } = wp.element;
const { Spinner, RangeControl, CheckboxControl, SelectControl, TextControl } = wp.components;

const TAContainerControls = (props = {}) => {
    const {
        attributes = {},
        setAttributes,
    } = props;

    const {
        color_context = 'common',
        header_type = 'common',
        title = '',
    } = attributes;

    return (
        <>
            <TextControl
                label="Título"
                value={ title }
                onChange={ ( title ) => setAttributes( { title } ) }
            />
            <SelectControl
                label="Paleta de colores"
                value={ color_context }
                options={ [
                    { label: 'Común', value: 'common' },
                    { label: 'Azul oscuro', value: 'darkblue' },
                ] }
                onChange={ ( color_context ) => { setAttributes( { color_context } ) } }
            />
            <SelectControl
                label="Tipo de header"
                value={ header_type }
                options={ [
                    { label: 'Común', value: 'common' },
                    { label: 'Especial', value: 'especial' },
                ] }
                onChange={ ( header_type ) => { setAttributes( { header_type } ) } }
            />
        </>
    );
};

export default TAContainerControls;
