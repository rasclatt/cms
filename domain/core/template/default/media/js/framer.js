
var iFrameSizer = function($)
{
    var self = this;
    /*
**	@description	This function will auto-resize a video container
**					height based on the observation of it's width
**	@param	watchElm	[jQuery Object]	This is the element to observe the width of (video)
**	@param	obj	[jQuery Object]	This is the container to act on
**	@param	aspectRatio	[numeric]	This is the aspect ratio of the video (default is 4x3)
*/
    self.autoSizeVideo = function(watchElm, obj, aspectRatio)
    {
        // Aspect ratio in decimal points of video
        aspectRatio = (!empty(aspectRatio)) ? aspectRatio : .75;
        // Get the width of the video
        var getVideoWidth = watchElm.width() - 10;
        // Get the aspect ratio
        var get4x3 = (getVideoWidth * aspectRatio);
        // Calculate the height from the width
        var getVideoHeight = get4x3;
        // Apply the height of the video to the container
        obj.css({
            "height": getVideoHeight + "px"
        });
    };
    /*
**	@description	This function will get the height of window and document,
**	then return a calculated height by reducing overall by browswer height
**	@param	docObj	[jQuery Object]	This is the document object
**	@param	winObj	[jQuery Object]	This is the window object
*/
    self.getViewSizes = function(docObj, winObj)
    {
        var dHeight = docObj.height();
        var wHeight = winObj.height();
        // Subtract window height from the document height
        var dHeight = dHeight - wHeight;
        // Send back the height of the window and the calc doc height
        var data = {
            "doc": dHeight,
            "win": wHeight
        };
        return data;
    };

    self.observer = function(wrapper, getVideo, iframeacton)
    {
        /*
**	@description	This will resize the video height based on width
*/
        $(window).on('load resize', function() {
            // Try to see if there are any ratio settings from the wrapper
            var getWrap = (is_object(wrapper)) ? wrapper : getVideo.parents(wrapper);
            // If there are good settings and videos
            if (!empty(getVideo) && !empty(getWrap)) {
                // Get the ratio if possible
                var getOptions = getWrap.data('instructions');
                // Set the ratio by setting or by default
                var getRatio = (isset(getOptions, 'ratio')) ? getOptions.ratio : [4, 3];
                // Adjust video size
                self.autoSizeVideo(getVideo, iframeacton, (getRatio[1] / getRatio[0]));
            }
        });
    };
};
$(function(){
    var VideoSizer = new iFrameSizer($);
    VideoSizer.observer('div.videoWrapper', $('.videoBorder'), $('.videoscope'));
});