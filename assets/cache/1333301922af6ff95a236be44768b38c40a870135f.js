
!function($){"use strict"
var dismiss='[data-dismiss="alert"]',Alert=function(el){$(el).on('click',dismiss,this.close)}
Alert.prototype={constructor:Alert,close:function(e){var $this=$(this),selector=$this.attr('data-target'),$parent
if(!selector){selector=$this.attr('href')
selector=selector&&selector.replace(/.*(?=#[^\s]*$)/,'')}
$parent=$(selector)
$parent.trigger('close')
e&&e.preventDefault()
$parent.length||($parent=$this.hasClass('alert')?$this:$this.parent())
$parent.trigger('close').removeClass('in')
function removeElement(){$parent.trigger('closed').remove()}
$.support.transition&&$parent.hasClass('fade')?$parent.on($.support.transition.end,removeElement):removeElement()}}
$.fn.alert=function(option){return this.each(function(){var $this=$(this),data=$this.data('alert')
if(!data)$this.data('alert',(data=new Alert(this)))
if(typeof option=='string')data[option].call($this)})}
$.fn.alert.Constructor=Alert
$(function(){$('body').on('click.alert.data-api',dismiss,Alert.prototype.close)})}(window.jQuery);
!function($){"use strict"
var Carousel=function(element,options){this.$element=$(element)
this.options=$.extend({},$.fn.carousel.defaults,options)
this.options.slide&&this.slide(this.options.slide)
this.options.pause=='hover'&&this.$element.on('mouseenter',$.proxy(this.pause,this)).on('mouseleave',$.proxy(this.cycle,this))}
Carousel.prototype={cycle:function(){this.interval=setInterval($.proxy(this.next,this),this.options.interval)
return this},to:function(pos){var $active=this.$element.find('.active'),children=$active.parent().children(),activePos=children.index($active),that=this
if(pos>(children.length-1)||pos<0)return
if(this.sliding){return this.$element.one('slid',function(){that.to(pos)})}
if(activePos==pos){return this.pause().cycle()}
return this.slide(pos>activePos?'next':'prev',$(children[pos]))},pause:function(){clearInterval(this.interval)
this.interval=null
return this},next:function(){if(this.sliding)return
return this.slide('next')},prev:function(){if(this.sliding)return
return this.slide('prev')},slide:function(type,next){var $active=this.$element.find('.active'),$next=next||$active[type](),isCycling=this.interval,direction=type=='next'?'left':'right',fallback=type=='next'?'first':'last',that=this
this.sliding=true
isCycling&&this.pause()
$next=$next.length?$next:this.$element.find('.item')[fallback]()
if($next.hasClass('active'))return
if(!$.support.transition&&this.$element.hasClass('slide')){this.$element.trigger('slide')
$active.removeClass('active')
$next.addClass('active')
this.sliding=false
this.$element.trigger('slid')}else{$next.addClass(type)
$next[0].offsetWidth
$active.addClass(direction)
$next.addClass(direction)
this.$element.trigger('slide')
this.$element.one($.support.transition.end,function(){$next.removeClass([type,direction].join(' ')).addClass('active')
$active.removeClass(['active',direction].join(' '))
that.sliding=false
setTimeout(function(){that.$element.trigger('slid')},0)})}
isCycling&&this.cycle()
return this}}
$.fn.carousel=function(option){return this.each(function(){var $this=$(this),data=$this.data('carousel'),options=typeof option=='object'&&option
if(!data)$this.data('carousel',(data=new Carousel(this,options)))
if(typeof option=='number')data.to(option)
else if(typeof option=='string'||(option=options.slide))data[option]()
else data.cycle()})}
$.fn.carousel.defaults={interval:5000,pause:'hover'}
$.fn.carousel.Constructor=Carousel
$(function(){$('body').on('click.carousel.data-api','[data-slide]',function(e){var $this=$(this),href,$target=$($this.attr('data-target')||(href=$this.attr('href'))&&href.replace(/.*(?=#[^\s]+$)/,'')),options=!$target.data('modal')&&$.extend({},$target.data(),$this.data())
$target.carousel(options)
e.preventDefault()})})}(window.jQuery);

$(function()
{});

var console=console||{log:function(){},warn:function(){},error:function(){}};
