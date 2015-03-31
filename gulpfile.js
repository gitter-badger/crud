var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    jshint = require('gulp-jshint'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename');


var paths = {
    "sass": "resources/sass/",
    "bower": "resources/bower/",
    "vendorJs": [
        "resources/bower/jquery/dist/jquery.js",
        "resources/bower/bootstrap-sass-official/assets/javascripts/bootstrap.js",
        "resources/bower/metisMenu/src/metisMenu.js",
        "resources/bower/raphael/raphael.js",
        "resources/bower/morrisjs/morris.js"
    ],
    "js": "resources/js/",
    "fonts": [
        "resources/bower/bootstrap-sass-official/assets/fonts/bootstrap/*.*",
        "resources/bower/font-awesome/fonts/*.*"
    ]
};

gulp.task('sass', function () {
    return sass([
        paths.sass + "style.scss"
    ], {sourcemap: true})
        .on('error', function (err) {
            console.error('Error!', err.message);
        })
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('public/styles'));
});

gulp.task('lint', function () {
    return gulp.src(paths.js + '*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

gulp.task('scripts', function () {
    var js = paths.vendorJs;
    js.push(paths.js + '*.js');

    return gulp.src(js)
        .on('error', function (err) {
            console.error('Error!', err.message);
        })
        .pipe(concat('main.js'))
        .pipe(gulp.dest('public/scripts'))
        .pipe(rename('main.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('public/scripts'));
});

gulp.task('fonts', function () {
    return gulp.src(paths.fonts)
        .on('error', function (err) {
            console.error('Error!', err.message);
        })
        .pipe(gulp.dest('public/fonts'));
});

gulp.task('watch', function () {

    gulp.watch(paths.sass + "**/*.scss", ['sass']);
    gulp.watch(paths.js + '*.js', ['lint', 'scripts']);

});

gulp.task('default', function () {
    // place code for your default task here
});