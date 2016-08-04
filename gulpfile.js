var gulp = require('gulp'),
  sass = require('gulp-sass'),
  autoprefixer = require('gulp-autoprefixer'),
  rename = require('gulp-rename'),
  cssnano = require('gulp-cssnano');

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
