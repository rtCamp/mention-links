/**
 * Main scripts, loaded on all pages.
 *
 * @package wp-mention-links
 */

/**
 * Post and User Autocompleter hooks.
 *
 * @see https://developer.wordpress.org/block-editor/components/autocomplete/
 */

const excludedBlocks = [];

const postCompleter = {
	name: 'posts-completer',
	triggerPrefix: '#',
	isDebounced: true,
	options: async ( search ) => {
		let queryString = '';
		if ( search ) {
			queryString = '?search=' + encodeURIComponent( search );
		}

		let returnArray = [];
		if ( 'undefined' !== typeof wpMentionsLinks.supportedCPTs ) {
			for ( let i in wpMentionsLinks.supportedCPTs ) {
				returnArray = returnArray.concat( await wp.apiFetch( { path: `/wp/v2/${wpMentionsLinks.supportedCPTs[i]}${queryString}` } ) );
			}
		} else {
			returnArray = returnArray.concat( await wp.apiFetch( { path: `/wp/v2/posts${queryString}` } ) );
			returnArray = returnArray.concat( await wp.apiFetch( { path: `/wp/v2/pages${queryString}` } ) );
		}

		return returnArray;
	},
	getOptionKeywords: ( post ) => post.title.rendered.split( /\s+/ ),
	getOptionLabel: ( post ) => [
		<span key={ post.id.toString() + '-icon' } className="dashicons dashicons-text-page" />,
		<span key={ post.id.toString() + '-name' }>&nbsp;{ ( 30 < post.title.rendered.length ? post.title.rendered.substring( 0, 30 ) + '...' : post.title.rendered ) }</span> // Add ellipsis.
	],
	getOptionCompletion: ( post ) => ( <a href={ post.link }>{ post.title.rendered }</a> )
};

/**
 * Hook to modify the existing user autocomplete for username hyperlink and attach post autocomplete.
 * @param {array}  completers Array of autocompleter objects.
 * @param {string} blockName  Name of the block.
 *
 * @return {array} Array of autocompleter objects.
 */
function filterAutcompleters( completers, blockName ) {

	// Check if the autocompleter is excluded for the block.
	if ( excludedBlocks.includes( blockName ) ) {
		return completers;
	}

	// Find the index of existing user autocompleter.
	const userCompleterIndex = completers.findIndex( ( completer ) => 'users' === completer.name );

	let field = 'name';
	if ( 'undefined' !== typeof wpMentionsLinks.selectedUserField && 'username' === wpMentionsLinks.selectedUserField ) {
		field = 'slug';
	}

	// Replace the render function of existing user autocompleter to add link.
	if ( completers[ userCompleterIndex ] ) {
		completers[ userCompleterIndex ].getOptionCompletion = ( response ) => ( <a href={ response.link }>{ ( response[ field ] ) }</a> );
	}

	// Attach post autocompleter.
	return [ ...completers, postCompleter ];
}

wp.hooks.addFilter( 'editor.Autocomplete.completers', 'mentions/autocompleters/posts-completer', filterAutcompleters );
