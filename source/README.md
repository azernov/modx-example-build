# Шаблон для сборки статической части проекта (html, js, img, css, fonts)

## Get started
1. Install [node.js](https://nodejs.org/),[python(2 version)](https://www.python.org/downloads/release/python-2710/),[Microsoft Visual Studio C++ 2013](https://support.microsoft.com/ru-ru/help/3179560/update-for-visual-c-2013-and-visual-c-redistributable-package) and gulp globally

		npm install gulp -g

2. Install npm packages.

		npm i

	If you use link of global packages:

		npm install gulp rimraf gulp-rimraf gulp-sass gulp-inline-image gulp-autoprefixer gulp-plumber gulp-concat gulp-sourcemaps gulp-postcss postcss-assets gulp-notify gulp-print gulp-rename gulp-replace gulp-uglify-es gulp-imagemin imagemin-pngquant gulp-csso -g

		npm link gulp rimraf gulp-rimraf gulp-sass gulp-inline-image gulp-autoprefixer gulp-plumber gulp-concat gulp-sourcemaps gulp-postcss postcss-assets gulp-notify gulp-print gulp-rename gulp-replace gulp-uglify-es gulp-imagemin imagemin-pngquant gulp-csso

## How to work with js

Create all your main scripts in `assets/js`. Create all your additional scripts (jquery,plugins, и т.д) in `/assets/js/all`. Gulp will concat all your additional scripts into `all.js`

## How to make iconfont

1. Install packages

		npm install gulp-iconfont@4.0.0 gulp-iconfont-css -D

2. Put your icons to `/assets/i/icons` folder
3. Change variable 'fontName' in gulpfile.js  ('iconfont' by default).
4. Uncomment iconfont task and run

		gulp iconfont

5. Pic your font in `/assets/fonts/icons` and font extends(%placeholders) in `/assets/sass/_icons.scss`

## How to make svg-sprite
1. Install packages

		npm install gulp-svg-sprite gulp-svgmin gulp-cheerio gulp-replace -g
        
		npm link gulp-svg-sprite gulp-svgmin gulp-cheerio gulp-replace
        
2. Put your icons into `/assets/i/icons` folder
3. Uncomment task `svgSpriteBuild`
4. Run task `svgSpriteBuild`
5. Now you have `sprite.svg` in `/assets/i/sprite` folder. By default you have `svg4everybody` script in your js. Also you have scss file `_sprite.scss` for styling sprite.
6. Add `svg4everybody` in your `main.js` file. For including icons use pug mixin "icon"

```
$(document).ready(function () {
	svg4everybody({});
});
```

## Working with images with PostCSS:

```
.test_block {
        width: width('rub.png');
        height:  height('rub.png');
        background: resolve('rub.png') no-repeat;
        background-size: size('rub.png');
}
```