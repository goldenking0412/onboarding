/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/TableDraggable.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuedraggable__ = __webpack_require__("./node_modules/vuedraggable/dist/vuedraggable.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuedraggable___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vuedraggable__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
    components: {
        draggable: __WEBPACK_IMPORTED_MODULE_0_vuedraggable___default.a
    },
    mounted: function mounted() {
        console.log('Component mounted.');
    },
    data: function data() {
        return {
            sections: [],
            csrf: document.head.querySelector('meta[name="csrf_token"]').content
        };
    },
    created: function created() {
        this.fetchQuestionSections();
    },

    methods: {
        fetchQuestionSections: function fetchQuestionSections() {
            var _this = this;

            axios.get('/admin/survey-list/2').then(function (res) {
                _this.sections = res.data;
                _this.loading = false;
            }).catch(function (err) {
                return console.error(err);
            });;
        },
        update: function update() {
            this.sections.map(function (section, index) {
                section.section_order = index + 1;
            });
            // for (var i = this.sections.length - 1; i >= 0; i--) {
            //     console.log(this.sections[i].questions)
            //     this.sections[i].questions.map((question, index) => {
            //         question.question_order = index + 1;
            //     })
            // }

            axios.post('/admin/survey/update-all', {
                sections: this.sections
            }).then(function (response) {
                console.log('success');
            });
        },
        updateQuestions: function updateQuestions(event) {
            // let id = event.item.getAttribute('data-id');
            // console.log(group);
        }
    }

});

/***/ }),

/***/ "./node_modules/sortablejs/Sortable.js":
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;/**!
 * Sortable
 * @author	RubaXa   <trash@rubaxa.org>
 * @license MIT
 */

(function sortableModule(factory) {
	"use strict";

	if (true) {
		!(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
				__WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	}
	else if (typeof module != "undefined" && typeof module.exports != "undefined") {
		module.exports = factory();
	}
	else {
		/* jshint sub:true */
		window["Sortable"] = factory();
	}
})(function sortableFactory() {
	"use strict";

	if (typeof window === "undefined" || !window.document) {
		return function sortableError() {
			throw new Error("Sortable.js requires a window with a document");
		};
	}

	var dragEl,
		parentEl,
		ghostEl,
		cloneEl,
		rootEl,
		nextEl,
		lastDownEl,

		scrollEl,
		scrollParentEl,
		scrollCustomFn,

		lastEl,
		lastCSS,
		lastParentCSS,

		oldIndex,
		newIndex,

		activeGroup,
		putSortable,

		autoScroll = {},

		tapEvt,
		touchEvt,

		moved,

		/** @const */
		R_SPACE = /\s+/g,
		R_FLOAT = /left|right|inline/,

		expando = 'Sortable' + (new Date).getTime(),

		win = window,
		document = win.document,
		parseInt = win.parseInt,
		setTimeout = win.setTimeout,

		$ = win.jQuery || win.Zepto,
		Polymer = win.Polymer,

		captureMode = false,
		passiveMode = false,

		supportDraggable = ('draggable' in document.createElement('div')),
		supportCssPointerEvents = (function (el) {
			// false when IE11
			if (!!navigator.userAgent.match(/(?:Trident.*rv[ :]?11\.|msie)/i)) {
				return false;
			}
			el = document.createElement('x');
			el.style.cssText = 'pointer-events:auto';
			return el.style.pointerEvents === 'auto';
		})(),

		_silent = false,

		abs = Math.abs,
		min = Math.min,

		savedInputChecked = [],
		touchDragOverListeners = [],

		_autoScroll = _throttle(function (/**Event*/evt, /**Object*/options, /**HTMLElement*/rootEl) {
			// Bug: https://bugzilla.mozilla.org/show_bug.cgi?id=505521
			if (rootEl && options.scroll) {
				var _this = rootEl[expando],
					el,
					rect,
					sens = options.scrollSensitivity,
					speed = options.scrollSpeed,

					x = evt.clientX,
					y = evt.clientY,

					winWidth = window.innerWidth,
					winHeight = window.innerHeight,

					vx,
					vy,

					scrollOffsetX,
					scrollOffsetY
				;

				// Delect scrollEl
				if (scrollParentEl !== rootEl) {
					scrollEl = options.scroll;
					scrollParentEl = rootEl;
					scrollCustomFn = options.scrollFn;

					if (scrollEl === true) {
						scrollEl = rootEl;

						do {
							if ((scrollEl.offsetWidth < scrollEl.scrollWidth) ||
								(scrollEl.offsetHeight < scrollEl.scrollHeight)
							) {
								break;
							}
							/* jshint boss:true */
						} while (scrollEl = scrollEl.parentNode);
					}
				}

				if (scrollEl) {
					el = scrollEl;
					rect = scrollEl.getBoundingClientRect();
					vx = (abs(rect.right - x) <= sens) - (abs(rect.left - x) <= sens);
					vy = (abs(rect.bottom - y) <= sens) - (abs(rect.top - y) <= sens);
				}


				if (!(vx || vy)) {
					vx = (winWidth - x <= sens) - (x <= sens);
					vy = (winHeight - y <= sens) - (y <= sens);

					/* jshint expr:true */
					(vx || vy) && (el = win);
				}


				if (autoScroll.vx !== vx || autoScroll.vy !== vy || autoScroll.el !== el) {
					autoScroll.el = el;
					autoScroll.vx = vx;
					autoScroll.vy = vy;

					clearInterval(autoScroll.pid);

					if (el) {
						autoScroll.pid = setInterval(function () {
							scrollOffsetY = vy ? vy * speed : 0;
							scrollOffsetX = vx ? vx * speed : 0;

							if ('function' === typeof(scrollCustomFn)) {
								return scrollCustomFn.call(_this, scrollOffsetX, scrollOffsetY, evt);
							}

							if (el === win) {
								win.scrollTo(win.pageXOffset + scrollOffsetX, win.pageYOffset + scrollOffsetY);
							} else {
								el.scrollTop += scrollOffsetY;
								el.scrollLeft += scrollOffsetX;
							}
						}, 24);
					}
				}
			}
		}, 30),

		_prepareGroup = function (options) {
			function toFn(value, pull) {
				if (value === void 0 || value === true) {
					value = group.name;
				}

				if (typeof value === 'function') {
					return value;
				} else {
					return function (to, from) {
						var fromGroup = from.options.group.name;

						return pull
							? value
							: value && (value.join
								? value.indexOf(fromGroup) > -1
								: (fromGroup == value)
							);
					};
				}
			}

			var group = {};
			var originalGroup = options.group;

			if (!originalGroup || typeof originalGroup != 'object') {
				originalGroup = {name: originalGroup};
			}

			group.name = originalGroup.name;
			group.checkPull = toFn(originalGroup.pull, true);
			group.checkPut = toFn(originalGroup.put);
			group.revertClone = originalGroup.revertClone;

			options.group = group;
		}
	;

	// Detect support a passive mode
	try {
		window.addEventListener('test', null, Object.defineProperty({}, 'passive', {
			get: function () {
				// `false`, because everything starts to work incorrectly and instead of d'n'd,
				// begins the page has scrolled.
				passiveMode = false;
				captureMode = {
					capture: false,
					passive: passiveMode
				};
			}
		}));
	} catch (err) {}

	/**
	 * @class  Sortable
	 * @param  {HTMLElement}  el
	 * @param  {Object}       [options]
	 */
	function Sortable(el, options) {
		if (!(el && el.nodeType && el.nodeType === 1)) {
			throw 'Sortable: `el` must be HTMLElement, and not ' + {}.toString.call(el);
		}

		this.el = el; // root element
		this.options = options = _extend({}, options);


		// Export instance
		el[expando] = this;

		// Default options
		var defaults = {
			group: Math.random(),
			sort: true,
			disabled: false,
			store: null,
			handle: null,
			scroll: true,
			scrollSensitivity: 30,
			scrollSpeed: 10,
			draggable: /[uo]l/i.test(el.nodeName) ? 'li' : '>*',
			ghostClass: 'sortable-ghost',
			chosenClass: 'sortable-chosen',
			dragClass: 'sortable-drag',
			ignore: 'a, img',
			filter: null,
			preventOnFilter: true,
			animation: 0,
			setData: function (dataTransfer, dragEl) {
				dataTransfer.setData('Text', dragEl.textContent);
			},
			dropBubble: false,
			dragoverBubble: false,
			dataIdAttr: 'data-id',
			delay: 0,
			forceFallback: false,
			fallbackClass: 'sortable-fallback',
			fallbackOnBody: false,
			fallbackTolerance: 0,
			fallbackOffset: {x: 0, y: 0},
			supportPointer: Sortable.supportPointer !== false
		};


		// Set default options
		for (var name in defaults) {
			!(name in options) && (options[name] = defaults[name]);
		}

		_prepareGroup(options);

		// Bind all private methods
		for (var fn in this) {
			if (fn.charAt(0) === '_' && typeof this[fn] === 'function') {
				this[fn] = this[fn].bind(this);
			}
		}

		// Setup drag mode
		this.nativeDraggable = options.forceFallback ? false : supportDraggable;

		// Bind events
		_on(el, 'mousedown', this._onTapStart);
		_on(el, 'touchstart', this._onTapStart);
		options.supportPointer && _on(el, 'pointerdown', this._onTapStart);

		if (this.nativeDraggable) {
			_on(el, 'dragover', this);
			_on(el, 'dragenter', this);
		}

		touchDragOverListeners.push(this._onDragOver);

		// Restore sorting
		options.store && this.sort(options.store.get(this));
	}


	Sortable.prototype = /** @lends Sortable.prototype */ {
		constructor: Sortable,

		_onTapStart: function (/** Event|TouchEvent */evt) {
			var _this = this,
				el = this.el,
				options = this.options,
				preventOnFilter = options.preventOnFilter,
				type = evt.type,
				touch = evt.touches && evt.touches[0],
				target = (touch || evt).target,
				originalTarget = evt.target.shadowRoot && (evt.path && evt.path[0]) || target,
				filter = options.filter,
				startIndex;

			_saveInputCheckedState(el);


			// Don't trigger start event when an element is been dragged, otherwise the evt.oldindex always wrong when set option.group.
			if (dragEl) {
				return;
			}

			if (/mousedown|pointerdown/.test(type) && evt.button !== 0 || options.disabled) {
				return; // only left button or enabled
			}

			// cancel dnd if original target is content editable
			if (originalTarget.isContentEditable) {
				return;
			}

			target = _closest(target, options.draggable, el);

			if (!target) {
				return;
			}

			if (lastDownEl === target) {
				// Ignoring duplicate `down`
				return;
			}

			// Get the index of the dragged element within its parent
			startIndex = _index(target, options.draggable);

			// Check filter
			if (typeof filter === 'function') {
				if (filter.call(this, evt, target, this)) {
					_dispatchEvent(_this, originalTarget, 'filter', target, el, el, startIndex);
					preventOnFilter && evt.preventDefault();
					return; // cancel dnd
				}
			}
			else if (filter) {
				filter = filter.split(',').some(function (criteria) {
					criteria = _closest(originalTarget, criteria.trim(), el);

					if (criteria) {
						_dispatchEvent(_this, criteria, 'filter', target, el, el, startIndex);
						return true;
					}
				});

				if (filter) {
					preventOnFilter && evt.preventDefault();
					return; // cancel dnd
				}
			}

			if (options.handle && !_closest(originalTarget, options.handle, el)) {
				return;
			}

			// Prepare `dragstart`
			this._prepareDragStart(evt, touch, target, startIndex);
		},

		_prepareDragStart: function (/** Event */evt, /** Touch */touch, /** HTMLElement */target, /** Number */startIndex) {
			var _this = this,
				el = _this.el,
				options = _this.options,
				ownerDocument = el.ownerDocument,
				dragStartFn;

			if (target && !dragEl && (target.parentNode === el)) {
				tapEvt = evt;

				rootEl = el;
				dragEl = target;
				parentEl = dragEl.parentNode;
				nextEl = dragEl.nextSibling;
				lastDownEl = target;
				activeGroup = options.group;
				oldIndex = startIndex;

				this._lastX = (touch || evt).clientX;
				this._lastY = (touch || evt).clientY;

				dragEl.style['will-change'] = 'all';

				dragStartFn = function () {
					// Delayed drag has been triggered
					// we can re-enable the events: touchmove/mousemove
					_this._disableDelayedDrag();

					// Make the element draggable
					dragEl.draggable = _this.nativeDraggable;

					// Chosen item
					_toggleClass(dragEl, options.chosenClass, true);

					// Bind the events: dragstart/dragend
					_this._triggerDragStart(evt, touch);

					// Drag start event
					_dispatchEvent(_this, rootEl, 'choose', dragEl, rootEl, rootEl, oldIndex);
				};

				// Disable "draggable"
				options.ignore.split(',').forEach(function (criteria) {
					_find(dragEl, criteria.trim(), _disableDraggable);
				});

				_on(ownerDocument, 'mouseup', _this._onDrop);
				_on(ownerDocument, 'touchend', _this._onDrop);
				_on(ownerDocument, 'touchcancel', _this._onDrop);
				_on(ownerDocument, 'selectstart', _this);
				options.supportPointer && _on(ownerDocument, 'pointercancel', _this._onDrop);

				if (options.delay) {
					// If the user moves the pointer or let go the click or touch
					// before the delay has been reached:
					// disable the delayed drag
					_on(ownerDocument, 'mouseup', _this._disableDelayedDrag);
					_on(ownerDocument, 'touchend', _this._disableDelayedDrag);
					_on(ownerDocument, 'touchcancel', _this._disableDelayedDrag);
					_on(ownerDocument, 'mousemove', _this._disableDelayedDrag);
					_on(ownerDocument, 'touchmove', _this._disableDelayedDrag);
					options.supportPointer && _on(ownerDocument, 'pointermove', _this._disableDelayedDrag);

					_this._dragStartTimer = setTimeout(dragStartFn, options.delay);
				} else {
					dragStartFn();
				}


			}
		},

		_disableDelayedDrag: function () {
			var ownerDocument = this.el.ownerDocument;

			clearTimeout(this._dragStartTimer);
			_off(ownerDocument, 'mouseup', this._disableDelayedDrag);
			_off(ownerDocument, 'touchend', this._disableDelayedDrag);
			_off(ownerDocument, 'touchcancel', this._disableDelayedDrag);
			_off(ownerDocument, 'mousemove', this._disableDelayedDrag);
			_off(ownerDocument, 'touchmove', this._disableDelayedDrag);
			_off(ownerDocument, 'pointermove', this._disableDelayedDrag);
		},

		_triggerDragStart: function (/** Event */evt, /** Touch */touch) {
			touch = touch || (evt.pointerType == 'touch' ? evt : null);

			if (touch) {
				// Touch device support
				tapEvt = {
					target: dragEl,
					clientX: touch.clientX,
					clientY: touch.clientY
				};

				this._onDragStart(tapEvt, 'touch');
			}
			else if (!this.nativeDraggable) {
				this._onDragStart(tapEvt, true);
			}
			else {
				_on(dragEl, 'dragend', this);
				_on(rootEl, 'dragstart', this._onDragStart);
			}

			try {
				if (document.selection) {
					// Timeout neccessary for IE9
					_nextTick(function () {
						document.selection.empty();
					});
				} else {
					window.getSelection().removeAllRanges();
				}
			} catch (err) {
			}
		},

		_dragStarted: function () {
			if (rootEl && dragEl) {
				var options = this.options;

				// Apply effect
				_toggleClass(dragEl, options.ghostClass, true);
				_toggleClass(dragEl, options.dragClass, false);

				Sortable.active = this;

				// Drag start event
				_dispatchEvent(this, rootEl, 'start', dragEl, rootEl, rootEl, oldIndex);
			} else {
				this._nulling();
			}
		},

		_emulateDragOver: function () {
			if (touchEvt) {
				if (this._lastX === touchEvt.clientX && this._lastY === touchEvt.clientY) {
					return;
				}

				this._lastX = touchEvt.clientX;
				this._lastY = touchEvt.clientY;

				if (!supportCssPointerEvents) {
					_css(ghostEl, 'display', 'none');
				}

				var target = document.elementFromPoint(touchEvt.clientX, touchEvt.clientY);
				var parent = target;
				var i = touchDragOverListeners.length;

				if (target && target.shadowRoot) {
					target = target.shadowRoot.elementFromPoint(touchEvt.clientX, touchEvt.clientY);
					parent = target;
				}

				if (parent) {
					do {
						if (parent[expando]) {
							while (i--) {
								touchDragOverListeners[i]({
									clientX: touchEvt.clientX,
									clientY: touchEvt.clientY,
									target: target,
									rootEl: parent
								});
							}

							break;
						}

						target = parent; // store last element
					}
					/* jshint boss:true */
					while (parent = parent.parentNode);
				}

				if (!supportCssPointerEvents) {
					_css(ghostEl, 'display', '');
				}
			}
		},


		_onTouchMove: function (/**TouchEvent*/evt) {
			if (tapEvt) {
				var	options = this.options,
					fallbackTolerance = options.fallbackTolerance,
					fallbackOffset = options.fallbackOffset,
					touch = evt.touches ? evt.touches[0] : evt,
					dx = (touch.clientX - tapEvt.clientX) + fallbackOffset.x,
					dy = (touch.clientY - tapEvt.clientY) + fallbackOffset.y,
					translate3d = evt.touches ? 'translate3d(' + dx + 'px,' + dy + 'px,0)' : 'translate(' + dx + 'px,' + dy + 'px)';

				// only set the status to dragging, when we are actually dragging
				if (!Sortable.active) {
					if (fallbackTolerance &&
						min(abs(touch.clientX - this._lastX), abs(touch.clientY - this._lastY)) < fallbackTolerance
					) {
						return;
					}

					this._dragStarted();
				}

				// as well as creating the ghost element on the document body
				this._appendGhost();

				moved = true;
				touchEvt = touch;

				_css(ghostEl, 'webkitTransform', translate3d);
				_css(ghostEl, 'mozTransform', translate3d);
				_css(ghostEl, 'msTransform', translate3d);
				_css(ghostEl, 'transform', translate3d);

				evt.preventDefault();
			}
		},

		_appendGhost: function () {
			if (!ghostEl) {
				var rect = dragEl.getBoundingClientRect(),
					css = _css(dragEl),
					options = this.options,
					ghostRect;

				ghostEl = dragEl.cloneNode(true);

				_toggleClass(ghostEl, options.ghostClass, false);
				_toggleClass(ghostEl, options.fallbackClass, true);
				_toggleClass(ghostEl, options.dragClass, true);

				_css(ghostEl, 'top', rect.top - parseInt(css.marginTop, 10));
				_css(ghostEl, 'left', rect.left - parseInt(css.marginLeft, 10));
				_css(ghostEl, 'width', rect.width);
				_css(ghostEl, 'height', rect.height);
				_css(ghostEl, 'opacity', '0.8');
				_css(ghostEl, 'position', 'fixed');
				_css(ghostEl, 'zIndex', '100000');
				_css(ghostEl, 'pointerEvents', 'none');

				options.fallbackOnBody && document.body.appendChild(ghostEl) || rootEl.appendChild(ghostEl);

				// Fixing dimensions.
				ghostRect = ghostEl.getBoundingClientRect();
				_css(ghostEl, 'width', rect.width * 2 - ghostRect.width);
				_css(ghostEl, 'height', rect.height * 2 - ghostRect.height);
			}
		},

		_onDragStart: function (/**Event*/evt, /**boolean*/useFallback) {
			var _this = this;
			var dataTransfer = evt.dataTransfer;
			var options = _this.options;

			_this._offUpEvents();

			if (activeGroup.checkPull(_this, _this, dragEl, evt)) {
				cloneEl = _clone(dragEl);

				cloneEl.draggable = false;
				cloneEl.style['will-change'] = '';

				_css(cloneEl, 'display', 'none');
				_toggleClass(cloneEl, _this.options.chosenClass, false);

				// #1143: IFrame support workaround
				_this._cloneId = _nextTick(function () {
					rootEl.insertBefore(cloneEl, dragEl);
					_dispatchEvent(_this, rootEl, 'clone', dragEl);
				});
			}

			_toggleClass(dragEl, options.dragClass, true);

			if (useFallback) {
				if (useFallback === 'touch') {
					// Bind touch events
					_on(document, 'touchmove', _this._onTouchMove);
					_on(document, 'touchend', _this._onDrop);
					_on(document, 'touchcancel', _this._onDrop);

					if (options.supportPointer) {
						_on(document, 'pointermove', _this._onTouchMove);
						_on(document, 'pointerup', _this._onDrop);
					}
				} else {
					// Old brwoser
					_on(document, 'mousemove', _this._onTouchMove);
					_on(document, 'mouseup', _this._onDrop);
				}

				_this._loopId = setInterval(_this._emulateDragOver, 50);
			}
			else {
				if (dataTransfer) {
					dataTransfer.effectAllowed = 'move';
					options.setData && options.setData.call(_this, dataTransfer, dragEl);
				}

				_on(document, 'drop', _this);

				// #1143: Бывает элемент с IFrame внутри блокирует `drop`,
				// поэтому если вызвался `mouseover`, значит надо отменять весь d'n'd.
				// Breaking Chrome 62+
				// _on(document, 'mouseover', _this);

				_this._dragStartId = _nextTick(_this._dragStarted);
			}
		},

		_onDragOver: function (/**Event*/evt) {
			var el = this.el,
				target,
				dragRect,
				targetRect,
				revert,
				options = this.options,
				group = options.group,
				activeSortable = Sortable.active,
				isOwner = (activeGroup === group),
				isMovingBetweenSortable = false,
				canSort = options.sort;

			if (evt.preventDefault !== void 0) {
				evt.preventDefault();
				!options.dragoverBubble && evt.stopPropagation();
			}

			if (dragEl.animated) {
				return;
			}

			moved = true;

			if (activeSortable && !options.disabled &&
				(isOwner
					? canSort || (revert = !rootEl.contains(dragEl)) // Reverting item into the original list
					: (
						putSortable === this ||
						(
							(activeSortable.lastPullMode = activeGroup.checkPull(this, activeSortable, dragEl, evt)) &&
							group.checkPut(this, activeSortable, dragEl, evt)
						)
					)
				) &&
				(evt.rootEl === void 0 || evt.rootEl === this.el) // touch fallback
			) {
				// Smart auto-scrolling
				_autoScroll(evt, options, this.el);

				if (_silent) {
					return;
				}

				target = _closest(evt.target, options.draggable, el);
				dragRect = dragEl.getBoundingClientRect();

				if (putSortable !== this) {
					putSortable = this;
					isMovingBetweenSortable = true;
				}

				if (revert) {
					_cloneHide(activeSortable, true);
					parentEl = rootEl; // actualization

					if (cloneEl || nextEl) {
						rootEl.insertBefore(dragEl, cloneEl || nextEl);
					}
					else if (!canSort) {
						rootEl.appendChild(dragEl);
					}

					return;
				}


				if ((el.children.length === 0) || (el.children[0] === ghostEl) ||
					(el === evt.target) && (_ghostIsLast(el, evt))
				) {
					//assign target only if condition is true
					if (el.children.length !== 0 && el.children[0] !== ghostEl && el === evt.target) {
						target = el.lastElementChild;
					}

					if (target) {
						if (target.animated) {
							return;
						}

						targetRect = target.getBoundingClientRect();
					}

					_cloneHide(activeSortable, isOwner);

					if (_onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt) !== false) {
						if (!dragEl.contains(el)) {
							el.appendChild(dragEl);
							parentEl = el; // actualization
						}

						this._animate(dragRect, dragEl);
						target && this._animate(targetRect, target);
					}
				}
				else if (target && !target.animated && target !== dragEl && (target.parentNode[expando] !== void 0)) {
					if (lastEl !== target) {
						lastEl = target;
						lastCSS = _css(target);
						lastParentCSS = _css(target.parentNode);
					}

					targetRect = target.getBoundingClientRect();

					var width = targetRect.right - targetRect.left,
						height = targetRect.bottom - targetRect.top,
						floating = R_FLOAT.test(lastCSS.cssFloat + lastCSS.display)
							|| (lastParentCSS.display == 'flex' && lastParentCSS['flex-direction'].indexOf('row') === 0),
						isWide = (target.offsetWidth > dragEl.offsetWidth),
						isLong = (target.offsetHeight > dragEl.offsetHeight),
						halfway = (floating ? (evt.clientX - targetRect.left) / width : (evt.clientY - targetRect.top) / height) > 0.5,
						nextSibling = target.nextElementSibling,
						after = false
					;

					if (floating) {
						var elTop = dragEl.offsetTop,
							tgTop = target.offsetTop;

						if (elTop === tgTop) {
							after = (target.previousElementSibling === dragEl) && !isWide || halfway && isWide;
						}
						else if (target.previousElementSibling === dragEl || dragEl.previousElementSibling === target) {
							after = (evt.clientY - targetRect.top) / height > 0.5;
						} else {
							after = tgTop > elTop;
						}
						} else if (!isMovingBetweenSortable) {
						after = (nextSibling !== dragEl) && !isLong || halfway && isLong;
					}

					var moveVector = _onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt, after);

					if (moveVector !== false) {
						if (moveVector === 1 || moveVector === -1) {
							after = (moveVector === 1);
						}

						_silent = true;
						setTimeout(_unsilent, 30);

						_cloneHide(activeSortable, isOwner);

						if (!dragEl.contains(el)) {
							if (after && !nextSibling) {
								el.appendChild(dragEl);
							} else {
								target.parentNode.insertBefore(dragEl, after ? nextSibling : target);
							}
						}

						parentEl = dragEl.parentNode; // actualization

						this._animate(dragRect, dragEl);
						this._animate(targetRect, target);
					}
				}
			}
		},

		_animate: function (prevRect, target) {
			var ms = this.options.animation;

			if (ms) {
				var currentRect = target.getBoundingClientRect();

				if (prevRect.nodeType === 1) {
					prevRect = prevRect.getBoundingClientRect();
				}

				_css(target, 'transition', 'none');
				_css(target, 'transform', 'translate3d('
					+ (prevRect.left - currentRect.left) + 'px,'
					+ (prevRect.top - currentRect.top) + 'px,0)'
				);

				target.offsetWidth; // repaint

				_css(target, 'transition', 'all ' + ms + 'ms');
				_css(target, 'transform', 'translate3d(0,0,0)');

				clearTimeout(target.animated);
				target.animated = setTimeout(function () {
					_css(target, 'transition', '');
					_css(target, 'transform', '');
					target.animated = false;
				}, ms);
			}
		},

		_offUpEvents: function () {
			var ownerDocument = this.el.ownerDocument;

			_off(document, 'touchmove', this._onTouchMove);
			_off(document, 'pointermove', this._onTouchMove);
			_off(ownerDocument, 'mouseup', this._onDrop);
			_off(ownerDocument, 'touchend', this._onDrop);
			_off(ownerDocument, 'pointerup', this._onDrop);
			_off(ownerDocument, 'touchcancel', this._onDrop);
			_off(ownerDocument, 'pointercancel', this._onDrop);
			_off(ownerDocument, 'selectstart', this);
		},

		_onDrop: function (/**Event*/evt) {
			var el = this.el,
				options = this.options;

			clearInterval(this._loopId);
			clearInterval(autoScroll.pid);
			clearTimeout(this._dragStartTimer);

			_cancelNextTick(this._cloneId);
			_cancelNextTick(this._dragStartId);

			// Unbind events
			_off(document, 'mouseover', this);
			_off(document, 'mousemove', this._onTouchMove);

			if (this.nativeDraggable) {
				_off(document, 'drop', this);
				_off(el, 'dragstart', this._onDragStart);
			}

			this._offUpEvents();

			if (evt) {
				if (moved) {
					evt.preventDefault();
					!options.dropBubble && evt.stopPropagation();
				}

				ghostEl && ghostEl.parentNode && ghostEl.parentNode.removeChild(ghostEl);

				if (rootEl === parentEl || Sortable.active.lastPullMode !== 'clone') {
					// Remove clone
					cloneEl && cloneEl.parentNode && cloneEl.parentNode.removeChild(cloneEl);
				}

				if (dragEl) {
					if (this.nativeDraggable) {
						_off(dragEl, 'dragend', this);
					}

					_disableDraggable(dragEl);
					dragEl.style['will-change'] = '';

					// Remove class's
					_toggleClass(dragEl, this.options.ghostClass, false);
					_toggleClass(dragEl, this.options.chosenClass, false);

					// Drag stop event
					_dispatchEvent(this, rootEl, 'unchoose', dragEl, parentEl, rootEl, oldIndex);

					if (rootEl !== parentEl) {
						newIndex = _index(dragEl, options.draggable);

						if (newIndex >= 0) {
							// Add event
							_dispatchEvent(null, parentEl, 'add', dragEl, parentEl, rootEl, oldIndex, newIndex);

							// Remove event
							_dispatchEvent(this, rootEl, 'remove', dragEl, parentEl, rootEl, oldIndex, newIndex);

							// drag from one list and drop into another
							_dispatchEvent(null, parentEl, 'sort', dragEl, parentEl, rootEl, oldIndex, newIndex);
							_dispatchEvent(this, rootEl, 'sort', dragEl, parentEl, rootEl, oldIndex, newIndex);
						}
					}
					else {
						if (dragEl.nextSibling !== nextEl) {
							// Get the index of the dragged element within its parent
							newIndex = _index(dragEl, options.draggable);

							if (newIndex >= 0) {
								// drag & drop within the same list
								_dispatchEvent(this, rootEl, 'update', dragEl, parentEl, rootEl, oldIndex, newIndex);
								_dispatchEvent(this, rootEl, 'sort', dragEl, parentEl, rootEl, oldIndex, newIndex);
							}
						}
					}

					if (Sortable.active) {
						/* jshint eqnull:true */
						if (newIndex == null || newIndex === -1) {
							newIndex = oldIndex;
						}

						_dispatchEvent(this, rootEl, 'end', dragEl, parentEl, rootEl, oldIndex, newIndex);

						// Save sorting
						this.save();
					}
				}

			}

			this._nulling();
		},

		_nulling: function() {
			rootEl =
			dragEl =
			parentEl =
			ghostEl =
			nextEl =
			cloneEl =
			lastDownEl =

			scrollEl =
			scrollParentEl =

			tapEvt =
			touchEvt =

			moved =
			newIndex =

			lastEl =
			lastCSS =

			putSortable =
			activeGroup =
			Sortable.active = null;

			savedInputChecked.forEach(function (el) {
				el.checked = true;
			});
			savedInputChecked.length = 0;
		},

		handleEvent: function (/**Event*/evt) {
			switch (evt.type) {
				case 'drop':
				case 'dragend':
					this._onDrop(evt);
					break;

				case 'dragover':
				case 'dragenter':
					if (dragEl) {
						this._onDragOver(evt);
						_globalDragOver(evt);
					}
					break;

				case 'mouseover':
					this._onDrop(evt);
					break;

				case 'selectstart':
					evt.preventDefault();
					break;
			}
		},


		/**
		 * Serializes the item into an array of string.
		 * @returns {String[]}
		 */
		toArray: function () {
			var order = [],
				el,
				children = this.el.children,
				i = 0,
				n = children.length,
				options = this.options;

			for (; i < n; i++) {
				el = children[i];
				if (_closest(el, options.draggable, this.el)) {
					order.push(el.getAttribute(options.dataIdAttr) || _generateId(el));
				}
			}

			return order;
		},


		/**
		 * Sorts the elements according to the array.
		 * @param  {String[]}  order  order of the items
		 */
		sort: function (order) {
			var items = {}, rootEl = this.el;

			this.toArray().forEach(function (id, i) {
				var el = rootEl.children[i];

				if (_closest(el, this.options.draggable, rootEl)) {
					items[id] = el;
				}
			}, this);

			order.forEach(function (id) {
				if (items[id]) {
					rootEl.removeChild(items[id]);
					rootEl.appendChild(items[id]);
				}
			});
		},


		/**
		 * Save the current sorting
		 */
		save: function () {
			var store = this.options.store;
			store && store.set(this);
		},


		/**
		 * For each element in the set, get the first element that matches the selector by testing the element itself and traversing up through its ancestors in the DOM tree.
		 * @param   {HTMLElement}  el
		 * @param   {String}       [selector]  default: `options.draggable`
		 * @returns {HTMLElement|null}
		 */
		closest: function (el, selector) {
			return _closest(el, selector || this.options.draggable, this.el);
		},


		/**
		 * Set/get option
		 * @param   {string} name
		 * @param   {*}      [value]
		 * @returns {*}
		 */
		option: function (name, value) {
			var options = this.options;

			if (value === void 0) {
				return options[name];
			} else {
				options[name] = value;

				if (name === 'group') {
					_prepareGroup(options);
				}
			}
		},


		/**
		 * Destroy
		 */
		destroy: function () {
			var el = this.el;

			el[expando] = null;

			_off(el, 'mousedown', this._onTapStart);
			_off(el, 'touchstart', this._onTapStart);
			_off(el, 'pointerdown', this._onTapStart);

			if (this.nativeDraggable) {
				_off(el, 'dragover', this);
				_off(el, 'dragenter', this);
			}

			// Remove draggable attributes
			Array.prototype.forEach.call(el.querySelectorAll('[draggable]'), function (el) {
				el.removeAttribute('draggable');
			});

			touchDragOverListeners.splice(touchDragOverListeners.indexOf(this._onDragOver), 1);

			this._onDrop();

			this.el = el = null;
		}
	};


	function _cloneHide(sortable, state) {
		if (sortable.lastPullMode !== 'clone') {
			state = true;
		}

		if (cloneEl && (cloneEl.state !== state)) {
			_css(cloneEl, 'display', state ? 'none' : '');

			if (!state) {
				if (cloneEl.state) {
					if (sortable.options.group.revertClone) {
						rootEl.insertBefore(cloneEl, nextEl);
						sortable._animate(dragEl, cloneEl);
					} else {
						rootEl.insertBefore(cloneEl, dragEl);
					}
				}
			}

			cloneEl.state = state;
		}
	}


	function _closest(/**HTMLElement*/el, /**String*/selector, /**HTMLElement*/ctx) {
		if (el) {
			ctx = ctx || document;

			do {
				if ((selector === '>*' && el.parentNode === ctx) || _matches(el, selector)) {
					return el;
				}
				/* jshint boss:true */
			} while (el = _getParentOrHost(el));
		}

		return null;
	}


	function _getParentOrHost(el) {
		var parent = el.host;

		return (parent && parent.nodeType) ? parent : el.parentNode;
	}


	function _globalDragOver(/**Event*/evt) {
		if (evt.dataTransfer) {
			evt.dataTransfer.dropEffect = 'move';
		}
		evt.preventDefault();
	}


	function _on(el, event, fn) {
		el.addEventListener(event, fn, captureMode);
	}


	function _off(el, event, fn) {
		el.removeEventListener(event, fn, captureMode);
	}


	function _toggleClass(el, name, state) {
		if (el) {
			if (el.classList) {
				el.classList[state ? 'add' : 'remove'](name);
			}
			else {
				var className = (' ' + el.className + ' ').replace(R_SPACE, ' ').replace(' ' + name + ' ', ' ');
				el.className = (className + (state ? ' ' + name : '')).replace(R_SPACE, ' ');
			}
		}
	}


	function _css(el, prop, val) {
		var style = el && el.style;

		if (style) {
			if (val === void 0) {
				if (document.defaultView && document.defaultView.getComputedStyle) {
					val = document.defaultView.getComputedStyle(el, '');
				}
				else if (el.currentStyle) {
					val = el.currentStyle;
				}

				return prop === void 0 ? val : val[prop];
			}
			else {
				if (!(prop in style)) {
					prop = '-webkit-' + prop;
				}

				style[prop] = val + (typeof val === 'string' ? '' : 'px');
			}
		}
	}


	function _find(ctx, tagName, iterator) {
		if (ctx) {
			var list = ctx.getElementsByTagName(tagName), i = 0, n = list.length;

			if (iterator) {
				for (; i < n; i++) {
					iterator(list[i], i);
				}
			}

			return list;
		}

		return [];
	}



	function _dispatchEvent(sortable, rootEl, name, targetEl, toEl, fromEl, startIndex, newIndex) {
		sortable = (sortable || rootEl[expando]);

		var evt = document.createEvent('Event'),
			options = sortable.options,
			onName = 'on' + name.charAt(0).toUpperCase() + name.substr(1);

		evt.initEvent(name, true, true);

		evt.to = toEl || rootEl;
		evt.from = fromEl || rootEl;
		evt.item = targetEl || rootEl;
		evt.clone = cloneEl;

		evt.oldIndex = startIndex;
		evt.newIndex = newIndex;

		rootEl.dispatchEvent(evt);

		if (options[onName]) {
			options[onName].call(sortable, evt);
		}
	}


	function _onMove(fromEl, toEl, dragEl, dragRect, targetEl, targetRect, originalEvt, willInsertAfter) {
		var evt,
			sortable = fromEl[expando],
			onMoveFn = sortable.options.onMove,
			retVal;

		evt = document.createEvent('Event');
		evt.initEvent('move', true, true);

		evt.to = toEl;
		evt.from = fromEl;
		evt.dragged = dragEl;
		evt.draggedRect = dragRect;
		evt.related = targetEl || toEl;
		evt.relatedRect = targetRect || toEl.getBoundingClientRect();
		evt.willInsertAfter = willInsertAfter;

		fromEl.dispatchEvent(evt);

		if (onMoveFn) {
			retVal = onMoveFn.call(sortable, evt, originalEvt);
		}

		return retVal;
	}


	function _disableDraggable(el) {
		el.draggable = false;
	}


	function _unsilent() {
		_silent = false;
	}


	/** @returns {HTMLElement|false} */
	function _ghostIsLast(el, evt) {
		var lastEl = el.lastElementChild,
			rect = lastEl.getBoundingClientRect();

		// 5 — min delta
		// abs — нельзя добавлять, а то глюки при наведении сверху
		return (evt.clientY - (rect.top + rect.height) > 5) ||
			(evt.clientX - (rect.left + rect.width) > 5);
	}


	/**
	 * Generate id
	 * @param   {HTMLElement} el
	 * @returns {String}
	 * @private
	 */
	function _generateId(el) {
		var str = el.tagName + el.className + el.src + el.href + el.textContent,
			i = str.length,
			sum = 0;

		while (i--) {
			sum += str.charCodeAt(i);
		}

		return sum.toString(36);
	}

	/**
	 * Returns the index of an element within its parent for a selected set of
	 * elements
	 * @param  {HTMLElement} el
	 * @param  {selector} selector
	 * @return {number}
	 */
	function _index(el, selector) {
		var index = 0;

		if (!el || !el.parentNode) {
			return -1;
		}

		while (el && (el = el.previousElementSibling)) {
			if ((el.nodeName.toUpperCase() !== 'TEMPLATE') && (selector === '>*' || _matches(el, selector))) {
				index++;
			}
		}

		return index;
	}

	function _matches(/**HTMLElement*/el, /**String*/selector) {
		if (el) {
			selector = selector.split('.');

			var tag = selector.shift().toUpperCase(),
				re = new RegExp('\\s(' + selector.join('|') + ')(?=\\s)', 'g');

			return (
				(tag === '' || el.nodeName.toUpperCase() == tag) &&
				(!selector.length || ((' ' + el.className + ' ').match(re) || []).length == selector.length)
			);
		}

		return false;
	}

	function _throttle(callback, ms) {
		var args, _this;

		return function () {
			if (args === void 0) {
				args = arguments;
				_this = this;

				setTimeout(function () {
					if (args.length === 1) {
						callback.call(_this, args[0]);
					} else {
						callback.apply(_this, args);
					}

					args = void 0;
				}, ms);
			}
		};
	}

	function _extend(dst, src) {
		if (dst && src) {
			for (var key in src) {
				if (src.hasOwnProperty(key)) {
					dst[key] = src[key];
				}
			}
		}

		return dst;
	}

	function _clone(el) {
		if (Polymer && Polymer.dom) {
			return Polymer.dom(el).cloneNode(true);
		}
		else if ($) {
			return $(el).clone(true)[0];
		}
		else {
			return el.cloneNode(true);
		}
	}

	function _saveInputCheckedState(root) {
		var inputs = root.getElementsByTagName('input');
		var idx = inputs.length;

		while (idx--) {
			var el = inputs[idx];
			el.checked && savedInputChecked.push(el);
		}
	}

	function _nextTick(fn) {
		return setTimeout(fn, 0);
	}

	function _cancelNextTick(id) {
		return clearTimeout(id);
	}

	// Fixed #973:
	_on(document, 'touchmove', function (evt) {
		if (Sortable.active) {
			evt.preventDefault();
		}
	});

	// Export utils
	Sortable.utils = {
		on: _on,
		off: _off,
		css: _css,
		find: _find,
		is: function (el, selector) {
			return !!_closest(el, selector, el);
		},
		extend: _extend,
		throttle: _throttle,
		closest: _closest,
		toggleClass: _toggleClass,
		clone: _clone,
		index: _index,
		nextTick: _nextTick,
		cancelNextTick: _cancelNextTick
	};


	/**
	 * Create sortable instance
	 * @param {HTMLElement}  el
	 * @param {Object}      [options]
	 */
	Sortable.create = function (el, options) {
		return new Sortable(el, options);
	};


	// Export
	Sortable.version = '1.7.0';
	return Sortable;
});


/***/ }),

/***/ "./node_modules/vue-loader/lib/component-normalizer.js":
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-121447d6\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/TableDraggable.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "draggable",
    {
      attrs: {
        list: _vm.sections,
        options: { animation: 200, handle: ".dragging-hand" },
        element: "ul"
      },
      on: { change: _vm.update }
    },
    _vm._l(_vm.sections, function(item) {
      return _c(
        "li",
        {
          staticClass: "top-draggable-section mb-2",
          attrs: { "data-id": item.id }
        },
        [
          _c("span", { staticClass: "dragging-hand" }, [
            _c(
              "svg",
              {
                staticClass: "draggable-icon",
                attrs: {
                  xmlns: "http://www.w3.org/2000/svg",
                  "xmlns:xlink": "http://www.w3.org/1999/xlink",
                  width: "100",
                  height: "100",
                  viewBox: "0 0 100 100"
                }
              },
              [
                _c("g", [
                  _c(
                    "g",
                    {
                      staticStyle: { fill: "#000000" },
                      attrs: {
                        transform:
                          "translate(50 50) scale(0.69 0.69) rotate(0) translate(-50 -50)"
                      }
                    },
                    [
                      _c(
                        "svg",
                        {
                          attrs: {
                            fill: "#000000",
                            xmlns: "http://www.w3.org/2000/svg",
                            "xmlns:xlink": "http://www.w3.org/1999/xlink",
                            viewBox: "0 0 512 512",
                            version: "1.1",
                            x: "0px",
                            y: "0px"
                          }
                        },
                        [
                          _c("title", [_vm._v("Drag")]),
                          _c("desc", [_vm._v("Created with Sketch.")]),
                          _c(
                            "g",
                            {
                              attrs: {
                                stroke: "none",
                                "stroke-width": "1",
                                fill: "none",
                                "fill-rule": "evenodd"
                              }
                            },
                            [
                              _c(
                                "g",
                                {
                                  attrs: {
                                    transform:
                                      "translate(96.000000, 28.000000)",
                                    fill: "#000000"
                                  }
                                },
                                [
                                  _c("circle", {
                                    attrs: { cx: "45", cy: "45", r: "45" }
                                  }),
                                  _c("circle", {
                                    attrs: { cx: "274", cy: "45", r: "45" }
                                  }),
                                  _c("circle", {
                                    attrs: { cx: "45", cy: "228", r: "45" }
                                  }),
                                  _c("circle", {
                                    attrs: { cx: "274", cy: "228", r: "45" }
                                  }),
                                  _c("circle", {
                                    attrs: { cx: "45", cy: "411", r: "45" }
                                  }),
                                  _c("circle", {
                                    attrs: { cx: "274", cy: "411", r: "45" }
                                  })
                                ]
                              )
                            ]
                          )
                        ]
                      )
                    ]
                  )
                ])
              ]
            ),
            _vm._v(" "),
            _c("b", [_vm._v(_vm._s(item.name))])
          ]),
          _vm._v("\n         - "),
          _c(
            "a",
            {
              staticClass: "badge badge-secondary",
              attrs: { href: "/admin/survey-question/" + item.id + "/edit" }
            },
            [_vm._v("Edit")]
          ),
          _vm._v(" | "),
          _c(
            "a",
            {
              staticClass: "small",
              attrs: { href: "/admin/survey-question/" + item.id + "/delete" }
            },
            [_vm._v("Delete")]
          ),
          _vm._v(" "),
          _c(
            "draggable",
            {
              attrs: {
                list: item.questions,
                options: { group: "allquestions" },
                element: "ul"
              },
              on: {
                change: function($event) {
                  _vm.updateQuestions($event)
                }
              }
            },
            _vm._l(item.questions, function(question) {
              return _c("li", { attrs: { "data-id": question.id } }, [
                _vm._v(_vm._s(question.question) + " \n                ")
              ])
            })
          )
        ],
        1
      )
    })
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-121447d6", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vuedraggable/dist/vuedraggable.js":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

(function () {
  "use strict";

  if (!Array.from) {
    Array.from = function (object) {
      return [].slice.call(object);
    };
  }

  function buildAttribute(object, propName, value) {
    if (value == undefined) {
      return object;
    }
    object = object == null ? {} : object;
    object[propName] = value;
    return object;
  }

  function buildDraggable(Sortable) {
    function removeNode(node) {
      node.parentElement.removeChild(node);
    }

    function insertNodeAt(fatherNode, node, position) {
      var refNode = position === 0 ? fatherNode.children[0] : fatherNode.children[position - 1].nextSibling;
      fatherNode.insertBefore(node, refNode);
    }

    function computeVmIndex(vnodes, element) {
      return vnodes.map(function (elt) {
        return elt.elm;
      }).indexOf(element);
    }

    function _computeIndexes(slots, children, isTransition) {
      if (!slots) {
        return [];
      }

      var elmFromNodes = slots.map(function (elt) {
        return elt.elm;
      });
      var rawIndexes = [].concat(_toConsumableArray(children)).map(function (elt) {
        return elmFromNodes.indexOf(elt);
      });
      return isTransition ? rawIndexes.filter(function (ind) {
        return ind !== -1;
      }) : rawIndexes;
    }

    function emit(evtName, evtData) {
      var _this = this;

      this.$nextTick(function () {
        return _this.$emit(evtName.toLowerCase(), evtData);
      });
    }

    function delegateAndEmit(evtName) {
      var _this2 = this;

      return function (evtData) {
        if (_this2.realList !== null) {
          _this2['onDrag' + evtName](evtData);
        }
        emit.call(_this2, evtName, evtData);
      };
    }

    var eventsListened = ['Start', 'Add', 'Remove', 'Update', 'End'];
    var eventsToEmit = ['Choose', 'Sort', 'Filter', 'Clone'];
    var readonlyProperties = ['Move'].concat(eventsListened, eventsToEmit).map(function (evt) {
      return 'on' + evt;
    });
    var draggingElement = null;

    var props = {
      options: Object,
      list: {
        type: Array,
        required: false,
        default: null
      },
      value: {
        type: Array,
        required: false,
        default: null
      },
      noTransitionOnDrag: {
        type: Boolean,
        default: false
      },
      clone: {
        type: Function,
        default: function _default(original) {
          return original;
        }
      },
      element: {
        type: String,
        default: 'div'
      },
      move: {
        type: Function,
        default: null
      },
      componentData: {
        type: Object,
        required: false,
        default: null
      }
    };

    var draggableComponent = {
      name: 'draggable',

      props: props,

      data: function data() {
        return {
          transitionMode: false,
          noneFunctionalComponentMode: false,
          init: false
        };
      },
      render: function render(h) {
        var slots = this.$slots.default;
        if (slots && slots.length === 1) {
          var child = slots[0];
          if (child.componentOptions && child.componentOptions.tag === "transition-group") {
            this.transitionMode = true;
          }
        }
        var children = slots;
        var footer = this.$slots.footer;

        if (footer) {
          children = slots ? [].concat(_toConsumableArray(slots), _toConsumableArray(footer)) : [].concat(_toConsumableArray(footer));
        }
        var attributes = null;
        var update = function update(name, value) {
          attributes = buildAttribute(attributes, name, value);
        };
        update('attrs', this.$attrs);
        if (this.componentData) {
          var _componentData = this.componentData,
              on = _componentData.on,
              _props = _componentData.props;

          update('on', on);
          update('props', _props);
        }
        return h(this.element, attributes, children);
      },
      mounted: function mounted() {
        var _this3 = this;

        this.noneFunctionalComponentMode = this.element.toLowerCase() !== this.$el.nodeName.toLowerCase();
        if (this.noneFunctionalComponentMode && this.transitionMode) {
          throw new Error('Transition-group inside component is not supported. Please alter element value or remove transition-group. Current element value: ' + this.element);
        }
        var optionsAdded = {};
        eventsListened.forEach(function (elt) {
          optionsAdded['on' + elt] = delegateAndEmit.call(_this3, elt);
        });

        eventsToEmit.forEach(function (elt) {
          optionsAdded['on' + elt] = emit.bind(_this3, elt);
        });

        var options = _extends({}, this.options, optionsAdded, { onMove: function onMove(evt, originalEvent) {
            return _this3.onDragMove(evt, originalEvent);
          } });
        !('draggable' in options) && (options.draggable = '>*');
        this._sortable = new Sortable(this.rootContainer, options);
        this.computeIndexes();
      },
      beforeDestroy: function beforeDestroy() {
        this._sortable.destroy();
      },


      computed: {
        rootContainer: function rootContainer() {
          return this.transitionMode ? this.$el.children[0] : this.$el;
        },
        isCloning: function isCloning() {
          return !!this.options && !!this.options.group && this.options.group.pull === 'clone';
        },
        realList: function realList() {
          return !!this.list ? this.list : this.value;
        }
      },

      watch: {
        options: {
          handler: function handler(newOptionValue) {
            for (var property in newOptionValue) {
              if (readonlyProperties.indexOf(property) == -1) {
                this._sortable.option(property, newOptionValue[property]);
              }
            }
          },

          deep: true
        },

        realList: function realList() {
          this.computeIndexes();
        }
      },

      methods: {
        getChildrenNodes: function getChildrenNodes() {
          if (!this.init) {
            this.noneFunctionalComponentMode = this.noneFunctionalComponentMode && this.$children.length == 1;
            this.init = true;
          }

          if (this.noneFunctionalComponentMode) {
            return this.$children[0].$slots.default;
          }
          var rawNodes = this.$slots.default;
          return this.transitionMode ? rawNodes[0].child.$slots.default : rawNodes;
        },
        computeIndexes: function computeIndexes() {
          var _this4 = this;

          this.$nextTick(function () {
            _this4.visibleIndexes = _computeIndexes(_this4.getChildrenNodes(), _this4.rootContainer.children, _this4.transitionMode);
          });
        },
        getUnderlyingVm: function getUnderlyingVm(htmlElt) {
          var index = computeVmIndex(this.getChildrenNodes() || [], htmlElt);
          if (index === -1) {
            //Edge case during move callback: related element might be
            //an element different from collection
            return null;
          }
          var element = this.realList[index];
          return { index: index, element: element };
        },
        getUnderlyingPotencialDraggableComponent: function getUnderlyingPotencialDraggableComponent(_ref) {
          var __vue__ = _ref.__vue__;

          if (!__vue__ || !__vue__.$options || __vue__.$options._componentTag !== "transition-group") {
            return __vue__;
          }
          return __vue__.$parent;
        },
        emitChanges: function emitChanges(evt) {
          var _this5 = this;

          this.$nextTick(function () {
            _this5.$emit('change', evt);
          });
        },
        alterList: function alterList(onList) {
          if (!!this.list) {
            onList(this.list);
          } else {
            var newList = [].concat(_toConsumableArray(this.value));
            onList(newList);
            this.$emit('input', newList);
          }
        },
        spliceList: function spliceList() {
          var _arguments = arguments;

          var spliceList = function spliceList(list) {
            return list.splice.apply(list, _arguments);
          };
          this.alterList(spliceList);
        },
        updatePosition: function updatePosition(oldIndex, newIndex) {
          var updatePosition = function updatePosition(list) {
            return list.splice(newIndex, 0, list.splice(oldIndex, 1)[0]);
          };
          this.alterList(updatePosition);
        },
        getRelatedContextFromMoveEvent: function getRelatedContextFromMoveEvent(_ref2) {
          var to = _ref2.to,
              related = _ref2.related;

          var component = this.getUnderlyingPotencialDraggableComponent(to);
          if (!component) {
            return { component: component };
          }
          var list = component.realList;
          var context = { list: list, component: component };
          if (to !== related && list && component.getUnderlyingVm) {
            var destination = component.getUnderlyingVm(related);
            if (destination) {
              return _extends(destination, context);
            }
          }

          return context;
        },
        getVmIndex: function getVmIndex(domIndex) {
          var indexes = this.visibleIndexes;
          var numberIndexes = indexes.length;
          return domIndex > numberIndexes - 1 ? numberIndexes : indexes[domIndex];
        },
        getComponent: function getComponent() {
          return this.$slots.default[0].componentInstance;
        },
        resetTransitionData: function resetTransitionData(index) {
          if (!this.noTransitionOnDrag || !this.transitionMode) {
            return;
          }
          var nodes = this.getChildrenNodes();
          nodes[index].data = null;
          var transitionContainer = this.getComponent();
          transitionContainer.children = [];
          transitionContainer.kept = undefined;
        },
        onDragStart: function onDragStart(evt) {
          this.context = this.getUnderlyingVm(evt.item);
          evt.item._underlying_vm_ = this.clone(this.context.element);
          draggingElement = evt.item;
        },
        onDragAdd: function onDragAdd(evt) {
          var element = evt.item._underlying_vm_;
          if (element === undefined) {
            return;
          }
          removeNode(evt.item);
          var newIndex = this.getVmIndex(evt.newIndex);
          this.spliceList(newIndex, 0, element);
          this.computeIndexes();
          var added = { element: element, newIndex: newIndex };
          this.emitChanges({ added: added });
        },
        onDragRemove: function onDragRemove(evt) {
          insertNodeAt(this.rootContainer, evt.item, evt.oldIndex);
          if (this.isCloning) {
            removeNode(evt.clone);
            return;
          }
          var oldIndex = this.context.index;
          this.spliceList(oldIndex, 1);
          var removed = { element: this.context.element, oldIndex: oldIndex };
          this.resetTransitionData(oldIndex);
          this.emitChanges({ removed: removed });
        },
        onDragUpdate: function onDragUpdate(evt) {
          removeNode(evt.item);
          insertNodeAt(evt.from, evt.item, evt.oldIndex);
          var oldIndex = this.context.index;
          var newIndex = this.getVmIndex(evt.newIndex);
          this.updatePosition(oldIndex, newIndex);
          var moved = { element: this.context.element, oldIndex: oldIndex, newIndex: newIndex };
          this.emitChanges({ moved: moved });
        },
        computeFutureIndex: function computeFutureIndex(relatedContext, evt) {
          if (!relatedContext.element) {
            return 0;
          }
          var domChildren = [].concat(_toConsumableArray(evt.to.children)).filter(function (el) {
            return el.style['display'] !== 'none';
          });
          var currentDOMIndex = domChildren.indexOf(evt.related);
          var currentIndex = relatedContext.component.getVmIndex(currentDOMIndex);
          var draggedInList = domChildren.indexOf(draggingElement) != -1;
          return draggedInList || !evt.willInsertAfter ? currentIndex : currentIndex + 1;
        },
        onDragMove: function onDragMove(evt, originalEvent) {
          var onMove = this.move;
          if (!onMove || !this.realList) {
            return true;
          }

          var relatedContext = this.getRelatedContextFromMoveEvent(evt);
          var draggedContext = this.context;
          var futureIndex = this.computeFutureIndex(relatedContext, evt);
          _extends(draggedContext, { futureIndex: futureIndex });
          _extends(evt, { relatedContext: relatedContext, draggedContext: draggedContext });
          return onMove(evt, originalEvent);
        },
        onDragEnd: function onDragEnd(evt) {
          this.computeIndexes();
          draggingElement = null;
        }
      }
    };
    return draggableComponent;
  }

  if (true) {
    var Sortable = __webpack_require__("./node_modules/sortablejs/Sortable.js");
    module.exports = buildDraggable(Sortable);
  } else if (typeof define == "function" && define.amd) {
    define(['sortablejs'], function (Sortable) {
      return buildDraggable(Sortable);
    });
  } else if (window && window.Vue && window.Sortable) {
    var draggable = buildDraggable(window.Sortable);
    Vue.component('draggable', draggable);
  }
})();

/***/ }),

/***/ "./resources/assets/js/app.js":
/***/ (function(module, exports, __webpack_require__) {


/*
 |--------------------------------------------------------------------------
 | Laravel Spark Bootstrap
 |--------------------------------------------------------------------------
 |
 | First, we will load all of the "core" dependencies for Spark which are
 | libraries such as Vue and jQuery. This also loads the Spark helpers
 | for things such as HTTP calls, forms, and form validation errors.
 |
 | Next, we'll create the root Vue application for Spark. This will start
 | the entire application and attach it to the DOM. Of course, you may
 | customize this script as you desire and load your own components.
 |
 */

__webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"spark-bootstrap\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));
__webpack_require__("./resources/assets/js/components/bootstrap.js");
__webpack_require__("./resources/assets/js/components/TableDraggable.vue"); // This is the key!

Vue.component('table-draggable', __webpack_require__("./resources/assets/js/components/TableDraggable.vue"));

var app = new Vue({
  mixins: [__webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"spark\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()))],
  el: '#spark-app'
});

/***/ }),

/***/ "./resources/assets/js/components/TableDraggable.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/TableDraggable.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-121447d6\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/TableDraggable.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/TableDraggable.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-121447d6", Component.options)
  } else {
    hotAPI.reload("data-v-121447d6", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/js/components/bootstrap.js":
/***/ (function(module, exports, __webpack_require__) {


/*
 |--------------------------------------------------------------------------
 | Laravel Spark Components
 |--------------------------------------------------------------------------
 |
 | Here we will load the Spark components which makes up the core client
 | application. This is also a convenient spot for you to load all of
 | your components that you write while building your applications.
 */

__webpack_require__("./resources/assets/js/spark-components/bootstrap.js");

__webpack_require__("./resources/assets/js/components/home.js");

/***/ }),

/***/ "./resources/assets/js/components/home.js":
/***/ (function(module, exports) {

Vue.component('home', {
    props: ['user'],

    mounted: function mounted() {
        //
    }
});

/***/ }),

/***/ "./resources/assets/js/spark-components/auth/register-braintree.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"auth/register-braintree\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-register-braintree', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/auth/register-stripe.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"auth/register-stripe\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-register-stripe', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/bootstrap.js":
/***/ (function(module, exports, __webpack_require__) {


/**
 * Layout Components...
 */
__webpack_require__("./resources/assets/js/spark-components/navbar/navbar.js");
__webpack_require__("./resources/assets/js/spark-components/notifications/notifications.js");

/**
 * Authentication Components...
 */
__webpack_require__("./resources/assets/js/spark-components/auth/register-stripe.js");
__webpack_require__("./resources/assets/js/spark-components/auth/register-braintree.js");

/**
 * Settings Component...
 */
__webpack_require__("./resources/assets/js/spark-components/settings/settings.js");

/**
 * Profile Settings Components...
 */
__webpack_require__("./resources/assets/js/spark-components/settings/profile.js");
__webpack_require__("./resources/assets/js/spark-components/settings/profile/update-profile-photo.js");
__webpack_require__("./resources/assets/js/spark-components/settings/profile/update-contact-information.js");

/**
 * Teams Settings Components...
 */
__webpack_require__("./resources/assets/js/spark-components/settings/teams.js");
__webpack_require__("./resources/assets/js/spark-components/settings/teams/create-team.js");
__webpack_require__("./resources/assets/js/spark-components/settings/teams/pending-invitations.js");
__webpack_require__("./resources/assets/js/spark-components/settings/teams/current-teams.js");
__webpack_require__("./resources/assets/js/spark-components/settings/teams/team-settings.js");
__webpack_require__("./resources/assets/js/spark-components/settings/teams/team-profile.js");
__webpack_require__("./resources/assets/js/spark-components/settings/teams/update-team-photo.js");
__webpack_require__("./resources/assets/js/spark-components/settings/teams/update-team-name.js");
__webpack_require__("./resources/assets/js/spark-components/settings/teams/team-membership.js");
__webpack_require__("./resources/assets/js/spark-components/settings/teams/send-invitation.js");
__webpack_require__("./resources/assets/js/spark-components/settings/teams/mailed-invitations.js");
__webpack_require__("./resources/assets/js/spark-components/settings/teams/team-members.js");

/**
 * Security Settings Components...
 */
__webpack_require__("./resources/assets/js/spark-components/settings/security.js");
__webpack_require__("./resources/assets/js/spark-components/settings/security/update-password.js");
__webpack_require__("./resources/assets/js/spark-components/settings/security/enable-two-factor-auth.js");
__webpack_require__("./resources/assets/js/spark-components/settings/security/disable-two-factor-auth.js");

/**
 * API Settings Components...
 */
__webpack_require__("./resources/assets/js/spark-components/settings/api.js");
__webpack_require__("./resources/assets/js/spark-components/settings/api/create-token.js");
__webpack_require__("./resources/assets/js/spark-components/settings/api/tokens.js");

/**
 * Subscription Settings Components...
 */
__webpack_require__("./resources/assets/js/spark-components/settings/subscription.js");
__webpack_require__("./resources/assets/js/spark-components/settings/subscription/subscribe-stripe.js");
__webpack_require__("./resources/assets/js/spark-components/settings/subscription/subscribe-braintree.js");
__webpack_require__("./resources/assets/js/spark-components/settings/subscription/update-subscription.js");
__webpack_require__("./resources/assets/js/spark-components/settings/subscription/resume-subscription.js");
__webpack_require__("./resources/assets/js/spark-components/settings/subscription/cancel-subscription.js");

/**
 * Payment Method Components...
 */
__webpack_require__("./resources/assets/js/spark-components/settings/payment-method-stripe.js");
__webpack_require__("./resources/assets/js/spark-components/settings/payment-method-braintree.js");
__webpack_require__("./resources/assets/js/spark-components/settings/payment-method/update-vat-id.js");
__webpack_require__("./resources/assets/js/spark-components/settings/payment-method/update-payment-method-stripe.js");
__webpack_require__("./resources/assets/js/spark-components/settings/payment-method/update-payment-method-braintree.js");
__webpack_require__("./resources/assets/js/spark-components/settings/payment-method/redeem-coupon.js");

/**
 * Billing History Components...
 */
__webpack_require__("./resources/assets/js/spark-components/settings/invoices.js");
__webpack_require__("./resources/assets/js/spark-components/settings/invoices/update-extra-billing-information.js");
__webpack_require__("./resources/assets/js/spark-components/settings/invoices/invoice-list.js");

/**
 * Kiosk Components...
 */
__webpack_require__("./resources/assets/js/spark-components/kiosk/kiosk.js");
__webpack_require__("./resources/assets/js/spark-components/kiosk/announcements.js");
__webpack_require__("./resources/assets/js/spark-components/kiosk/metrics.js");
__webpack_require__("./resources/assets/js/spark-components/kiosk/users.js");
__webpack_require__("./resources/assets/js/spark-components/kiosk/profile.js");
__webpack_require__("./resources/assets/js/spark-components/kiosk/add-discount.js");

/***/ }),

/***/ "./resources/assets/js/spark-components/kiosk/add-discount.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"kiosk/add-discount\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-kiosk-add-discount', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/kiosk/announcements.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"kiosk/announcements\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-kiosk-announcements', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/kiosk/kiosk.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"kiosk/kiosk\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-kiosk', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/kiosk/metrics.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"kiosk/metrics\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-kiosk-metrics', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/kiosk/profile.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"kiosk/profile\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-kiosk-profile', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/kiosk/users.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"kiosk/users\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-kiosk-users', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/navbar/navbar.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"navbar/navbar\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-navbar', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/notifications/notifications.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"notifications/notifications\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-notifications', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/api.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/api\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-api', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/api/create-token.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/api/create-token\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-create-token', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/api/tokens.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/api/tokens\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-tokens', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/invoices.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/invoices\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-invoices', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/invoices/invoice-list.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/invoices/invoice-list\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-invoice-list', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/invoices/update-extra-billing-information.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/invoices/update-extra-billing-information\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-update-extra-billing-information', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/payment-method-braintree.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/payment-method-braintree\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-payment-method-braintree', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/payment-method-stripe.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/payment-method-stripe\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-payment-method-stripe', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/payment-method/redeem-coupon.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/payment-method/redeem-coupon\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-redeem-coupon', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/payment-method/update-payment-method-braintree.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/payment-method/update-payment-method-braintree\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-update-payment-method-braintree', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/payment-method/update-payment-method-stripe.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/payment-method/update-payment-method-stripe\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-update-payment-method-stripe', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/payment-method/update-vat-id.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/payment-method/update-vat-id\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-update-vat-id', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/profile.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/profile\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-profile', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/profile/update-contact-information.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/profile/update-contact-information\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-update-contact-information', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/profile/update-profile-photo.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/profile/update-profile-photo\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-update-profile-photo', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/security.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/security\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-security', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/security/disable-two-factor-auth.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/security/disable-two-factor-auth\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-disable-two-factor-auth', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/security/enable-two-factor-auth.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/security/enable-two-factor-auth\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-enable-two-factor-auth', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/security/update-password.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/security/update-password\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-update-password', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/settings.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/settings\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-settings', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/subscription.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/subscription\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-subscription', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/subscription/cancel-subscription.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/subscription/cancel-subscription\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-cancel-subscription', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/subscription/resume-subscription.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/subscription/resume-subscription\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-resume-subscription', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/subscription/subscribe-braintree.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/subscription/subscribe-braintree\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-subscribe-braintree', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/subscription/subscribe-stripe.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/subscription/subscribe-stripe\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-subscribe-stripe', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/subscription/update-subscription.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/subscription/update-subscription\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-update-subscription', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/teams.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/teams\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-teams', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/teams/create-team.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/teams/create-team\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-create-team', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/teams/current-teams.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/teams/current-teams\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-current-teams', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/teams/mailed-invitations.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/teams/mailed-invitations\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-mailed-invitations', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/teams/pending-invitations.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/teams/pending-invitations\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-pending-invitations', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/teams/send-invitation.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/teams/send-invitation\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-send-invitation', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/teams/team-members.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/teams/team-members\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-team-members', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/teams/team-membership.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/teams/team-membership\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-team-membership', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/teams/team-profile.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/teams/team-profile\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-team-profile', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/teams/team-settings.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/teams/team-settings\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-team-settings', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/teams/update-team-name.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/teams/update-team-name\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-update-team-name', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/js/spark-components/settings/teams/update-team-photo.js":
/***/ (function(module, exports, __webpack_require__) {

var base = __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"settings/teams/update-team-photo\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

Vue.component('spark-update-team-photo', {
    mixins: [base]
});

/***/ }),

/***/ "./resources/assets/sass/app-rtl.scss":
/***/ (function(module, exports) {

throw new Error("Module build failed: ModuleBuildError: Module build failed: \n@import \"./../../../vendor/laravel/spark-aurelius/resources/assets/sass/spark\";\n^\n      File to import not found or unreadable: ./../../../vendor/laravel/spark-aurelius/resources/assets/sass/spark.\n      in /home/john/work/onboarding/resources/assets/sass/app.scss (line 59, column 1)\n    at runLoaders (/home/john/work/onboarding/node_modules/webpack/lib/NormalModule.js:195:19)\n    at /home/john/work/onboarding/node_modules/loader-runner/lib/LoaderRunner.js:364:11\n    at /home/john/work/onboarding/node_modules/loader-runner/lib/LoaderRunner.js:230:18\n    at context.callback (/home/john/work/onboarding/node_modules/loader-runner/lib/LoaderRunner.js:111:13)\n    at Object.asyncSassJobQueue.push [as callback] (/home/john/work/onboarding/node_modules/sass-loader/lib/loader.js:55:13)\n    at Object.done [as callback] (/home/john/work/onboarding/node_modules/neo-async/async.js:7974:18)\n    at options.error (/home/john/work/onboarding/node_modules/node-sass/lib/index.js:294:32)");

/***/ }),

/***/ "./resources/assets/sass/app.scss":
/***/ (function(module, exports) {

throw new Error("Module build failed: ModuleBuildError: Module build failed: \n@import \"./../../../vendor/laravel/spark-aurelius/resources/assets/sass/spark\";\n^\n      File to import not found or unreadable: ./../../../vendor/laravel/spark-aurelius/resources/assets/sass/spark.\n      in /home/john/work/onboarding/resources/assets/sass/app.scss (line 59, column 1)\n    at runLoaders (/home/john/work/onboarding/node_modules/webpack/lib/NormalModule.js:195:19)\n    at /home/john/work/onboarding/node_modules/loader-runner/lib/LoaderRunner.js:364:11\n    at /home/john/work/onboarding/node_modules/loader-runner/lib/LoaderRunner.js:230:18\n    at context.callback (/home/john/work/onboarding/node_modules/loader-runner/lib/LoaderRunner.js:111:13)\n    at Object.asyncSassJobQueue.push [as callback] (/home/john/work/onboarding/node_modules/sass-loader/lib/loader.js:55:13)\n    at Object.done [as callback] (/home/john/work/onboarding/node_modules/neo-async/async.js:7974:18)\n    at options.error (/home/john/work/onboarding/node_modules/node-sass/lib/index.js:294:32)");

/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("./resources/assets/js/app.js");
__webpack_require__("./resources/assets/sass/app.scss");
module.exports = __webpack_require__("./resources/assets/sass/app-rtl.scss");


/***/ })

/******/ });