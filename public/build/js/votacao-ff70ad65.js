$(".phone_with_ddd").mask("(00) 0000-0000"),$("#retorno").attr("onload",function(){$(".painel_teste").fadeIn(),$("#escurece").fadeIn()}),setTimeout(function(){$(".painel_teste").fadeOut(),$("#escurece").fadeOut()},5e3),$("#fecha").click(function(){$(".painel_teste").fadeOut(),$("#escurece").fadeOut()}),$(".botao").click(function(){$("#loading").fadeIn(),$("#escurece").fadeIn(),$(function(){function t(){o.css({WebkitTransform:"rotate("+s+"deg)"}),o.css({"-moz-transform":"rotate("+s+"deg)"}),e=setTimeout(function(){++s,t()},5)}var e,o=$(".fa-spinner"),s=0;t()}),setTimeout(function(){$("#loading").fadeOut(),$("#escurece").fadeOut()},5e3)}),setTimeout(function(){location.reload()},5e5),+function(t){"use strict";function e(e){return this.each(function(){var s=t(this),i=s.data("bs.toggle"),n="object"==typeof e&&e;i||s.data("bs.toggle",i=new o(this,n)),"string"==typeof e&&i[e]&&i[e]()})}var o=function(e,o){this.$element=t(e),this.options=t.extend({},this.defaults(),o),this.render()};o.VERSION="2.2.0",o.DEFAULTS={on:"On",off:"Off",onstyle:"primary",offstyle:"default",size:"normal",style:"",width:null,height:null},o.prototype.defaults=function(){return{on:this.$element.attr("data-on")||o.DEFAULTS.on,off:this.$element.attr("data-off")||o.DEFAULTS.off,onstyle:this.$element.attr("data-onstyle")||o.DEFAULTS.onstyle,offstyle:this.$element.attr("data-offstyle")||o.DEFAULTS.offstyle,size:this.$element.attr("data-size")||o.DEFAULTS.size,style:this.$element.attr("data-style")||o.DEFAULTS.style,width:this.$element.attr("data-width")||o.DEFAULTS.width,height:this.$element.attr("data-height")||o.DEFAULTS.height}},o.prototype.render=function(){this._onstyle="btn-"+this.options.onstyle,this._offstyle="btn-"+this.options.offstyle;var e="large"===this.options.size?"btn-lg":"small"===this.options.size?"btn-sm":"mini"===this.options.size?"btn-xs":"",o=t('<label class="btn">').html(this.options.on).addClass(this._onstyle+" "+e),s=t('<label class="btn">').html(this.options.off).addClass(this._offstyle+" "+e+" active"),i=t('<span class="toggle-handle btn btn-default">').addClass(e),n=t('<div class="toggle-group">').append(o,s,i),l=t('<div class="toggle btn" data-toggle="toggle">').addClass(this.$element.prop("checked")?this._onstyle:this._offstyle+" off").addClass(e).addClass(this.options.style);this.$element.wrap(l),t.extend(this,{$toggle:this.$element.parent(),$toggleOn:o,$toggleOff:s,$toggleGroup:n}),this.$toggle.append(n);var a=this.options.width||Math.max(o.outerWidth(),s.outerWidth())+i.outerWidth()/2,h=this.options.height||Math.max(o.outerHeight(),s.outerHeight());o.addClass("toggle-on"),s.addClass("toggle-off"),this.$toggle.css({width:a,height:h}),this.options.height&&(o.css("line-height",o.height()+"px"),s.css("line-height",s.height()+"px")),this.update(!0),this.trigger(!0)},o.prototype.toggle=function(){this.$element.prop("checked")?this.off():this.on()},o.prototype.on=function(t){return!this.$element.prop("disabled")&&(this.$toggle.removeClass(this._offstyle+" off").addClass(this._onstyle),this.$element.prop("checked",!0),void(t||this.trigger()))},o.prototype.off=function(t){return!this.$element.prop("disabled")&&(this.$toggle.removeClass(this._onstyle).addClass(this._offstyle+" off"),this.$element.prop("checked",!1),void(t||this.trigger()))},o.prototype.enable=function(){this.$toggle.removeAttr("disabled"),this.$element.prop("disabled",!1)},o.prototype.disable=function(){this.$toggle.attr("disabled","disabled"),this.$element.prop("disabled",!0)},o.prototype.update=function(t){this.$element.prop("disabled")?this.disable():this.enable(),this.$element.prop("checked")?this.on(t):this.off(t)},o.prototype.trigger=function(e){this.$element.off("change.bs.toggle"),e||this.$element.change(),this.$element.on("change.bs.toggle",t.proxy(function(){this.update()},this))},o.prototype.destroy=function(){this.$element.off("change.bs.toggle"),this.$toggleGroup.remove(),this.$element.removeData("bs.toggle"),this.$element.unwrap()};var s=t.fn.bootstrapToggle;t.fn.bootstrapToggle=e,t.fn.bootstrapToggle.Constructor=o,t.fn.toggle.noConflict=function(){return t.fn.bootstrapToggle=s,this},t(function(){t("input[type=checkbox][data-toggle^=toggle]").bootstrapToggle()}),t(document).on("click.bs.toggle","div[data-toggle^=toggle]",function(e){var o=t(this).find("input[type=checkbox]");o.bootstrapToggle("toggle"),e.preventDefault()})}(jQuery);