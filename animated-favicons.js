var favicon_images = [
                    'http://website.com/img/tmp-0.gif',
                    'http://website.com/img/tmp-1.gif',
                    'http://website.com/img/tmp-2.gif',
                    'http://website.com/img/tmp-3.gif',
                    'http://website.com/img/tmp-4.gif',
                    'http://website.com/img/tmp-5.gif',
                    'http://website.com/img/tmp-6.gif'
                ],
    image_counter = 0; // To keep track of the current image

setInterval(function() {
    $("link[rel='icon']").remove();
    $("link[rel='shortcut icon']").remove();
    $("head").append('<link rel="icon" href="' + favicon_images[image_counter] + '" type="image/gif">');
    
	// If last image then goto first image
	// Else go to next image    
	if(image_counter == favicon_images.length -1)
        image_counter = 0;
    else
        image_counter++;
}, 200);