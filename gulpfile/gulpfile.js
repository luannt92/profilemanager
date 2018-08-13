var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    rename = require('gulp-rename');
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var imagemin = require('gulp-imagemin'),
    cache = require('gulp-cache');
var minifycss = require('gulp-minify-css');

gulp.task('images', function(){
    gulp.src('img/*')
        .pipe(cache(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true })))
        .pipe(gulp.dest('dist/img/'));
});

gulp.task('styles', function(){
    gulp.src([
        'css/owl.carousel.css',
        'css/mmenu-all.css',
        'css/nivo-slider.css',
        'css/style.css',
        'css/media-style.css',
    ]).pipe(autoprefixer('last 2 versions'))
        .pipe(concat('main.css'))
        .pipe(gulp.dest('dist/css/'))
        .pipe(rename({suffix: '.min'}))
        .pipe(minifycss())
        .pipe(gulp.dest('dist/css/'))
});

gulp.task('scripts', function(){
    return gulp.src([
        'js/jquery.js',
        'js/bootstrap.min.js',
        'js/fontawesome-all.js',
        'js/mmenu.min.all.js',
        'js/marquee.js',
        'js/owl.carousel.js',
        'js/nivo.slider.js',
        'js/slimbox.js',
        // 'js/datepicker.jquery.js',
        'js/app.js'
    ])
        .pipe(plumber({
            errorHandler: function (error) {
                console.log(error.message);
                this.emit('end');
            }}))
        .pipe(concat('main.js'))
        .pipe(gulp.dest('dist/js/'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest('dist/js/'))
});

gulp.task('default', function(){
    gulp.watch("js/**/*.js", ['scripts']);
});