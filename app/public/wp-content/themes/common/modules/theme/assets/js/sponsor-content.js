jQuery(document).ready(function($) {
    var firstThreshold = 650;
    var secondThreshold = 800;
    var sponsorHeight = 250;
    var nextExcludedClasses = ['article-content-factbox', 'article-content-map'];
    var contentBlock = $('.article-content .post-body');
    var children = contentBlock.children();
    var childrenHeight = 0;
    var candidates = [];

    var hasElementClass = function(elem, excludedClasses) {
        if (!elem.attr('class')) return false;
        var elementClasses = elem.attr('class').split(' ');
        for (var i = 0, len = elementClasses.length; i < len; i++) {
            if ($.inArray(elementClasses[i], excludedClasses)) {
                return true;
            }
        }
        return false;
    };

    children.each(function() {
        var current = $(this);
        if (current.is(':last-child')) return false;

        var float = current.css('float');
        if ($.inArray(float, ['left', 'right']) !== -1) return true;

        var next = current.next();
        if (hasElementClass(next, nextExcludedClasses)) return true;

        var height = current.outerHeight(true);
        childrenHeight += height;

        if (!candidates.length && childrenHeight >= firstThreshold) {
            candidates.push(current);
            return true;
        }

        if (childrenHeight >= (firstThreshold + secondThreshold + sponsorHeight)) {
            candidates.push(current);
            return false;
        }
    });

    if (candidates) {
        for (var i = 0, len = candidates.length; i < len; i++) {
            var elem = candidates[i];
            elem.after(
                '<div class="sponsor-block sponsor-block-' + (i == 0 ? 'e24' : 'internal') + '">' +
                    '<div class="sponsor-block-inner">Loading...</div>' +
                '</div>'
            );
        }
        $('body').trigger('sponsored.ready');
    }
});
