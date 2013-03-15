thumb
=====

Mini library for creating thumbs.

### 1. Getting started

The library allows you to resize images by setting either the _width_ or the _height_ of the resulting thumb. The other dimension will be determined authomatically to preserve the ratio.

```php
use \thumb\Thumb;

$img = new Thumb("image.jpg");

/** 
 * The following will create thumbsFolder/image.jpg
 * with a width of 300 and a proportional height.
 */
$img->create(300, "thumbsFolder");

/** 
 * The following will create thumbsFolder/thumbName.jpg
 * with a width of 300 and a proportional height.
 */
$img->create(300, "thumbsFolder", "thumbName.jpg", Thumb::WIDTH);

/** 
 * The following will create thumbsFolder/thumbName.jpg
 * with a height of 300 and a proportional width.
 */
$img->create(300, "thumbsFolder", "thumbName.jpg", Thumb::HEIGHT);
``` 

### 2. Image types

The lib only supports _jpg_, _gif_ and _png_ files.

### 3. Bugs and dubts

Any doubts just send me an email at ftestolin(at)gmail.com
