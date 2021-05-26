import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
const { InspectorControls, InnerBlocks, MediaUpload, MediaUploadCheck } = wp.editor;
const { PanelBody, Button } = wp.components;
const { __ } = wp.i18n;
const ALLOWED_MEDIA_TYPES = [ 'image' ];

const PluginDocumentSettingPanelDemo = () => {
    const instructions = <p>{ __( 'To edit the background image, you need permission to upload media.', 'image-selector-example' ) }</p>
    const onUpdateImage = ( image ) => {
        console.log(image);
        // setAttributes( {
        //     bgImageId: image.id,
        // } );
    };

    return (
        <PluginDocumentSettingPanel
            name="custom-panel"
            title="Custom Panel"
            className="custom-panel"
        >
            <MediaUploadCheck fallback={ instructions }>
                <MediaUpload
                    title={ __( 'Background image', 'image-selector-example' ) }
                    onSelect={ onUpdateImage }
                    allowedTypes={ ALLOWED_MEDIA_TYPES }
                    value={ null }
                    gallery = { true }
                    render={ ( { open } ) => (
                        <Button
                            className={ 'editor-post-featured-image__toggle' }
                            onClick={ open }>
                            { __( 'Set background image', 'image-selector-example' ) }
                        </Button>
                    ) }
                />
            </MediaUploadCheck>
        </PluginDocumentSettingPanel>
    );
};

registerPlugin( 'plugin-document-setting-panel-demo', {
    render: PluginDocumentSettingPanelDemo,
    icon: 'palmtree',
} );
