/**
 * Configuration.
 *
 * You should only need to change these few values to get everything up and running
 */

// Project Name - Lowercase, no spaces, used below in urls (use name of theme folder)
// var project = "cncf-theme";

// Local project URL. From MAMP or whatever local server you use.
var projectURL = "https://cncfci.lndo.site";

// const PROJECT_FOLDER = "./web/wp-content/themes/" + project;
const PROJECT_FOLDER = ".";

/**
 * File and folder links
 *
 */
var styleSRC = PROJECT_FOLDER + "/source/scss/styles.scss";
var styleDestination = PROJECT_FOLDER + "/build/";

var jsGlobalSRC = PROJECT_FOLDER + "/source/js/global/*.js";
var jsGlobalDestination = PROJECT_FOLDER + "/build/";
var jsGlobalFile = "global";

var jsBlocksSRC = PROJECT_FOLDER + "/source/js/blocks/*.js";
var jsBlocksDestination = PROJECT_FOLDER + "/build/";
var jsBlocksFile = "blocks";

var styleWatchFiles = PROJECT_FOLDER + "/source/scss/**/*.scss";
var thirdpartyJSWatchFiles = PROJECT_FOLDER + "/source/js/third-party/**/*.js";
var blocksJSWatchFiles = PROJECT_FOLDER + "/source/js/blocks/**/*.js";
var globalJSWatchFiles = PROJECT_FOLDER + "/source/js/global/**/*.js";
var projectPHPWatchFiles = PROJECT_FOLDER + "/**/**/*.php";
var projectHTMLWatchFiles = PROJECT_FOLDER + "/**/**/*.html";

const AUTOPREFIXER_BROWSERS = [
	"last 2 version",
	"> 1%",
	"ie >= 11",
	"ie_mob >= 10",
	"ff >= 30",
	"chrome >= 34",
	"safari >= 7",
	"opera >= 23",
	"ios >= 7",
	"android >= 4",
	"bb >= 10"
];

/**
 * Load Plugins.
 *
 * Load gulp plugins and pass them semantic names.
 */
var gulp = require("gulp");

/** CSS plugins */
var sass = require("gulp-sass");
var minifycss = require("gulp-uglifycss");
var autoprefixer = require("gulp-autoprefixer");
var mmq = require("gulp-merge-media-queries");

/** JS plugins */
var concat = require("gulp-concat");
var uglify = require("gulp-uglify");

// var jslint = require('gulp-jslint'); // removed
var terser = require("gulp-terser");

/** Utility plugins */
var rename = require("gulp-rename");
var lineec = require("gulp-line-ending-corrector");
var filter = require("gulp-filter");
var sourcemaps = require("gulp-sourcemaps");
var del = require("del");
var touch = require("gulp-touch-cmd");

var browserSync = require("browser-sync").create();

function reload(done) {
	browserSync.reload();
	done();
}

/**
 * BrowserSync Task
 */
function watch() {
	gulp.watch(projectPHPWatchFiles, reload);
	gulp.watch(projectHTMLWatchFiles).on("change", reload);
	gulp.watch(styleWatchFiles, gulp.series([styles]));

	gulp.watch(thirdpartyJSWatchFiles, gulp.series([reload]));
	gulp.watch(blocksJSWatchFiles, gulp.series([blocksJS, reload]));
	gulp.watch(globalJSWatchFiles, gulp.series([globalJS, reload]));

	return browserSync.init({
		proxy: projectURL,
		open: true,
		notify: false
	});
}

/**
 * SASS to CSS tasks
 */
function styles() {
	return gulp
		.src(styleSRC)
		.pipe(sourcemaps.init())
		.pipe(
			sass({
				errLogToConsole: true,
				outputStyle: "expanded",
				precision: 10
			})
		)
		.on("error", console.error.bind(console))
		.pipe(
			sourcemaps.write({
				includeContent: false
			})
		)
		.pipe(
			sourcemaps.init({
				loadMaps: true
			})
		)
		.pipe(autoprefixer(AUTOPREFIXER_BROWSERS))
		.pipe(sourcemaps.write())
		.pipe(lineec())
		.pipe(gulp.dest(styleDestination))
		.pipe(filter("**/*.css"))
		.pipe(
			mmq({
				log: true
			})
		)
		.pipe(browserSync.stream())
		.pipe(
			rename({
				suffix: ".min"
			})
		)
		.pipe(
			sass({
				errLogToConsole: true,
				outputStyle: "compressed",
				precision: 10
			})
		)
		.pipe(
			minifycss({
				maxLineLen: 10
			})
		)
		.pipe(lineec())
		.pipe(gulp.dest(styleDestination))
		.pipe(filter("**/*.css"))
		.pipe(browserSync.stream())
		.pipe(touch());
}

/**
 * Clean build folder to help with cache
 */
function clean() {
	return del([styleDestination + "/*"]);
}

/**
 * Global JS files
 */
function globalJS() {
	return gulp
		.src(jsGlobalSRC)
		.pipe(concat(jsGlobalFile + ".js"))
		.pipe(lineec())
		.pipe(uglify()) // added
		.pipe(gulp.dest(jsGlobalDestination))
		.pipe(
			rename({
				basename: jsGlobalFile,
				suffix: ".min"
			})
		)
		.pipe(terser())
		.pipe(lineec())
		.pipe(gulp.dest(jsGlobalDestination))
		.pipe(touch());
}

/**
 * Blocks JS files
 */
function blocksJS() {
	return (
		gulp
			.src(jsBlocksSRC)
			.pipe(concat(jsBlocksFile + ".js"))
			.pipe(lineec())

			// .pipe(uglify()) // added
			.pipe(gulp.dest(jsBlocksDestination))
			.pipe(
				rename({
					basename: jsBlocksFile,
					suffix: ".min"
				})
			)
			.pipe(terser())
			.pipe(lineec())
			.pipe(gulp.dest(jsBlocksDestination))
			.pipe(touch())
	);
}

exports.default = gulp.series(styles, globalJS, blocksJS, watch);
exports.production = gulp.series(styles, globalJS, blocksJS);
exports.watch = gulp.series(watch);
