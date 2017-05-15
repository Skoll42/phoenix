var SPiD_Uri =
    /******/ (function(modules) { // webpackBootstrap
    /******/ 	// The module cache
    /******/ 	var installedModules = {};

    /******/ 	// The require function
    /******/ 	function __webpack_require__(moduleId) {

        /******/ 		// Check if module is in cache
        /******/ 		if(installedModules[moduleId])
        /******/ 			return installedModules[moduleId].exports;

        /******/ 		// Create a new module (and put it into the cache)
        /******/ 		var module = installedModules[moduleId] = {
            /******/ 			exports: {},
            /******/ 			id: moduleId,
            /******/ 			loaded: false
            /******/ 		};

        /******/ 		// Execute the module function
        /******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

        /******/ 		// Flag the module as loaded
        /******/ 		module.loaded = true;

        /******/ 		// Return the exports of the module
        /******/ 		return module.exports;
        /******/ 	}


    /******/ 	// expose the modules object (__webpack_modules__)
    /******/ 	__webpack_require__.m = modules;

    /******/ 	// expose the module cache
    /******/ 	__webpack_require__.c = installedModules;

    /******/ 	// __webpack_public_path__
    /******/ 	__webpack_require__.p = "";

    /******/ 	// Load entry module and return exports
    /******/ 	return __webpack_require__(0);
    /******/ })
/************************************************************************/
/******/ ([
    /* 0 */
    /***/ function(module, exports, __webpack_require__) {

        /*global require:false, module:false*/

        var config = __webpack_require__(1),
            util = __webpack_require__(2);

        function _encode(redirect_uri) {
            return encodeURIComponent(redirect_uri || window.location.toString());
        }

        function build(path, params) {
            return util.buildUri(config.server(), path, params);
        }

        function login(redirect_uri, client_id) {
            var options = config.options();
            var params = {
                'response_type': 'code',
                'client_id': client_id || options.client_id,
                'redirect_uri': _encode(redirect_uri)
            };
            return build('flow/login', params);
        }

        function auth(redirect_uri, client_id) {
            var options = config.options();
            var params = {
                'response_type': 'code',
                'client_id': client_id || options.client_id,
                'redirect_uri': _encode(redirect_uri)
            };
            return build('flow/auth', params);
        }

        function signup(redirect_uri, client_id) {
            var options = config.options();
            var params = {
                'response_type': 'code',
                'client_id': client_id || options.client_id,
                'redirect_uri': _encode(redirect_uri)
            };
            return build('flow/signup', params);
        }

        function logout(redirect_uri, client_id) {
            var options = config.options();
            var params = {
                'response_type': 'code',
                'client_id': client_id || options.client_id,
                'redirect_uri': _encode(redirect_uri)
            };
            return build('logout', params);
        }

        function account(redirect_uri, client_id) {
            var options = config.options();
            var params = {
                'response_type': 'code',
                'client_id': client_id || options.client_id,
                'redirect_uri': _encode(redirect_uri)
            };
            return build('account/summary', params);
        }

        function purchaseHistory(redirect_uri, client_id) {
            var options = config.options();
            var params = {
                'client_id': client_id || options.client_id,
                'redirect_uri': _encode(redirect_uri)
            };
            return build('account/purchasehistory', params);
        }

        function subscriptions(redirect_uri, client_id) {
            var options = config.options();
            var params = {
                'client_id': client_id || options.client_id,
                'redirect_uri': _encode(redirect_uri)
            };
            return build('account/subscriptions', params);
        }

        function products(redirect_uri, client_id) {
            var options = config.options();
            var params = {
                'client_id': client_id || options.client_id,
                'redirect_uri': _encode(redirect_uri)
            };
            return build('account/products', params);
        }

        function redeem(voucher_code, redirect_uri, client_id) {
            var options = config.options();
            var params = {
                'client_id': client_id || options.client_id,
                'redirect_uri': _encode(redirect_uri),
                'voucher_code': voucher_code || null
            };
            return build('account/redeem', params);
        }

        function purchaseProduct(product_id, redirect_uri, client_id) {
            var options = config.options();
            var params = {
                'response_type': 'code',
                'flow': 'payment',
                'client_id': client_id || options.client_id,
                'redirect_uri': _encode(redirect_uri),
                'product_id': product_id || null
            };
            return build('flow/checkout', params);
        }

        function purchaseCampaign(campaign_id, product_id, voucher_code, redirect_uri, client_id) {
            var options = config.options();
            var params = {
                'response_type': 'code',
                'flow': 'payment',
                'client_id': client_id || options.client_id,
                'redirect_uri': _encode(redirect_uri),
                'campaign_id': campaign_id || null,
                'product_id': product_id || null,
                'voucher_code': voucher_code || null
            };
            return build('flow/checkout', params);
        }

        module.exports = {
            init: function(opts) {
                config.init(opts);
            },
            build: build,
            login: login,
            auth: auth,
            signup: signup,
            logout: logout,
            account: account,
            purchaseHistory: purchaseHistory,
            subscriptions: subscriptions,
            products: products,
            redeem: redeem,
            purchaseProduct: purchaseProduct,
            purchaseCampaign: purchaseCampaign
        };


        /***/ },
    /* 1 */
    /***/ function(module, exports, __webpack_require__) {

        /*global module:false, require:false*/
        var
            _options = {},
            _defaults = {
                server: null,
                client_id: null,
                cache: false,
                logging: false,
                useSessionCluster: true,
                https: true,
                setVarnishCookie: null,
                storage: 'localstorage',
                timeout: 15000,
                refresh_timeout: 900000,
                varnish_expiration: null
            },
            util = __webpack_require__(2);

        module.exports = {
            options: function() {
                return _options;
            },
            init: function(opts) {
                _options = util.copy(opts, _defaults);
                if(!_options['server']) {
                    throw new TypeError('[SPiD] server parameter is required');
                }
                if(!_options['client_id']) {
                    throw new TypeError('[SPiD] client_id parameter is required');
                }

                //Set minimum refresh timeout
                if(_options.refresh_timeout <= 60000) {
                    _options.refresh_timeout = 60000;
                }
            },
            server: function() {
                return (_options.https ? 'https' : 'http') + '://' + _options.server + '/';
            }
        };

        /***/ },
    /* 2 */
    /***/ function(module, exports, __webpack_require__) {

        /*global require:false, module:false*/
        var log = __webpack_require__(3);
        function copy(target, source) {
            for(var key in source) {
                if(target[key] === undefined) {
                    target[key] = source[key];
                }
            }
            return target;
        }

        function now() {
            return (new Date()).getTime();
        }

        function buildUri(server, path, params) {
            var p = [];
            for(var key in params) {
                if(params[key]) {
                    p.push(key + '=' + params[key]);
                }
            }
            var url = server + (path || '') + '?' + p.join('&');
            log.info('SPiD.Util.buildUri() built {u}'.replace('{u}', url));
            return url;
        }

        function makeAsync(fn) {
            return function() {
                var args = arguments;
                setTimeout(function() {
                    fn.apply(null, args);
                }, 0);
            };
        }

        module.exports = {
            copy: copy,
            now: now,
            buildUri: buildUri,
            makeAsync: makeAsync
        };


        /***/ },
    /* 3 */
    /***/ function(module, exports, __webpack_require__) {

        /*global require:false, module:false*/

        function enabled() {
            var config = __webpack_require__(1);
            return !!window.console && (!!config.options().logging || window.location.toString().indexOf('spid_debug=1') !== -1);
        }

        function _log(message, level) {
            if(enabled()) {
                window.console[level]('[SPiD] ' + message);
            }
        }

        function info(message) {
            _log(message, 'info');
        }

        function error(message) {
            _log(message, 'error');
        }

        module.exports = {
            enabled: enabled,
            info: info,
            error: error
        };


        /***/ }
    /******/ ]);