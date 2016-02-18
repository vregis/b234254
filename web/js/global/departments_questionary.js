/**
 * Created by toozzapc2 on 07.12.2015.
 */
function getBackgroundSize(elem) {
    // This:
    //       * Gets elem computed styles:
    //             - CSS background-size
    //             - element's width and height
    //       * Extracts background URL
    var computedStyle = getComputedStyle(elem),
        image = new Image(),
        src = computedStyle.backgroundImage.replace(/url\((['"])?(.*?)\1\)/gi, '$2'),
        cssSize = computedStyle.backgroundSize,
        elemW = parseInt(computedStyle.width.replace('px', ''), 10),
        elemH = parseInt(computedStyle.height.replace('px', ''), 10),
        elemDim = [elemW, elemH],
        computedDim = [],
        ratio;
    // Load the image with the extracted URL.
    // Should be in cache already.
    image.src = src;
    // Determine the 'ratio'
    ratio = image.width > image.height ? image.width / image.height : image.height / image.width;
    // Split background-size properties into array
    cssSize = cssSize.split(' ');
    // First property is width. It is always set to something.
    computedDim[0] = cssSize[0];
    // If height not set, set it to auto
    computedDim[1] = cssSize.length > 1 ? cssSize[1] : 'auto';
    if(cssSize[0] === 'cover') {
        // Width is greater than height
        if(elemDim[0] > elemDim[1]) {
            // Elem's ratio greater than or equal to img ratio
            if(elemDim[0] / elemDim[1] >= ratio) {
                computedDim[0] = elemDim[0];
                computedDim[1] = 'auto';
            } else {
                computedDim[0] = 'auto';
                computedDim[1] = elemDim[1];
            }
        } else {
            computedDim[0] = 'auto';
            computedDim[1] = elemDim[1];
        }
    } else if(cssSize[0] === 'contain') {
        // Width is less than height
        if(elemDim[0] < elemDim[1]) {
            computedDim[0] = elemDim[0];
            computedDim[1] = 'auto';
        } else {
            // elem's ratio is greater than or equal to img ratio
            if(elemDim[0] / elemDim[1] >= ratio) {
                computedDim[0] = 'auto';
                computedDim[1] = elemDim[1];
            } else {
                computedDim[1] = 'auto';
                computedDim[0] = elemDim[0];
            }
        }
    } else {
        // If not 'cover' or 'contain', loop through the values
        for(var i = cssSize.length; i--;) {
            // Check if values are in pixels or in percentage
            if (cssSize[i].indexOf('px') > -1) {
                // If in pixels, just remove the 'px' to get the value
                computedDim[i] = cssSize[i].replace('px', '');
            } else if (cssSize[i].indexOf('%') > -1) {
                // If percentage, get percentage of elem's dimension
                // and assign it to the computed dimension
                computedDim[i] = elemDim[i] * (cssSize[i].replace('%', '') / 100);
            }
        }
    }
    // If both values are set to auto, return image's
    // original width and height
    if(computedDim[0] === 'auto' && computedDim[1] === 'auto') {
        computedDim[0] = image.width;
        computedDim[1] = image.height;
    } else {
        // Depending on whether width or height is auto,
        // calculate the value in pixels of auto.
        // ratio in here is just getting proportions.
        ratio = computedDim[0] === 'auto' ? image.height / computedDim[1] : image.width / computedDim[0];
        computedDim[0] = computedDim[0] === 'auto' ? image.width / ratio : computedDim[0];
        computedDim[1] = computedDim[1] === 'auto' ? image.height / ratio : computedDim[1];
    }
    // Finally, return an object with the width and height of the
    // background image.
    return {
        width: computedDim[0],
        height: computedDim[1]
    };
}
var showScrollBar = false;
function getScrollBarWidth() {
    var inner = document.createElement('p');
    inner.style.width = "100%";
    inner.style.height = "200px";

    var outer = document.createElement('div');
    outer.style.position = "absolute";
    outer.style.top = "0px";
    outer.style.left = "0px";
    outer.style.visibility = "hidden";
    outer.style.width = "200px";
    outer.style.height = "150px";
    outer.style.overflow = "hidden";
    outer.appendChild(inner);

    document.body.appendChild(outer);
    var w1 = inner.offsetWidth;
    outer.style.overflow = 'scroll';
    var w2 = inner.offsetWidth;

    if (w1 == w2) {
        w2 = outer.clientWidth;
    }

    document.body.removeChild(outer);

    return (w1 - w2);
}

var currentImage = 1;

function clearName(wrapper) {
    var img_str = wrapper.css('background-image');
    img_str = img_str.replace('2.png', '.png');
    img_str = img_str.replace('3.png', '.png');
    wrapper.css('background-image', img_str);
}
function setName(wrapper, num) {
    var img_str = wrapper.css('background-image');
    img_str = img_str.replace('.png', '' + num + '.png');
    wrapper.css('background-image', img_str);
}

function updateData() {
    var wrapper = $('.page-content-wrapper');
    var dom_wrapper = wrapper.get(0);
    var background = getBackgroundSize(dom_wrapper);
    var scrollBarWidth = 0;
    if ($(document).height() > $(window).height() + 1) {
        scrollBarWidth = getScrollBarWidth();
    }
    var department = $('#department');
    var department_height = department.height() - $('.department-action-down').height() - 15;
    var new_height = background.height + department_height + scrollBarWidth;

    var page_content = $('.page-content');
    var page_content_height = parseInt(page_content.css('height'),10);

    var img_block = page_content_height - department_height - scrollBarWidth;
    var ratio = $(window).width() / img_block;
    if(ratio >= 2.2 && currentImage != 1) {
        clearName(wrapper);
        currentImage = 1;
        updateData();
        return;
    }
    else if(ratio >= 1.1 && ratio < 2.2 && currentImage != 2) {
        clearName(wrapper);
        currentImage = 2;
        setName(wrapper, 2);
        updateData();
        return;
    }
    else if(ratio < 1.1 && currentImage != 3) {
        clearName(wrapper);
        currentImage = 3;
        setName(wrapper, 3);
        updateData();
        return;
    }

    if(new_height > page_content_height) {
        page_content.css('min-height', '' + new_height + 'px');
    }

    var margin_min = 9999;
    var more_info = $('.more-info');
    $('.table-td-specialization').each(function(){
        var td_specialization_span = $(this).find('span');
        var width = td_specialization_span.width() + 10 + more_info.width();

        if($(this).width() > width ) {
            if(margin_min > $(this).width() - width) {
                margin_min = $(this).width() - width;
            }
        }
        else {
            margin_min = 0;
            return false;
        }
    });
    more_info.css('margin-right',margin_min);
}
// Execute onload, so that the background image is already loaded.
window.onload = window.onresize = updateData;
$(window).on('resize', _.debounce(function () {
    updateData();
}, 250));