const { __ } = wp.i18n; // Import __() from wp.i18n
//const { Component, Fragment } = wp.element;
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { InspectorControls } = wp.editor;
const { useRef, useState, useEffect, Fragment } = wp.element;
const { SelectControl, Spinner, PanelBody, Button, ToggleControl, TextControl, SandBox } = wp.components;
import TAContainer from '../../components/TAContainer/TAContainer';
import TAContainerControls from '../../components/TAContainerControls/TAContainerControls';
// import './css/editor.css';
// import './gallery';
import image from './mow step 2.gif';
const $ = require('jquery');

registerBlockType( 'ta/mow', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Playlist de Mow', 'ta-genosha' ), // Block title.
	icon: 'playlist-video', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'ta-blocks', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'Tiempo Argentino' ),
		__( 'Genosha' ),
		__( 'Contenedor' ),
		__( 'Sección' ),
	],
	getEditWrapperProps(attributes) {
		return {
			'data-align': attributes.use_container ? 'full' : '',
		};
	},
	// The "edit" property must be a valid function.
	edit: function( props ) {
        const { attributes, setAttributes, className, isSelected, getAttribute } = props;
        const { container = {}, mow_code, use_container } = attributes;
        const [isValidCode, setIsValidCode] = useState(false);
        const ContainerComp = use_container ? TAContainer : Fragment;

        useEffect( () => {
            try {
                const $mowScript = $(mow_code);
                if($mowScript && $mowScript.length){
                    const node = $mowScript[0];
                    const src = node.attributes.src ? node.attributes.src.nodeValue : '';
                    if(node.nodeName == 'SCRIPT' && src.includes('//mowplayer.com'))
                        setIsValidCode(src);
                    else
                        setIsValidCode(false);
                }
                else{
                    setIsValidCode(false);
                }
            } catch (error) {
                if(isValidCode)
                    setIsValidCode(false);
            }
        }, [mow_code])



        return (
			<>
				<ContainerComp
					attributes = {container}
                    setAttributes = { (attr) => setAttributes({ container: {...container, ...attr}}) }
				>
					<div className={`${className} ta-mow-block`}>
                        {mow_code && !isValidCode &&
                        <p>El código ingresado no es valido</p>
                        }
                        {mow_code && isValidCode &&
                            <SandBox
                                html={ mow_code }
                            />
                        }
                        {!mow_code &&
                        <div className="code-missing">
                            <p>¡Es necesario establecer un código de playlist!</p>
                            {isSelected &&
                            <>
                                <ol>
                                    <li>Diríjase a <a href="https://mowplayer.com/app/playlists/971432865335" target="_blank">https://mowplayer.com/app/playlists/971432865335</a></li>
                                    <li>Busque la playlist que quiera agregar</li>
                                    <li>Haga click en "Get Code" y copie el código en "SINGLE JS"</li>
                                    <li>Pegue el código en la configuración del bloque</li>
                                </ol>
                                <img src={image}/>
                            </>
                            }
                        </div>
                        }
					</div>
				</ContainerComp>
				<InspectorControls>
                    <TextControl
                        label = "Codigo de la playlist"
                        value = {mow_code}
                        onChange = { (mow_code) => setAttributes({mow_code})}
                    />
					<PanelBody
						title="Contenedor"
						icon="layout"
						initialOpen={false}
					>
						<ToggleControl
		                    label={"Usar contenedor"}
		                    checked={ use_container }
		                    onChange={(use_container) => setAttributes({use_container})}
		                />
						{ use_container &&
							<TAContainerControls
								attributes = { attributes.container }
								setAttributes = { ( newAttributes ) => {
									setAttributes({
										container: { ...attributes.container, ...newAttributes },
									});
								} }
								termControls = {false}
								isTermArticles = {false}
							/>
						}
					</PanelBody>
				</InspectorControls>
			</>
        );
	},
	// The "save" property must be specified and must be a valid function.
	save: function( { attributes } ) {
        return null;
	},
} );
