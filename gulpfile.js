var gulp = require('gulp'),
	uglify = require('gulp-uglify'),
	concat = require('gulp-concat');

var paths = {
	'dev': {
		'js': './resources/assets/js/',
		'vendor': './resources/assets/vendor/'
	},
	'production': {
		'js': './public/assets/js/'
	}
};

gulp.task('default', ['js']);

gulp.task('js', function(){
	return gulp.src([
		paths.dev.vendor+'jquery/dist/jquery.js',
		paths.dev.js+'js'
	])
		.pipe(concat('app.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest(paths.production.js));
});

gulp.task('watch', function() {
	gulp.watch(paths.dev.js + '/*.js', ['js']);
});

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

//elixir(function(mix) {
//    mix.sass('app.scss');
//});

