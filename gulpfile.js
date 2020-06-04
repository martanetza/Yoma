var gulp = require("gulp");
var minifyCSS = require("gulp-minify-css");
var minify = require("gulp-minify");

// task
gulp.task("compressCSS", function () {
  gulp
    .src("minify-css/*.css") // path to your file
    .pipe(minifyCSS())
    .pipe(gulp.dest("./minify-css"));
});

gulp.task("compressJS", function () {
  gulp
    .src("minify-js/*.js") // path to your file
    .pipe(minify())
    .pipe(gulp.dest("./minify-js"));
});

const imagemin = require("gulp-imagemin");

gulp.task("compressIMG", function () {
  gulp
    .src("minify-img/*") // path to your file
    .pipe(imagemin())
    .pipe(gulp.dest("./minify-img"));
});
