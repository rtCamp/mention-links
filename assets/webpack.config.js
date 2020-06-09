// sets mode webpack runs under
const path = require( 'path' );

// JS Directory path.
const JSDir = path.resolve( __dirname, 'src/js' );
const BUILD_DIR = path.resolve( __dirname, 'build' );

const output = {
	path: BUILD_DIR,
	filename: 'js/[name].min.js'
};

const entry = {
	main: JSDir + '/main.js',
};

module.exports = {
	entry: entry,
	output: output,
	module: {
		rules: [
			{
				test: /.js$/,
				exclude: /node_modules/,
				loader: 'babel-loader',
			},
		],
	},
};
