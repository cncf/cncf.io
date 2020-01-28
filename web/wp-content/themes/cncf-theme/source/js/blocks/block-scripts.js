/**
 * Blocks Scripts - for applying JS to editor
 *
 * Use this for styling editor blocks
 *
 * @since  1.0.0
 */

 // Hides tags
wp.data.dispatch( `core / edit - post` ).removeEditorPanel( `taxonomy - panel - post_tag` );

// Hides duscussion
wp.data.dispatch( `core / edit - post` ).removeEditorPanel( `discussion - panel` );

// Max width styling
wp.blocks.registerBlockStyle(
	`core / paragraph`,
	{
		name: `max - 800`,
		label: `Max Width 800px`,
	}
);
// Max width styling
wp.blocks.registerBlockStyle(
	`core / paragraph`,
	{
		name: `max - 900`,
		label: `Max Width 900px`,
	}
);
// Max width styling
wp.blocks.registerBlockStyle(
	`core / heading`,
	{
		name: `max - 800`,
		label: `Max Width 800px`,
	}
);
// Max width styling
wp.blocks.registerBlockStyle(
	`core / heading`,
	{
		name: `max - 900`,
		label: `Max Width 900px`,
	}
);
// Make heading text uppercase
wp.blocks.registerBlockStyle(
	`core / heading`,
	{
		name: `uppercase - 20px`,
		label: `Uppercase Small Text`,
	}
);
// Apply blue gradient background to group
wp.blocks.registerBlockStyle(
	`core / group`,
	{
		name: `blue - gradient`,
		label: `Blue Gradient Background`,
	}
);
// Apply light blue gradient background to group
wp.blocks.registerBlockStyle(
	`core / group`,
	{
		name: `light - blue - gradient`,
		label: `Light Blue Gradient Background`,
	}
);
// Make seperator 50px
wp.blocks.registerBlockStyle(
	`core / separator`,
	{
		name: `width - 50`,
		label: `50px width`,
	}
);
      // Make columns centered
wp.blocks.registerBlockStyle(
	`core / columns`,
	{
		name: `centered - content`,
		label: `Centered Content`,
	}
);
