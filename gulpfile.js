var gulp = require('gulp'),
  sass = require('gulp-sass'),
  autoprefixer = require('gulp-autoprefixer'),
  rename = require('gulp-rename'),
  cssnano = require('gulp-cssnano'),
  scsslint = require('gulp-scss-lint'),
  jscs = require('gulp-jscs'),
  phpcs = require('gulp-phpcs'),
  phpcbf = require('gulp-phpcbf'),
  gutil = require('gulp-util'),
  copy = require('gulp-copy'),
  exec = require('child_process').exec
;

// Without this function exec() will not show any output
var logStdOutAndErr = function (err, stdout, stderr) {
  console.log(stdout + stderr);
};

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

gulp.task('scsslint', function () {
  return gulp.src('./app/Resources/assets/scss/**/*.scss')
    .pipe(scsslint());
});

gulp.task('jscs', function () {
  return gulp.src('./app/Resources/assets/js/**/*.js')
    .pipe(jscs({
      configPath: './vendor/sonata-project/core-bundle/Resources/public/vendor/bootstrap/js/.jscsrc'
    }))
    .pipe(jscs.reporter());
});

gulp.task('phpcs', function () {
  return gulp.src(['./src/AppBundle/**/*.php'])
    .pipe(phpcs({
      bin: './bin/phpcs',
      standard: 'PSR2',
      warningSeverity: 0
    }))
    .pipe(phpcs.reporter('log'));
});

gulp.task('phpcbf', function () {
  return gulp.src(['./src/AppBundle/**/*.php'])
    .pipe(phpcbf({
      bin: './bin/phpcbf',
      standard: 'PSR2',
      warningSeverity: 0
    }))
    .on('error', gutil.log)
    .pipe(gulp.dest('src/AppBundle'));
});

// Symfony & Mopa Stuff
gulp.task('fonts', function () {
  return gulp.src('./web/bundles/mopabootstrap/fonts/bootstrap/*')
    .pipe(copy('./web/fonts', {prefix: 7}));
});

gulp.task('installAssets', function () {
  exec('app/console assets:install', logStdOutAndErr);
});

gulp.task('installMopa', function () {
  exec('app/console mopa:bootstrap:symlink:sass', logStdOutAndErr);
});

gulp.task('clearCache', function () {
  exec('app/console cache:clear', logStdOutAndErr);
});

gulp.task('symfony', ['fonts', 'installAssets', 'installMopa', 'clearCache']);

gulp.task('dev', ['sass', 'watch']);
