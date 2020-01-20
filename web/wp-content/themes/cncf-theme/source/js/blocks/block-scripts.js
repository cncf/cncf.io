/* global wp */
/*
|-----------------------------------------------
| Hides Taxonomy and Discussion
|-----------------------------------------------
*/
wp.data.dispatch(`core/edit-post`).removeEditorPanel(`taxonomy-panel-post_tag`); // tags
wp.data.dispatch(`core/edit-post`).removeEditorPanel(`discussion-panel`); // Discussion
/*
|-----------------------------------------------
| Max Width Styling
|-----------------------------------------------
*/
wp.blocks.registerBlockStyle(`core/paragraph`, {
	name: `max-800`,
	label: `Max Width 800px`
});
wp.blocks.registerBlockStyle(`core/paragraph`, {
	name: `max-900`,
	label: `Max Width 900px`
});
wp.blocks.registerBlockStyle(`core/heading`, {
	name: `max-800`,
	label: `Max Width 800px`
});
wp.blocks.registerBlockStyle(`core/heading`, {
	name: `max-900`,
	label: `Max Width 900px`
});
wp.blocks.registerBlockStyle(`core/heading`, {
	name: `uppercase-20px`,
	label: `Uppercase Small Text`
});
wp.blocks.registerBlockStyle(`core/group`, {
	name: `blue-gradient`,
	label: `Blue Gradient Background`
});
wp.blocks.registerBlockStyle(`core/group`, {
	name: `light-blue-gradient`,
	label: `Light Blue Gradient Background`
});
wp.blocks.registerBlockStyle(`core/separator`, {
	name: `width-50`,
	label: `50px width`
});
wp.blocks.registerBlockStyle(`core/columns`, {
	name: `centered-content`,
	label: `Centered Content`
});
