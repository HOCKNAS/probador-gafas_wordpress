try {
    var j = jQuery.noConflict();
    var front_uploaded_flag = false;
    var side_uploaded_flag = false;
    var global_view = "Front";
    var video_streaming = false;
    var tryOnImgUrl = '';
    var active_item_width = 0;
    var tryOnSideImgUrl = '';
    var productid = '';

    rotate = 0;

    function rotate_jewelfit(degree) {
        document.getElementById("galssimagediv").style.webkitTransform = "rotate(" + degree + "deg)";
    }

    function zoom_out(size) {
        var width = j("#" + "galssimagediv").width();
        if (active_item_width == 0) {
            active_item_width = width;
        }
        j("#" + "galssimagediv").width(parseInt(active_item_width) + parseInt(size) + "px");
    }

} catch (err) {
    console.log(err.message);
}