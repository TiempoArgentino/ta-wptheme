const { __ } = wp.i18n; // Import __() from wp.i18n
//const { Component, Fragment } = wp.element;
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { InspectorControls } = wp.editor;
const { useRef, useState, useEffect, Fragment } = wp.element;
const { SelectControl, Spinner, PanelBody, Button, ToggleControl, TextControl, SandBox } = wp.components;
import TAContainer from '../../components/TAContainer/TAContainer';
import TAContainerControls from '../../components/TAContainerControls/TAContainerControls';
import useTAArticlesRowsContainer from '../../helpers/useTAArticlesRowsContainer/useTAArticlesRowsContainer';
// import './css/editor.css';
// import './gallery';

registerBlockType( 'ta/podcast', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Podcast Playlist', 'ta-genosha' ), // Block title.
	icon: 'playlist-audio', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
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
        const { container = {}, use_container } = attributes;
		const [ loadingPodcastData, setLoadingPodcastData ] = useState(false);
		const [ needsFetch, setNeedsFetch ] = useState(true);
		const [ error, setError ] = useState(null);
		const [ episodesData, setEpisodesData ] = useState([]);
        const ContainerComp = use_container ? TAContainer : Fragment;

		useEffect( () => {
			if(loadingPodcastData || !needsFetch)
				return;

			setLoadingPodcastData(true);
			setNeedsFetch(false);
			fetch('https://anchor.fm/s/22943604/podcast/rss')
				.then(response => response.text())
				.then( data => {
					const parser = new DOMParser();
					const xmlDoc = parser.parseFromString(data,"text/xml");
					const episodesXml = xmlDoc.getElementsByTagName("item");
					const episodesData = [];

					for (let i = 0; i < episodesXml.length; i++) {
						const episodeXml = episodesXml[i];
						const episodeData = {
							guid: episodeXml.getElementsByTagName('guid')[0].textContent,
							title: episodeXml.getElementsByTagName('title')[0].textContent,
							audio: episodeXml.getElementsByTagName('enclosure')[0].attributes.url.value,
							thumbnail_common: {
								url: episodeXml.getElementsByTagName('itunes:image')[0].attributes.href.value,
							},
						};
						episodesData.push(episodeData);
					}

					setEpisodesData(episodesData);
					setLoadingPodcastData(false);
				})
				.catch( (error) => {
					setLoadingPodcastData(false);
					setError(error);
				});
		}, [needsFetch]);

		const {
			renderRows,
			selectedRowData,
			getCellsCount,
		} = useTAArticlesRowsContainer({
			rows: [{
				format: 'miscelanea',
				cells: null,
				cells_amount: -1,
			}],
			showControls: false,
		})

        return (
			<>
				<ContainerComp
					attributes = {container}
                    setAttributes = { (attr) => setAttributes({ container: {...container, ...attr}}) }
				>
					{ loadingPodcastData && <><Spinner/> Cargando Podcast</> }
					{ !loadingPodcastData &&
					<>
						{error &&
						<>
							<h2>¡Ha ocurrido un error al tratar de recuperar la información del Podcast de tiempo!</h2>
							<p>No se a podido acceder a <a target="_blank" href="https://anchor.fm/s/22943604/podcast/rss">https://anchor.fm/s/22943604/podcast/rss</a></p>
							<Button isPrimary onClick = { () => setNeedsFetch(true) }>Volver a intentar</Button>
						</>
						}
						{!error && renderRows({articles: episodesData})}
					</>
					}
				</ContainerComp>
				<InspectorControls>
					<PanelBody
						title="Contenedor"
						icon="layout"
						initialOpen={false}
					>
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
								useColorContext = {false}
								useHeaderType = {false}
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
