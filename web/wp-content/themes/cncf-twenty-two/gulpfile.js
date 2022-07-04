/**
 * Gulp configuration.
 *
 * @package WordPress
 *
 * You should only need to change browsersync URL and project folder values to get running.
 */

// URL that will be used for hot reloading via Browser Sync.
// This should match with the prxoy setting in your.lando.yml file.
var BROWSERSYNC_URL = 'https://bs.cncfci.lndo.site';

// Project folder related to gulpfile position.
const PROJECT_FOLDER = '.';

/**
 * File and folder links
 */
var styleSrc         = PROJECT_FOLDER + '/source/scss/*.scss';
var styleDetachedSrc = PROJECT_FOLDER + '/source/scss/detached/*.scss';
var styleDestination = PROJECT_FOLDER + '/build/';

var jsGlobalSrc         = PROJECT_FOLDER + '/source/js/globals/*.js';
var jsGlobalDestination = PROJECT_FOLDER + '/build/';
var jsGlobalFile        = 'globals';

var jsEditorSrc         = PROJECT_FOLDER + '/source/js/editor/*.js';
var jsEditorDestination = PROJECT_FOLDER + '/build/';
var jsEditorFile        = 'editor-scripts';

var styleWatchFiles        = PROJECT_FOLDER + '/source/scss/**/*.scss';
var styleWatchDetachedStyles = PROJECT_FOLDER + '/source/scss/detached/*.scss';
var editorJSWatchFiles     = PROJECT_FOLDER + '/source/js/editor/**/*.js';
var globalJSWatchFiles     = PROJECT_FOLDER + '/source/js/globals/**/*.js';
var thirdpartyJSWatchFiles = PROJECT_FOLDER + '/source/js/on-demand/**/*.js';
var projectPHPWatchFiles   = PROJECT_FOLDER + '/**/**/*.php';
var projectHTMLWatchFiles  = PROJECT_FOLDER + '/**/**/*.html';

/**
 * Load Plugins.
 *
 * Load gulp plugins and pass them semantic names.
 */
const gulp = require( 'gulp' ),

	/** CSS plugins */
	sass         = require( 'gulp-sass' )( require( 'sass' ) ),
	mmq          = require( 'gulp-join-media-queries' ),
	cssnano      = require( 'cssnano' ),
	plumber      = require( 'gulp-plumber' ),
	autoprefixer = require( 'autoprefixer' ),
	postcss      = require( 'gulp-postcss' ),

	/** JS plugins */
	concat = require( 'gulp-concat' ),
	terser = require( 'gulp-terser' ),
	include = require( 'gulp-include' ),

	/** Utility plugins */
	lineec     = require( 'gulp-line-ending-corrector' ),
	sourcemaps = require( 'gulp-sourcemaps' ),
	touch      = require( 'gulp-touch-cmd' ),
	notify     = require( 'gulp-notify' ),
	rename     = require( 'gulp-rename' ),
	filter     = require( 'gulp-filter' ),

	browserSync = require( 'browser-sync' ).create();

/**
 * Error handler
 */
function errorHandler(err) {
	console.error( err.toString() );
}

/**
 * BrowserSync Reload.
 */
function reload( callback ) {
	browserSync.reload();
	callback();
}

/**
 * BrowserSync Task
 */
function watch() {
	gulp.watch( projectPHPWatchFiles,reload );
	gulp.watch( projectHTMLWatchFiles ).on( 'change',reload );
	gulp.watch( styleWatchFiles,gulp.series( [styles] ) );
	gulp.watch( styleWatchDetachedStyles,gulp.series( [detachedStyles] ) );
	gulp.watch( thirdpartyJSWatchFiles,gulp.series( [reload] ) );
	gulp.watch( editorJSWatchFiles,gulp.series( [editorJS,reload] ) );
	gulp.watch( globalJSWatchFiles,gulp.series( [globalJS,reload] ) );

	return browserSync.init(
		{
			proxy: 'http://appserver_nginx',
			socket: {
				domain: BROWSERSYNC_URL,
				port: 80 // NOT the 3000 you might expect.
			},
			open: false,
			logLevel: "debug",
			logConnections: true,
		}
	);
}

/**
 * SASS to CSS tasks
 */
function styles() {
	return gulp
		.src( styleSrc )
		.pipe( plumber( {errorHandler: notify.onError( 'Error: <%= error.message %>' )} ) )
		.pipe( sourcemaps.init() )
		.pipe(
			sass(
				{
					indentType: "tab",
					indentWidth: 1,
					errLogToConsole: true,
					outputStyle: 'expanded',
					precision: 10
				}
			)
		)
		.pipe(
			sourcemaps.write(
				{
					includeContent: false
				}
			)
		)
		.pipe(
			sourcemaps.init(
				{
					loadMaps: true
				}
			)
		)
		.pipe(
			postcss(
				[
				autoprefixer(
					{
						cascade: false
					}
				)
				]
			)
		)
		.pipe( sourcemaps.write() )
		.pipe( lineec() )
		.pipe( gulp.dest( styleDestination ) )
		.pipe( filter( '**/*.css' ) )
		.pipe(
			mmq(
				{
					log: false
				}
			)
		)
		.pipe( browserSync.stream() )
		.pipe(
			rename(
				{
					suffix: '.min'
				}
			)
		)
		.pipe(
			sass(
				{
					errLogToConsole: true,
					outputStyle: 'compressed',
					precision: 10
				}
			)
		)
		.pipe(
			postcss(
				[
				autoprefixer(
					{
						cascade: false
					}
				),
				cssnano
				]
			)
		)
		.pipe( lineec() )
		.pipe( plumber.stop() )
		.pipe( gulp.dest( styleDestination ) )
		.pipe( filter( '**/*.css' ) )
		.pipe( browserSync.stream() )
		.pipe( touch() );
}

/**
 * SASS to CSS tasks for detached style sheets
 */
function detachedStyles() {

	return gulp
	   .src( styleDetachedSrc )
	   .pipe( plumber( {errorHandler: notify.onError( 'Error: <%= error.message %>' )} ) )
	   .pipe( sourcemaps.init() )
	.pipe(
		sass(
			{
				errLogToConsole: true,
				outputStyle: 'expanded',
				precision: 10
			}
		)
	)
	.pipe(
		sourcemaps.write(
			{
				includeContent: false
			}
		)
	)
	.pipe(
		sourcemaps.init(
			{
				loadMaps: true
			}
		)
	)
	.pipe(
		postcss(
			[
				autoprefixer(
					{
						cascade: false
					}
				)
				]
		)
	)
	.pipe( sourcemaps.write() )
	.pipe( lineec() )
	.pipe( gulp.dest( styleDestination ) )
	.pipe( filter( '**/*.css' ) )
	.pipe(
		mmq(
			{
				log: false
			}
		)
	)
	.pipe( browserSync.stream() )
	.pipe(
		rename(
			{
				suffix: '.min'
			}
		)
	)
	.pipe(
		sass(
			{
				errLogToConsole: true,
				outputStyle: 'compressed',
				precision: 10
			}
		)
	)
	.pipe(
		postcss(
			[
				autoprefixer(
					{
						cascade: false
					}
				),
				cssnano
				]
		)
	)
.pipe( lineec() )
.pipe( plumber.stop() )
.pipe( gulp.dest( styleDestination ) )
.pipe( filter( '**/*.css' ) )
.pipe( browserSync.stream() )
.pipe( touch() );
}

/**
 * Global JS files
 */
function globalJS() {
	return gulp
		.src( jsGlobalSrc )
		.pipe(include())
		.on('error', console.log)
		.pipe( concat( jsGlobalFile + '.js' ) )
		.pipe( lineec() )
		.pipe( gulp.dest( jsGlobalDestination ) )
		.pipe(
			rename(
				{
					basename: jsGlobalFile,
					suffix: '.min'
				}
			)
		)
		.pipe( terser() )
		.pipe( lineec() )
		.pipe( gulp.dest( jsGlobalDestination ) )
		.pipe( touch() );
}

/**
 * Editor JS files
 */
function editorJS() {
	return (
		gulp
			.src( jsEditorSrc )
			.pipe( concat( jsEditorFile + '.js' ) )
			.pipe( lineec() )
			.pipe( gulp.dest( jsEditorDestination ) )
			.pipe(
				rename(
					{
						basename: jsEditorFile,
						suffix: '.min'
					}
				)
			)
			.pipe( terser() )
			.pipe( lineec() )
			.pipe( gulp.dest( jsEditorDestination ) )
			.pipe( touch() )
	);
}

exports.default    = gulp.series( styles,globalJS,editorJS,watch );
exports.watch      = gulp.series( styles,globalJS,editorJS,watch );
exports.detached   = gulp.series( styles,detachedStyles,globalJS,editorJS,watch );
exports.build      = gulp.series( styles,detachedStyles,globalJS,editorJS );
exports.production = gulp.series( styles,detachedStyles,globalJS,editorJS );
exports.prod       = gulp.series( styles,detachedStyles,globalJS,editorJS );
