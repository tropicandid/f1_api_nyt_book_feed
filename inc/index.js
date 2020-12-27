const {registerBlockType} = wp.blocks; //Blocks API
const {createElement} = wp.element; //React.createElement
const {__} = wp.i18n; //translation functions
const {InspectorControls} = wp.editor; //Block inspector wrapper
const {TextControl,SelectControl,ToggleControl,CheckboxControl} = wp.components; //Block inspector wrapper
const {ServerSideRender} = wp.components; //WordPress Server-Side Renderer

registerBlockType( 'f1-api-feed-blocks/f1-api-feed', {
	title: __( 'F1 API Feed' ), 
	description: __( 'Most recent 4 books from feed' ),
	category: 'common',
	icon: 'align-center',

	edit(props){
		const attributes =  props.attributes;
		const setAttributes =  props.setAttributes;

		//Display block preview and UI
		return createElement('div', {}, [
			createElement( ServerSideRender, {
				block: 'f1-api-feed-blocks/f1-api-feed'
			} )
		] )
	},
	example: () => {}, //Add this to get block preview works
	save(){
		return null;
	}
});
