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
 "js": "resources/js/"
};

gulp.task('sass', function() {
    return sass([
        paths.sass + "style.scss"
    ],{ sourcemap: true })
    .on('error', function (err) {
      console.error('Error!', err.message);
    })
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('public/styles'));
});

gulp.task('lint', function() {
    return gulp.src(paths.js + '*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

gulp.task('scripts', function() {
    return gulp.src(paths.js + '*.js')
        .pipe(concat('main.js'))
        .pipe(gulp.dest('dist'))
        .pipe(rename('main.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('dist'));
});

gulp.task('watch', function() {

    gulp.watch(paths.sass + "**/*.scss",['sass']);
    gulp.watch(paths.js + '*.js', ['lint', 'scripts']);

});

gulp.task('default', function() {
  // place code for your default task here
});