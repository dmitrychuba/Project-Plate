# Project Plate
#### Project skeleton

Requirements:  
 * npm
 * lando
 
##### Note: edit `.lando.yml`, and change "pp"(on line 1 nd 8) with your `[project name]`

---
##### Run all with one command
```bash
npm i && npm run dev && lando start && lando composer install
```


##### Done!
now your app is at: `http://[project name].lndo.site`

phpMyAdmin is at: `http://pma.[project name].lndo.site`

---

## Developer's Guide
Welcome! This guide contains instructions aimed to help you to write clean, consistent, and understandable code! Which is very important for product development

#### General rules/notes: 
 - Don't repeat your self (DRY code)
 - Create re-usable components, elements instead of huge files containing all components
 - Use functions/mixins described below
 - Use __EXPLICIT__ names (understandable, readable, self describing) for variables, classes, id, function, etc... Do not be lazy typing full names as possible instead of ugly abbriviations
 	* css: __ID__ - camelCase, __class__ - hyphenated-words
 	* php: __function__ - camelCase, __variable__ - underscore_separators
 - Write code as simple as possible, use common sense	
 	
#### Bootstrap

Project includes bootstrap v4, which can be customized by editing `resources/styles/components/bootstrap-custom.scss`

__Bootstrap rules/notes:__
 - Learn to use bootstrap!
 - Do not write own css if it's already in bootstrap's css
 - Use bootstrap's utilities 
 	- Learn to use Flex to position your elements! - [https://getbootstrap.com/docs/4.1/utilities/flex/]()
	- padding and margins: p- and m- [https://getbootstrap.com/docs/4.1/utilities/spacing/]()
	- display: d- [https://getbootstrap.com/docs/4.1/utilities/display/]()
- Use common sense

**Note:** you should not follow exactly PSD template's inconsistent padding but correct it and use consistent spacing of bootstrap across all pages 	
	 
 - [SCSS](#scss)
 	- [Font](#font)
	- [Custom Font](#custom-font)
 	- [Background](#background)
 	- [Absolute cover](#absolute-cover)
 	
 - [PHP](#php)
	- [Background Image](#background-image)
	- [Debug Functions](#debug-functions)
	- [Assets](#assets)
	- [Str slug/Str unslug](#str-slugstr-unslug)
	- [Get Array](#get-array)
	- [Truncate](#truncate)
	- [Template include functions](#template-include-functions)
	- [Shortcodes](#shortcodes)
 	- [Access to classes `WP_Posts.php`,  `WP_Theme.php`](#access-to-classes)
 		 
---	 
	
## SCSS

### _*Mixins:*_

### Font
```scss
@include f($params...);
```
  
used to define font-size, line-height, font-family, font-weight, color (passed as optional arguments in any order)

**Advantages:** converts units from `px` to `rem`, adds font-family fallbacks, reduces amount of lines in favor of readability 

**Examples:**

- Font-size 
	```scss
	@include f(16px);
	```

- Font-size and line-height (note the quotes) 
	```scss
	@include f("16px/25px");
	```

- Font-size, line-height, font-family, font-weight(text or number), color  
	```scss
	@include f("16px/25px", Futura, bold, #eee);
	or
	@include f("16px/25px", Futura, 800, rgba(#000, .3));
	```

### Custom Font 

To add Custom Fonts make sure that following files are present:

```
.resources/fonts/YOUR_FONT_NAME/YOUR_FONT_NAME.eot
.resources/fonts/YOUR_FONT_NAME/YOUR_FONT_NAME.ttf
.resources/fonts/YOUR_FONT_NAME/YOUR_FONT_NAME.woff
.resources/fonts/YOUR_FONT_NAME/YOUR_FONT_NAME.woff2
.resources/fonts/YOUR_FONT_NAME/YOUR_FONT_NAME.svg
```

Then add `YOUR_FONT_NAME` to `resources/styles/base/_typography.scss` to array `$fonts-list` after that you're able to use
it as follows: `@include f(YOUR_FONT_NAME);`
        

### Background

```scss
@include bg($params...);
```

used to define background-image[-color,-repeat,-size,-position,-attachment] (passed as optional arguments in any order)

**Advantages:** reduces amount of lines in favor of readability and reduces amount of text to type, no need to type full path to images directory as it uses project's default `assets/images/*`

**Examples:**

- background-size, background-image, background-repeat, background-position, background-color, background-attachment
	```scss
	@include bg(cover, 'my-image.png', no-repeat, 50% 50%, #ddd, fixed);
	```
	Note: in case you want to set background size as number(like: 20px 10px), you'll need to list it after background position

### Absolute cover
```scss
@include abs-cover;
```

used as a shortcut for:

```css
.selector {
	top      : 0;
	left     : 0;
	width    : 100%;
	height   : 100%;
	position : absolute;
}
```

**Advantages:** reduces amount of lines in favor of readability and reduces amount of text to type

---

## PHP:

### _*Helper functions:*_

### Background Image  
 
`get_bg_image( $image_src, $style_attribute = true )` - returns `style="background-image: url($image_src)"` or   `background-image: url($image_src);`

`bg_image($ image_src, $style_attribute = true )` - outputs same as above

Adds `background-image` css to style 

**Advantages:** reduces amount of text to type

**Examples:**

```php
<a class="logo" href="#" <?php bg_image( 'images/logo.png' ) ?>></a>
```
or
```php
<a class="logo" href="#" style="display: block;<?php bg_image( 'images/logo.png', false ) ?>"></a>
```

### Debug Functions

`dd( $var... )` - acts similarly to native `var_dump` but dies after outputting variables 

`vd( $var... )` - same as above but without `die;`

### Assets

`asset_url( $asset = null, $echo = false )` - returns url to asset 

`the_asset( $asset = null )` - returns url to asset

**Examples:**

```php
<img src="<?php the_asset( 'images/logo.png' ) ?>">
```

  
  
### Str slug/Str unslug

`str_slug( $slug, $separator = null )` - makes slug from title

`str_unslug( $title, $separator = null )` - makes title from slug

**Examples:**

```php
st_slug( 'My Title' ) // will return 'my-title'
str_unslug( 'my-title' ) // will return 'My Title'
```

### Get Array

`get_array( $var )` - makes sure you'll get an array 

Useful with ACF when you expect an array from repeater field, but when none is entered in admin ACF returns null which leads to warnings

**Examples:**

```php
get_array( null ) // Will return [] (empty array) 

get_array( get_field( 'hero_slides' ) ) // 
```

### Truncate
 
`truncate( $text, $chars = 25 )` - truncates text

### Template include functions
 
`layout( $name, $data = [], $return = false )` - includes files from `[layout]` folder 

`component( $name, $data = [], $return = false )` - includes files from `[component]` folder

`template( $name, $data = [], $return = false )` - includes files from `[page-templates]` folder

Parameters:

`$name` - template file name 

`$data` - associative array passed to template file

`$return` - whether to return or output the result
 
 Template files structure:
 ```
[page-templates]
	[components]
		copy.php
		pagination.php	
	[layout]
		_comments.php
		_footer.php
		_header.php
	[shortcodes]
		button.php
	_404.php
	_index.php
	_page.php
	_post.php
	home.php
```
 
**Examples:**
```php
layout( '_header' ); // will include page-templates/layout/_header.php
...
...
component( 'pagination', [ 'foo' => 'bar' ] ); 
// will include page-templates/components/pagination.php 
// passing variable $foo with 'bar' value
```
 
 
### Shortcodes
 
 In order to add shortcode just add a file to `[shortcodes]` folder it will be available as a shortcode by its name for example
 
 `button.php` - can be used as `[button]` shortcode

### Access to classes 
`WP_Posts.php`,  `WP_Theme.php`

`posts()`, `theme()`

**Examples:**

```php
posts()->latest(); 

menu()->menu( ... ); 
```