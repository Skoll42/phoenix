
Function.prototype.bind=Function.prototype.bind||function(b){if(typeof this!=="function"){throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");}var a=Array.prototype.slice,f=a.call(arguments,1),e=this,c=function(){},d=function(){return e.apply(this instanceof c?this:b||window,f.concat(a.call(arguments)));};c.prototype=this.prototype;d.prototype=new c();return d;};


function JobSdk(siteName, siteUrl) {
    this.domain = 'jobb.maritime.no';
    this.siteName = this._getSiteName(siteName);
    this.siteUrl = siteUrl;
    this.uniqueId = 1;
    this.callbacks = [];
    this._init();
}

JobSdk.prototype._getUniqueId = function() {
    return this.uniqueId++;
};

JobSdk.prototype._getSiteName = function(siteName) {
    switch (siteName) {
        case 'ilaks': return 'ilaks-no';
        case 'sysla': return 'sysla-no';
        case 'gronn': return 'syslagronn-no';
        case 'offshore': return 'offshore-no';
        case 'maritim': return 'maritime-no';
        default: return siteName;
    }
};

JobSdk.prototype._init = function() {
    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
    window[eventMethod](messageEvent, this._processEvent.bind(this), false);
};

JobSdk.prototype._processEvent = function(e) {
    if (e.origin.indexOf('jobb') != -1) {
        var args = e.data.args;
        switch (e.data.action) {
            case 'resize':
                var el = document.getElementById(args.iframeId);
                if (el) {
                    el.style.height = args.height + 'px';
                }
                break;

            case 'empty':
                var cb = this._getCallback(args.iframeId, 'empty');
                cb && cb();
                break;

            case 'showPosition':
                window.location.href = this.siteUrl + '?id=' + args.id;
                break;

            case 'filter':
                if (args.filter_name && args.filter_value) {
                    window.location.href = this.siteUrl + '?filter[' + args.filter_name + ']=' + args.filter_value;
                }
                break;

            case 'setTitle':
                document.title = args.title;
                break;

            default:
                console && console.log && console.log(e.data);
                break;
        }
    }
};

JobSdk.prototype.insertCarousel = function(selector, data) {
    var that = this;
    jQuery(selector).each(function(){
        var elem = jQuery(this);
        data = data || [];
        data['siteName'] = that.siteName;
        data['siteUrl'] = that.siteUrl;
        data['gridItems'] = elem.attr('data-grid-items') || 3;
        data['bgColor'] = elem.attr('data-bgcolor') || '';

        that._insertIframe(elem, 'carousel', data);
    });
};

JobSdk.prototype.insertWidget = function(selector, data) {
    var that = this;
    jQuery(selector).each(function(){
        var elem = jQuery(this);
        data = data || [];
        data['siteName'] = that.siteName;
        data['siteUrl'] = that.siteUrl;
        data['itemsHeight'] = elem.attr('data-items-height') || 300;
        data['bgColor'] = elem.attr('data-bgcolor') || '';
        data['titleFont'] = elem.attr('data-title-font') || '';

        that._insertIframe(elem, 'widget', data);
    });
};

JobSdk.prototype.insertListPage = function(selector, data) {
    var that = this;
    jQuery(selector).each(function(){
        var elem = jQuery(this);
        data = data || [];
        data['siteName'] = that.siteName;
        data['siteUrl'] = that.siteUrl;
        data['bgColor'] = elem.attr('data-bgcolor') || '';

        that._insertIframe(elem, 'page-list', data);
    });
};

JobSdk.prototype.insertDetailedPage = function(selector, data) {
    var that = this;
    jQuery(selector).each(function(){
        var elem = jQuery(this);
        data = data || [];
        data['siteName'] = that.siteName;
        data['siteUrl'] = that.siteUrl;
        data['bgColor'] = elem.attr('data-bgcolor') || '';

        that._insertIframe(elem, 'page-detailed', data);
    });
};

JobSdk.prototype._insertIframe = function(element, type, data) {
    data['iframeId'] = 'job_sdk_iframe_' + this._getUniqueId();
    var parts = [];
    for (var key in data) if (data.hasOwnProperty(key)) {
        var value = data[key];
        if (value) {
            if (typeof value == 'object') {
                for (var subkey in value) if (value.hasOwnProperty(subkey)) {
                    var subvalue = value[subkey];
                    parts[parts.length] = key + '[' + subkey + ']=' + encodeURIComponent(subvalue);
                }
            } else {
                parts[parts.length] = key + '=' + encodeURIComponent(value);
            }
        }
    }

    this._setCallback(data['iframeId'], 'empty', data['emptyCallback']);
    delete data['emptyCallback'];

    var url = 'http://' + this.domain + '/sdk/' + type + '/?' + parts.join('&');
    element.html('<iframe src="about:blank" id="' + data['iframeId'] + '" width="100%" height="0" frameborder="0"></iframe>');


    // Fix browser's cache for iframes when you hit back/forward buttons
    var iframe = jQuery('#' + data['iframeId']).get(0);
    if (iframe && iframe.contentWindow) {
        iframe.contentWindow.location.href = url;
    }
};


JobSdk.prototype._setCallback = function(uniqueId, callbackName, callback) {
    if (typeof callback == 'function') {
        if (typeof this.callbacks[uniqueId] == 'undefined') {
            this.callbacks[uniqueId] = [];
        }
        this.callbacks[uniqueId][callbackName] = callback;
    }
};

JobSdk.prototype._getCallback = function(uniqueId, callbackName) {
    return this.callbacks[uniqueId][callbackName];
};
