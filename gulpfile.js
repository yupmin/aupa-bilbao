var gulp = require('gulp'),
  sass = require('gulp-sass'),
  autoprefixer = require('gulp-autoprefixer'),
  rename = require('gulp-rename'),
  cssnano = require('gulp-cssnano');

gulp.task('jquery-copy', function() {
  return gulp.src('./node_modules/jquery/dist/jquery.js')
    .pipe(gulp.dest('./web/js/'));
});

gulp.task('sass', function () {
  return gulp.src('./app/Resources/assets/scss/app.scss')
    .pipe(sass({sourceComments: 'map'}))
    .pipe(autoprefixer())
    .pipe(gulp.dest('./web/css/'))
    .pipe(rename({suffix: '.min'}))
    .pipe(cssnano())
    .pipe(gulp.dest('./web/css/'));
});

gulp.task('watch', function () {
  gulp.watch('./app/Resources/assets/scss/**/*.scss', ['sass']);
});

gulp.task('default', ['sass', 'watch']);
