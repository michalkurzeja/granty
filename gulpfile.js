'use strict';

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    clean = require('gulp-clean'),
    rename = require('gulp-rename'),
    sourcemaps = require('gulp-sourcemaps'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    merge = require('merge2');

gulp.task('compile-sass', function() {
    return gulp
        .src(['app/Resources/public/sass/main.scss'])
        .pipe(sourcemaps.init())
            .pipe(sass({outputStyle: 'compressed'}))
            .pipe(rename('bundled.min.css'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('web/assets/css'));
});

gulp.task('compile-js', function() {
    return merge(
            gulp.src([
                'bower_components/jquery/dist/jquery.min.js',
                'bower_components/what-input/what-input.min.js',
                'bower_components/foundation-sites/dist/foundation.min.js'
            ]),
            minifyJsInline(['app/Resources/public/js/main.js'])
        )
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(concat('bundled.min.js'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('web/assets/js'));
});

gulp.task('fonts', function () {
    return gulp
        .src(['bower_components/font-awesome/fonts/*'], { nodir: true })
        .pipe(gulp.dest('web/assets/fonts'));
});

gulp.task('clean', function () {
    return gulp
        .src(['web/assets'])
        .pipe(clean());
});

gulp.task('default', ['clean'], function () {
    var tasks = [
        'compile-sass',
        'compile-js',
        'fonts'
    ];

    tasks.forEach(function (task) {
        gulp.start(task);
    });
});

gulp.task('watch', function () {
    gulp.watch(['app/Resources/public/sass/*.scss', 'app/Resources/public/sass/components/*.scss'], ['compile-sass']);
    gulp.watch('app/Resources/public/js/main.js', ['compile-js']);
});

function minifyJsInline(src) {
    return gulp
        .src(src)
        .pipe(sourcemaps.init())
            .pipe(uglify())
        .pipe(sourcemaps.write());
}