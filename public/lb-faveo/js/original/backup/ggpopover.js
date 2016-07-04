+function ($) {
    'use strict';

    // CSS TRANSITION SUPPORT (Shoutout: http://www.modernizr.com/)
    // ============================================================

    function transitionEnd() {
        var el = document.createElement('gg')

        var transEndEventNames = {
            WebkitTransition: 'webkitTransitionEnd',
            MozTransition: 'transitionend',
            OTransition: 'oTransitionEnd otransitionend',
            transition: 'transitionend'
        }

        for (var name in transEndEventNames) {
            if (el.style[name] !== undefined) {
                return { end: transEndEventNames[name] }
            }
        }

        return false // explicit for ie8 (  ._.)
    }

    // http://blog.alexmaccaw.com/css-transitions
    $.fn.emulateTransitionEnd = function (duration) {
        var called = false
        var $el = this
        $(this).one('ggTransitionEnd', function () { called = true })
        var callback = function () { if (!called) $($el).trigger($.support.transition.end) }
        setTimeout(callback, duration)
        return this
    }

    $(function () {
        $.support.transition = transitionEnd()

        if (!$.support.transition) return

        $.event.special.ggTransitionEnd = {
            bindType: $.support.transition.end,
            delegateType: $.support.transition.end,
            handle: function (e) {
                if ($(e.target).is(this)) return e.handleObj.handler.apply(this, arguments)
            }
        }
    })

}(jQuery);

+function ($) {
    'use strict';

    // GGTOOLTIP PUBLIC CLASS DEFINITION
    // ===============================

    var ggTooltip = function (element, options) {
        this.type =
        this.options =
        this.enabled =
        this.timeout =
        this.hoverState =
        this.$element = null

        this.init('tooltip', element, options)
    }

    ggTooltip.VERSION = '2.0'

    ggTooltip.TRANSITION_DURATION = 150

    ggTooltip.DEFAULTS = {
        animation: true,
        placement: 'top',
        selector: false,
        template: '<div class="ggtooltip" role="tooltip"><div class="arrow-shadow"><div class="arrow"></div></div><div class="tooltip-inner"></div></div>',
        trigger: 'hover focus',
        title: '',
        delay: 0,
        html: false,
        container: false,
        viewport: {
            selector: 'body',
            padding: 0
        },
        backcolor: '#00ffcc',
        textcolor: '#000000',
        bordercolor: '#0066cc'
    }

    ggTooltip.prototype.init = function (type, element, options) {
        this.enabled = true
        this.type = type
        this.$element = $(element)
        this.options = this.getOptions(options)
        this.$viewport = this.options.viewport && $(this.options.viewport.selector || this.options.viewport)

        var triggers = this.options.trigger.split(' ')

        for (var i = triggers.length; i--;) {
            var trigger = triggers[i]

            if (trigger == 'hover focus') {
                this.$element.on('hover focus.' + this.type, this.options.selector, $.proxy(this.toggle, this))
            } else if (trigger != 'manual') {
                var eventIn = trigger == 'hover' ? 'mouseenter' : 'focusin'
                var eventOut = trigger == 'hover' ? 'mouseleave' : 'focusout'

                this.$element.on(eventIn + '.' + this.type, this.options.selector, $.proxy(this.enter, this))
                this.$element.on(eventOut + '.' + this.type, this.options.selector, $.proxy(this.leave, this))
            }
        }

        this.options.selector ?
          (this._options = $.extend({}, this.options, { trigger: 'manual', selector: '' })) :
          this.fixTitle()
    }

    ggTooltip.prototype.getDefaults = function () {
        return ggTooltip.DEFAULTS
    }

    ggTooltip.prototype.getOptions = function (options) {
        options = $.extend({}, this.getDefaults(), this.$element.data(), options)

        if (options.delay && typeof options.delay == 'number') {
            options.delay = {
                show: options.delay,
                hide: options.delay
            }
        }

        return options
    }

    ggTooltip.prototype.getDelegateOptions = function () {
        var options = {}
        var defaults = this.getDefaults()

        this._options && $.each(this._options, function (key, value) {
            if (defaults[key] != value) options[key] = value
        })

        return options
    }

    ggTooltip.prototype.enter = function (obj) {
        var self = obj instanceof this.constructor ?
            obj : $(obj.currentTarget).data('gg.' + this.type)

        if (self && self.$tip && self.$tip.is(':visible')) {
            self.hoverState = 'in'
            return
        }

        if (!self) {
            self = new this.constructor(obj.currentTarget, this.getDelegateOptions())
            $(obj.currentTarget).data('gg.' + this.type, self)
        }

        clearTimeout(self.timeout)

        self.hoverState = 'in'

        if (!self.options.delay || !self.options.delay.show) return self.show()

        self.timeout = setTimeout(function () {
            if (self.hoverState == 'in') self.show()
        }, self.options.delay.show)
    }

    ggTooltip.prototype.leave = function (obj) {
        var self = obj instanceof this.constructor ?
            obj : $(obj.currentTarget).data('gg.' + this.type)

        if (!self) {
            self = new this.constructor(obj.currentTarget, this.getDelegateOptions())
            $(obj.currentTarget).data('gg.' + this.type, self)
        }

        clearTimeout(self.timeout)

        self.hoverState = 'out'

        if (!self.options.delay || !self.options.delay.hide) return self.hide()

        self.timeout = setTimeout(function () {
            if (self.hoverState == 'out') self.hide()
        }, self.options.delay.hide)
    }

    ggTooltip.prototype.show = function () {
        var e = $.Event('show.gg.' + this.type)

        if (this.hasContent() && this.enabled) {
            this.$element.trigger(e)

            var inDom = $.contains(this.$element[0].ownerDocument.documentElement, this.$element[0])
            if (e.isDefaultPrevented() || !inDom) return
            var that = this

            var $tip = this.tip()

            var tipId = this.getUID(this.type)

            this.setContent()
            $tip.attr('id', tipId)
            this.$element.attr('aria-describedby', tipId)

            if (this.options.animation) $tip.addClass('fade')

            var placement = typeof this.options.placement == 'function' ?
              this.options.placement.call(this, $tip[0], this.$element[0]) :
              this.options.placement

            var autoToken = /\s?auto?\s?/i
            var autoPlace = autoToken.test(placement)
            if (autoPlace) placement = placement.replace(autoToken, '') || 'top'

            $tip
              .detach()
              .css({ top: 0, left: 0, display: 'block' })
              .addClass(placement)
              .data('gg.' + this.type, this)

            this.options.container ? $tip.appendTo(this.options.container) : $tip.insertAfter(this.$element)

            var pos = this.getPosition()
            var actualWidth = $tip[0].offsetWidth
            var actualHeight = $tip[0].offsetHeight

            if (autoPlace) {
                var orgPlacement = placement
                var $container = this.options.container ? $(this.options.container) : this.$element.parent()
                var containerDim = this.getPosition($container)

                placement = placement == 'bottom' && pos.bottom + actualHeight > containerDim.bottom ? 'top' :
                            placement == 'top' && pos.top - actualHeight < containerDim.top ? 'bottom' :
                            placement == 'right' && pos.right + actualWidth > containerDim.width ? 'left' :
                            placement == 'left' && pos.left - actualWidth < containerDim.left ? 'right' :
                            placement

                $tip
                  .removeClass(orgPlacement)
                  .addClass(placement)
            }

            var calculatedOffset = this.getCalculatedOffset(placement, pos, actualWidth, actualHeight)

            this.applyPlacement(calculatedOffset, placement)

            var complete = function () {
                var prevHoverState = that.hoverState
                that.$element.trigger('shown.gg.' + that.type)
                that.hoverState = null

                if (prevHoverState == 'out') that.leave(that)
            }

            $.support.transition && this.$tip.hasClass('fade') ?
              $tip
                .one('ggTransitionEnd', complete)
                .emulateTransitionEnd(ggTooltip.TRANSITION_DURATION) :
              complete()
        }
    }

    ggTooltip.prototype.applyPlacement = function (offset, placement) {
        var $tip = this.tip()
        var width = $tip[0].offsetWidth
        var height = $tip[0].offsetHeight

        // manually read margins because getBoundingClientRect includes difference
        var marginTop = parseInt($tip.css('margin-top'), 10)
        var marginLeft = parseInt($tip.css('margin-left'), 10)

        // we must check for NaN for ie 8/9
        if (isNaN(marginTop)) marginTop = 0
        if (isNaN(marginLeft)) marginLeft = 0

        offset.top = offset.top + marginTop
        offset.left = offset.left + marginLeft

        // $.fn.offset doesn't round pixel values
        // so we use setOffset directly with our own function B-0
        $.offset.setOffset($tip[0], $.extend({
            using: function (props) {
                $tip.css({
                    top: Math.round(props.top),
                    left: Math.round(props.left)
                })
            }
        }, offset), 0)

        $tip.addClass('in')

        // check to see if placing tip in new offset caused the tip to resize itself
        var actualWidth = $tip[0].offsetWidth
        var actualHeight = $tip[0].offsetHeight

        if (placement == 'top' && actualHeight != height) {
            offset.top = offset.top + height - actualHeight
        }

        var delta = this.getViewportAdjustedDelta(placement, offset, actualWidth, actualHeight)

        if (delta.left) offset.left += delta.left
        else offset.top += delta.top

        var isVertical = /top|bottom/.test(placement)
        var arrowDelta = isVertical ? delta.left * 2 - width + actualWidth : delta.top * 2 - height + actualHeight
        var arrowOffsetPosition = isVertical ? 'offsetWidth' : 'offsetHeight'

        $tip.offset(offset)
        this.replaceArrow(arrowDelta, $tip[0][arrowOffsetPosition], isVertical)
        this.setStyles(placement)
    }

    ggTooltip.prototype.replaceArrow = function (delta, dimension, isHorizontal) {
        if (delta > 0) {
            this.arrow()
              .css(isHorizontal ? 'left' : 'top', 50 * (1 - delta / dimension) + '%')
              .css(isHorizontal ? 'top' : 'left', '')

            this.arrowShadow()
              .css(isHorizontal ? 'left' : 'top', 50 * (1 - delta / dimension) + '%')
              .css(isHorizontal ? 'top' : 'left', '')
        }
    }

    ggTooltip.prototype.setContent = function () {
        var $tip = this.tip()
        var title = this.getTitle()

        $tip.find('.tooltip-inner')[this.options.html ? 'html' : 'text'](title)
        $tip.removeClass('fade in top bottom left right')
    }

    ggTooltip.prototype.setStyles = function (placement) {
        var $tip = this.tip()

        $tip.find('.tooltip-inner').css({ 'background': this.options.backcolor, 'color': this.options.textcolor, 'border-color': this.options.bordercolor });
        $tip.find('.arrow').css('border-' + placement + '-color', this.options.backcolor);
        $tip.find('.arrow-shadow').css('border-' + placement + '-color', this.options.bordercolor);
    }

    ggTooltip.prototype.hide = function (callback) {
        var that = this
        var $tip = this.tip()
        var e = $.Event('hide.gg.' + this.type)

        function complete() {
            if (that.hoverState != 'in') $tip.detach()
            that.$element
              .removeAttr('aria-describedby')
              .trigger('hidden.gg.' + that.type)
            callback && callback()
        }

        this.$element.trigger(e)

        if (e.isDefaultPrevented()) return

        $tip.removeClass('in')

        $.support.transition && this.$tip.hasClass('fade') ?
          $tip
            .one('ggTransitionEnd', complete)
            .emulateTransitionEnd(ggTooltip.TRANSITION_DURATION) :
          complete()

        this.hoverState = null

        return this
    }

    ggTooltip.prototype.fixTitle = function () {
        var $e = this.$element
        if ($e.attr('title') || typeof ($e.attr('data-original-title')) != 'string') {
            $e.attr('data-original-title', $e.attr('title') || '').attr('title', '')
        }
    }

    ggTooltip.prototype.hasContent = function () {
        return this.getTitle()
    }

    ggTooltip.prototype.getPosition = function ($element) {
        $element = $element || this.$element

        var el = $element[0]
        var isBody = el.tagName == 'BODY'

        var elRect = el.getBoundingClientRect()
        if (elRect.width == null) {
            // width and height are missing in IE8, so compute them manually; see https://github.com/twbs/bootstrap/issues/14093
            elRect = $.extend({}, elRect, { width: elRect.right - elRect.left, height: elRect.bottom - elRect.top })
        }
        var elOffset = isBody ? { top: 0, left: 0 } : $element.offset()
        var scroll = { scroll: isBody ? document.documentElement.scrollTop || document.body.scrollTop : $element.scrollTop() }
        var outerDims = isBody ? { width: $(window).width(), height: $(window).height() } : null

        return $.extend({}, elRect, scroll, outerDims, elOffset)
    }

    ggTooltip.prototype.getCalculatedOffset = function (placement, pos, actualWidth, actualHeight) {
        return placement == 'bottom' ? { top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2 } :
               placement == 'top' ? { top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2 } :
               placement == 'left' ? { top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth } :
            /* placement == 'right' */ { top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width }

    }

    ggTooltip.prototype.getViewportAdjustedDelta = function (placement, pos, actualWidth, actualHeight) {
        var delta = { top: 0, left: 0 }
        if (!this.$viewport) return delta

        var viewportPadding = this.options.viewport && this.options.viewport.padding || 0
        var viewportDimensions = this.getPosition(this.$viewport)

        if (/right|left/.test(placement)) {
            var topEdgeOffset = pos.top - viewportPadding - viewportDimensions.scroll
            var bottomEdgeOffset = pos.top + viewportPadding - viewportDimensions.scroll + actualHeight
            if (topEdgeOffset < viewportDimensions.top) { // top overflow
                delta.top = viewportDimensions.top - topEdgeOffset
            } else if (bottomEdgeOffset > viewportDimensions.top + viewportDimensions.height) { // bottom overflow
                delta.top = viewportDimensions.top + viewportDimensions.height - bottomEdgeOffset
            }
        } else {
            var leftEdgeOffset = pos.left - viewportPadding
            var rightEdgeOffset = pos.left + viewportPadding + actualWidth
            if (leftEdgeOffset < viewportDimensions.left) { // left overflow
                delta.left = viewportDimensions.left - leftEdgeOffset
            } else if (rightEdgeOffset > viewportDimensions.width) { // right overflow
                delta.left = viewportDimensions.left + viewportDimensions.width - rightEdgeOffset
            }
        }

        return delta
    }

    ggTooltip.prototype.getTitle = function () {
        var title
        var $e = this.$element
        var o = this.options

        title = $e.attr('data-original-title')
          || (typeof o.title == 'function' ? o.title.call($e[0]) : o.title)

        return title
    }

    ggTooltip.prototype.getUID = function (prefix) {
        do prefix += ~~(Math.random() * 1000000)
        while (document.getElementById(prefix))
        return prefix
    }

    ggTooltip.prototype.tip = function () {
        return (this.$tip = this.$tip || $(this.options.template))
    }

    ggTooltip.prototype.arrow = function () {
        return (this.$arrow = this.$arrow || this.tip().find('.arrow'))
    }

    ggTooltip.prototype.arrowShadow = function () {
        return (this.$arrowShadow = this.$arrowShadow || this.tip().find('.arrow-shadow'))
    }

    ggTooltip.prototype.enable = function () {
        this.enabled = true
    }

    ggTooltip.prototype.disable = function () {
        this.enabled = false
    }

    ggTooltip.prototype.toggleEnabled = function () {
        this.enabled = !this.enabled
    }

    ggTooltip.prototype.toggle = function (e) {
        var self = this
        if (e) {
            self = $(e.currentTarget).data('gg.' + this.type)
            if (!self) {
                self = new this.constructor(e.currentTarget, this.getDelegateOptions())
                $(e.currentTarget).data('gg.' + this.type, self)
            }
        }

        self.tip().hasClass('in') ? self.leave(self) : self.enter(self)
    }

    ggTooltip.prototype.destroy = function () {
        var that = this
        clearTimeout(this.timeout)
        this.hide(function () {
            that.$element.off('.' + that.type).removeData('gg.' + that.type)
        })
    }


    // GGTOOLTIP PLUGIN DEFINITION
    // =========================

    function Plugin(option) {
        return this.each(function () {
            var $this = $(this)
            var data = $this.data('gg.tooltip')
            var options = typeof option == 'object' && option

            if (!data && option == 'destroy') return
            if (!data) $this.data('gg.tooltip', (data = new ggTooltip(this, options)))
            if (typeof option == 'string') data[option]()
        })
    }

    var old = $.fn.ggtooltip

    $.fn.ggtooltip = Plugin
    $.fn.ggtooltip.Constructor = ggTooltip


    // GGTOOLTIP NO CONFLICT
    // ===================

    $.fn.ggtooltip.noConflict = function () {
        $.fn.ggtooltip = old
        return this
    }

}(jQuery);

+function ($) {
  'use strict';

  // GGPOPOVER PUBLIC CLASS DEFINITION
  // ===============================

  var ggPopover = function (element, options) {
    this.init('popover', element, options)
  }

  if (!$.fn.ggtooltip) throw new Error('ggPopover requires ggtooltip.js')

  ggPopover.VERSION  = '1.0'

  ggPopover.DEFAULTS = $.extend({}, $.fn.ggtooltip.Constructor.DEFAULTS, {
      placement: 'right',
      trigger: 'hover focus',
      content: '',
      template: '<div class="ggpopover" role="tooltip"><div class="arrow"><div class="after"></div></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
      titleBackcolor: '#f7f7f7',
      titleBordercolor: '#ebebeb',
      titleTextcolor: '#000000',
      contentBackcolor: '#ffffff',
      contentTextcolor: '#000000',
      bordercolor: '#cccccc',
      arrowcolor: '#ffffff'
  })


  // NOTE: GGPOPOVER EXTENDS ggtooltip.js
  // ================================

  ggPopover.prototype = $.extend({}, $.fn.ggtooltip.Constructor.prototype)

  ggPopover.prototype.constructor = ggPopover

  ggPopover.prototype.getDefaults = function () {
    return ggPopover.DEFAULTS
  }

  ggPopover.prototype.setContent = function () {
    var $tip    = this.tip()
    var title   = this.getTitle()
    var content = this.getContent()

    $tip.find('.popover-title')[this.options.html ? 'html' : 'text'](title)
    $tip.find('.popover-content').children().detach().end()[ // we use append for html objects to maintain js events
      this.options.html ? (typeof content == 'string' ? 'html' : 'append') : 'text'
    ](content)

    $tip.removeClass('fade top bottom left right in')

    // IE8 doesn't accept hiding via the `:empty` pseudo selector, we have to do
    // this manually by checking the contents.
    if (!$tip.find('.popover-title').html()) $tip.find('.popover-title').hide()
  }

  ggPopover.prototype.setStyles = function (placement) {
      var $tip = this.tip()
      var title = this.getTitle()

      $tip.find('.popover-title').css({ 'background-color': this.options.titleBackcolor, 'color': this.options.titleTextcolor, 'border-bottom-color': this.options.titleBordercolor });
      $tip.find('.popover-content').css({ 'background-color': this.options.contentBackcolor, 'color': this.options.contentTextcolor });
      $tip.find('.arrow').css('border-' + placement + '-color', this.options.bordercolor);
      $tip.find('.arrow > .after').css('border-' + placement + '-color', this.options.arrowcolor);
      $tip.css({ 'border-color': this.options.bordercolor });
      
  }

  ggPopover.prototype.hasContent = function () {
    return this.getTitle() || this.getContent()
  }

  ggPopover.prototype.getContent = function () {
    var $e = this.$element
    var o  = this.options

    return $e.attr('data-content')
      || (typeof o.content == 'function' ?
            o.content.call($e[0]) :
            o.content)
  }

  ggPopover.prototype.arrow = function () {
    return (this.$arrow = this.$arrow || this.tip().find('.arrow'))
  }

  ggPopover.prototype.tip = function () {
    if (!this.$tip) this.$tip = $(this.options.template)
    return this.$tip
  }


  // GGPOPOVER PLUGIN DEFINITION
  // =========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('gg.popover')
      var options = typeof option == 'object' && option

      if (!data && option == 'destroy') return
      if (!data) $this.data('gg.popover', (data = new ggPopover(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.ggpopover

  $.fn.ggpopover             = Plugin
  $.fn.ggpopover.Constructor = ggPopover


  // GGPOPOVER NO CONFLICT
  // ===================

  $.fn.ggpopover.noConflict = function () {
    $.fn.ggpopover = old
    return this
  }

}(jQuery);
