const { Fragment } = wp.element;
const { Spinner, RangeControl, CheckboxControl, ToggleControl, SelectControl, TextControl } = wp.components;

const TAContainerControls = (props = {}) => {
    const {
        attributes = {},
        setAttributes,
        termControls = false,
        isTermArticles = false,
        useColorContext = true,
        useHeaderType = true,
    } = props;

    const {
        color_context = 'common',
        header_type = 'common',
        title = '',
        use_term_format = false,
        header_link = '',
    } = attributes;

    const usesTermFormat = isTermArticles && use_term_format;

    return (
        <>
            {(!termControls || !usesTermFormat) &&
            <>
                <TextControl
                    label="Título"
                    disabled = {usesTermFormat}
                    value={ title }
                    onChange={ ( title ) => setAttributes( { title } ) }
                />
                <TextControl
                    label="Link al clickear el título"
                    disabled = {usesTermFormat}
                    value={ header_link }
                    onChange={ ( header_link ) => setAttributes( { header_link } ) }
                />
                { useColorContext &&
                <SelectControl
                    label="Paleta de colores"
                    disabled = {usesTermFormat}
                    value={ color_context }
                    options={ [
                        { label: 'Común', value: 'common' },
                        { label: 'Azul oscuro', value: 'dark-blue' },
                        { label: 'Naranja (Deportes)', value: 'deportes' },
                        { label: 'Fucsia (Espectáculos)', value: 'espectaculos' },
                        { label: 'Cian (Cultura)', value: 'cultura' },
                    ] }
                    onChange={ ( color_context ) => { setAttributes( { color_context } ) } }
                />
                }
                { useHeaderType &&
                    <SelectControl
                        label="Tipo de header"
                        // disabled = {usesTermFormat}
                        value={ header_type }
                        options={ [
                            { label: 'Común', value: 'common' },
                            { label: 'Especial', value: 'especial' },
                        ] }
                        onChange={ ( header_type ) => { setAttributes( { header_type } ) } }
                    />
                }
            </>
            }

            {termControls &&
            <>
                <ToggleControl
                    label = "Aplicar colores, título, y link del termino filtrado"
                    className = { isTermArticles ? "" : "disabled" }
                    description = "truserserser"
                    disabled = {!isTermArticles}
                    style = {{
                        marginBottom: 0,
                    }}
                    checked = { use_term_format }
                    onChange = {  ( use_term_format ) => setAttributes( { use_term_format } ) }
                />
                { !isTermArticles &&
                    <span style = {{
                        fontSize: "12px",
                        marginBottom: "1rem",
                        display: "block",
                    }}>Esta opción se encuentra habilitada cuando se filtra por articulos mas recientes de solo un termino (un autor, o un solo tag, etc.)</span>
                }
            </>
            }
        </>
    );
};

export default TAContainerControls;
