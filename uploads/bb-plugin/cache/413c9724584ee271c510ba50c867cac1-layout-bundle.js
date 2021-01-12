
jQuery(function($){$(function(){$('.fl-node-5b450d91269ef .fl-photo-img').on('mouseenter',function(e){$(this).data('title',$(this).attr('title')).removeAttr('title');}).on('mouseleave',function(e){$(this).attr('title',$(this).data('title')).data('title',null);});});});
(function($){FLBuilderMenu=function(settings){this.nodeClass='.fl-node-'+settings.id;this.wrapperClass=this.nodeClass+' .fl-menu';this.type=settings.type;this.mobileToggle=settings.mobile;this.mobileBelowRow=settings.mobileBelowRow;this.mobileFlyout=settings.mobileFlyout;this.breakPoints=settings.breakPoints;this.mobileBreakpoint=settings.mobileBreakpoint;this.currentBrowserWidth=$(window).width();this._initMenu();$(window).on('resize',$.proxy(function(e){var width=$(window).width();if(width!=this.currentBrowserWidth){this.currentBrowserWidth=width;this._initMenu();this._clickOrHover();}},this));$('body').on('click',$.proxy(function(e){if('undefined'!==typeof FLBuilderConfig){return;}
if($(this.wrapperClass).find('.fl-menu-mobile-toggle').hasClass('fl-active')&&('expanded'!==this.mobileToggle)){$(this.wrapperClass).find('.fl-menu-mobile-toggle').trigger('click');}
$(this.wrapperClass).find('.fl-has-submenu').removeClass('focus');$(this.wrapperClass).find('.fl-has-submenu .sub-menu').removeClass('focus');},this));};FLBuilderMenu.prototype={nodeClass:'',wrapperClass:'',type:'',breakPoints:{},$submenus:null,_isMobile:function(){return this.currentBrowserWidth<=this.breakPoints.small?true:false;},_isMedium:function(){return this.currentBrowserWidth<=this.breakPoints.medium?true:false;},_isMenuToggle:function(){if(('always'==this.mobileBreakpoint||(this._isMobile()&&'mobile'==this.mobileBreakpoint)||(this._isMedium()&&'medium-mobile'==this.mobileBreakpoint))&&($(this.wrapperClass).find('.fl-menu-mobile-toggle').is(':visible')||'expanded'==this.mobileToggle)){return true;}
return false;},_initMenu:function(){this._menuOnFocus();this._submenuOnClick();if($(this.nodeClass).length&&this.type=='horizontal'){this._initMegaMenus();}
if(this._isMenuToggle()||this.type=='accordion'){$(this.wrapperClass).off('mouseenter mouseleave');this._menuOnClick();this._clickOrHover();}else{$(this.wrapperClass).off('click');this._submenuOnRight();this._submenuRowZindexFix();}
if(this.mobileToggle!='expanded'){this._toggleForMobile();}},_menuOnFocus:function(){$(this.nodeClass).off('focus').on('focus','a',$.proxy(function(e){var $menuItem=$(e.target).parents('.menu-item').first(),$parents=$(e.target).parentsUntil(this.wrapperClass);$('.fl-menu .focus').removeClass('focus');$menuItem.addClass('focus')
$parents.addClass('focus')},this)).on('focusout','a',$.proxy(function(e){el=$(e.target).parent()
if(el.is(':last-child')){$(e.target).parentsUntil(this.wrapperClass).removeClass('focus');}},this));},_menuOnClick:function(){$(this.wrapperClass).off().on('click','.fl-has-submenu-container',$.proxy(function(e){var $link=$(e.target).parents('.fl-has-submenu').first(),$subMenu=$link.children('.sub-menu').first(),$href=$link.children('.fl-has-submenu-container').first().find('> a').attr('href'),$subMenuParents=$(e.target).parents('.sub-menu'),$activeParents=$(e.target).parents('.fl-has-submenu.fl-active');if(!$subMenu.is(':visible')||$(e.target).hasClass('fl-menu-toggle')||($subMenu.is(':visible')&&(typeof $href==='undefined'||$href=='#'))){e.preventDefault();}
else{e.stopPropagation();window.location.href=$href;return;}
if($(this.wrapperClass).hasClass('fl-menu-accordion-collapse')){if(!$link.parents('.menu-item').hasClass('fl-active')){$('.menu .fl-active',this.wrapperClass).not($link).removeClass('fl-active');}
else if($link.parents('.menu-item').hasClass('fl-active')&&$link.parent('.sub-menu').length){$('.menu .fl-active',this.wrapperClass).not($link).not($activeParents).removeClass('fl-active');}
$('.sub-menu',this.wrapperClass).not($subMenu).not($subMenuParents).slideUp('normal');}
$subMenu.slideToggle();$link.toggleClass('fl-active');e.stopPropagation();},this));},_submenuOnClick:function(){$(this.wrapperClass+' .sub-menu').off().on('click','a',$.proxy(function(e){if($(e.target).parent().hasClass('focus')){$(e.target).parentsUntil(this.wrapperClass).removeClass('focus');}},this));},_clickOrHover:function(){this.$submenus=this.$submenus||$(this.wrapperClass).find('.sub-menu');var $wrapper=$(this.wrapperClass),$menu=$wrapper.find('.menu');$li=$wrapper.find('.fl-has-submenu');if(this._isMenuToggle()){$li.each(function(el){if(!$(this).hasClass('fl-active')){$(this).find('.sub-menu').fadeOut();}});}else{$li.each(function(el){if(!$(this).hasClass('fl-active')){$(this).find('.sub-menu').css({'display':'','opacity':''});}});}},_submenuOnRight:function(){$(this.wrapperClass).on('mouseenter focus','.fl-has-submenu',$.proxy(function(e){if($(e.currentTarget).find('.sub-menu').length===0){return;}
var $link=$(e.currentTarget),$parent=$link.parent(),$subMenu=$link.find('.sub-menu'),subMenuWidth=$subMenu.width(),subMenuPos=0,bodyWidth=$('body').width();if($link.closest('.fl-menu-submenu-right').length!==0){$link.addClass('fl-menu-submenu-right');}else if($('body').hasClass('rtl')){subMenuPos=$parent.is('.sub-menu')?$parent.offset().left-subMenuWidth:$link.offset().left-$link.width()-subMenuWidth;if(subMenuPos<=0){$link.addClass('fl-menu-submenu-right');}}else{subMenuPos=$parent.is('.sub-menu')?$parent.offset().left+$parent.width()+subMenuWidth:$link.offset().left+$link.width()+subMenuWidth;if(subMenuPos>bodyWidth){$link.addClass('fl-menu-submenu-right');}}},this)).on('mouseleave','.fl-has-submenu',$.proxy(function(e){$(e.currentTarget).removeClass('fl-menu-submenu-right');},this));},_submenuRowZindexFix:function(e){$(this.wrapperClass).on('mouseenter','ul.menu > .fl-has-submenu',$.proxy(function(e){if($(e.currentTarget).find('.sub-menu').length===0){return;}
$(this.nodeClass).closest('.fl-row').find('.fl-row-content').css('z-index','10');},this)).on('mouseleave','ul.menu > .fl-has-submenu',$.proxy(function(e){$(this.nodeClass).closest('.fl-row').find('.fl-row-content').css('z-index','');},this));},_toggleForMobile:function(){var $wrapper=null,$menu=null,self=this;if(this._isMenuToggle()){if(this._isMobileBelowRowEnabled()){this._placeMobileMenuBelowRow();$wrapper=$(this.wrapperClass);$menu=$(this.nodeClass+'-clone');$menu.find('ul.menu').show();}
else{$wrapper=$(this.wrapperClass);$menu=$wrapper.find('.menu');}
if(!$wrapper.find('.fl-menu-mobile-toggle').hasClass('fl-active')&&!self.mobileFlyout){$menu.css({display:'none'});}
if(self.mobileFlyout){this._initFlyoutMenu();}
$wrapper.on('click','.fl-menu-mobile-toggle',function(e){$(this).toggleClass('fl-active');if(self.mobileFlyout){self._toggleFlyoutMenu();}
else{$menu.slideToggle();}
e.stopPropagation();});$menu.on('click','.menu-item > a[href*="#"]:not([href="#"])',function(e){var $href=$(this).attr('href'),$targetID=$href.split('#')[1];if($('body').find('#'+$targetID).length>0){$(this).toggleClass('fl-active');$menu.slideToggle();}});}
else{if(this._isMobileBelowRowEnabled()){this._removeMenuFromBelowRow();}
$wrapper=$(this.wrapperClass),$menu=$wrapper.find('ul.menu');$wrapper.find('.fl-menu-mobile-toggle').removeClass('fl-active');$menu.css({display:''});if(this.mobileFlyout&&$wrapper.find('.fl-menu-mobile-flyout').length>0){$('body').css('margin','');$('.fl-builder-ui-pinned-content-transform').css('transform','');$menu.unwrap();$wrapper.find('.fl-menu-mobile-close').remove();$wrapper.find('.fl-menu-mobile-opacity').remove();}}},_initMegaMenus:function(){var module=$(this.nodeClass),rowContent=module.closest('.fl-row-content'),rowWidth=rowContent.width(),megas=module.find('.mega-menu'),disabled=module.find('.mega-menu-disabled'),isToggle=this._isMenuToggle();if(isToggle){megas.removeClass('mega-menu').addClass('mega-menu-disabled');module.find('li.mega-menu-disabled > ul.sub-menu').css('width','');rowContent.css('position','');}else{disabled.removeClass('mega-menu-disabled').addClass('mega-menu');module.find('li.mega-menu > ul.sub-menu').css('width',rowWidth+'px');rowContent.css('position','relative');}},_isMobileBelowRowEnabled:function(){return this.mobileBelowRow&&$(this.nodeClass).closest('.fl-col').length;},_placeMobileMenuBelowRow:function(){if($(this.nodeClass+'-clone').length){return;}
var module=$(this.nodeClass),clone=module.clone(),col=module.closest('.fl-col');module.find('ul.menu').remove();clone.addClass((this.nodeClass+'-clone').replace('.',''));clone.addClass('fl-menu-mobile-clone');clone.find('.fl-menu-mobile-toggle').remove();col.after(clone);if(module.hasClass('fl-animation')){clone.removeClass('fl-animation');}
this._menuOnClick();},_removeMenuFromBelowRow:function(){if(!$(this.nodeClass+'-clone').length){return;}
var module=$(this.nodeClass),clone=$(this.nodeClass+'-clone'),menu=clone.find('ul.menu');module.find('.fl-menu-mobile-toggle').after(menu);clone.remove();},_initFlyoutMenu:function(){var win=$(window),wrapper=$(this.wrapperClass),menu=wrapper.find('ul.menu'),button=wrapper.find('.fl-menu-mobile-toggle');if(0===wrapper.find('.fl-menu-mobile-flyout').length){menu.wrap('<div class="fl-menu-mobile-flyout"></div>');}
if(0===wrapper.find('.fl-menu-mobile-close').length){close=window.fl_responsive_close||'Close'
wrapper.find('.fl-menu-mobile-flyout').prepend('<button class="fl-menu-mobile-close" aria-label="'+close+'"><i class="fas fa-times" aria-hidden="true"></i></button>');}
if(wrapper.hasClass('fl-menu-responsive-flyout-push-opacity')&&0===wrapper.find('.fl-menu-mobile-opacity').length){wrapper.append('<div class="fl-menu-mobile-opacity"></div>');}
wrapper.find('.fl-menu-mobile-flyout').height(win.height());wrapper.on('click','.fl-menu-mobile-opacity, .fl-menu-mobile-close',function(e){button.trigger('click');e.stopPropagation();});if('undefined'!==typeof FLBuilder){FLBuilder.addHook('restartEditingSession',function(){$('.fl-builder-ui-pinned-content-transform').css('transform','');if(button.hasClass('fl-active')){button.trigger('click');}});}},_toggleFlyoutMenu:function(){var wrapper=$(this.wrapperClass),button=wrapper.find('.fl-menu-mobile-toggle'),wrapFlyout=wrapper.find('.fl-menu-mobile-flyout'),position=wrapper.hasClass('fl-flyout-right')?'right':'left',pushMenu=wrapper.hasClass('fl-menu-responsive-flyout-push')||wrapper.hasClass('fl-menu-responsive-flyout-push-opacity'),opacity=wrapper.find('.fl-menu-mobile-opacity'),marginPos={},posAttr={},fixedPos={},fixedHeader=$('header, header > div');posAttr[position]=button.hasClass('fl-active')?'0px':'';wrapFlyout.css(posAttr);if($('.fl-builder-ui-pinned-content-transform').length>0&&!$('body').hasClass('fl-builder-edit')){$('.fl-builder-ui-pinned-content-transform').css('transform','none');}
if(pushMenu){marginPos['margin-'+position]=button.hasClass('fl-active')?'250px':'0px';$('body').animate(marginPos,200);if(fixedHeader.length>0){fixedPos[position]=button.hasClass('fl-active')?'250px':'0px';fixedHeader.each(function(){if('fixed'==$(this).css('position')){$(this).css({'-webkit-transition':'none','-o-transition':'none','transition':'none'});$(this).animate(fixedPos,200);}});}}
if(opacity.length>0&&button.hasClass('fl-active')){opacity.show();}
else{opacity.hide();}},};})(jQuery);(function($){$(function(){new FLBuilderMenu({id:'5b44e691c863b',type:'horizontal',mobile:'expanded',mobileBelowRow:true,mobileFlyout:false,breakPoints:{medium:1023,small:767},mobileBreakpoint:'mobile'});});})(jQuery);(function($){FLThemeBuilderHeaderLayout={win:null,body:null,header:null,overlay:false,hasAdminBar:false,breakpointWidth:0,init:function()
{var editing=$('html.fl-builder-edit').length,header=$('.fl-builder-content[data-type=header]'),breakpoint=null;if(!editing&&header.length){header.imagesLoaded($.proxy(function(){this.win=$(window);this.body=$('body');this.header=header.eq(0);this.overlay=!!Number(header.attr('data-overlay'));this.hasAdminBar=!!$('body.admin-bar').length;breakpoint=this.header.data('sticky-breakpoint');if(typeof FLBuilderLayoutConfig.breakpoints[breakpoint]!==undefined){this.breakpointWidth=FLBuilderLayoutConfig.breakpoints[breakpoint];}
else{this.breakpointWidth=FLBuilderLayoutConfig.breakpoints.medium;}
if(Number(header.attr('data-sticky'))){this.header.data('original-top',this.header.offset().top);this.win.on('resize',$.throttle(500,$.proxy(this._initSticky,this)));this._initSticky();if(Number(header.attr('data-shrink'))){this.header.data('original-height',this.header.outerHeight());this.win.on('resize',$.throttle(500,$.proxy(this._initShrink,this)));this._initShrink();}}},this));}},_initSticky:function()
{if(this.win.width()>=this.breakpointWidth){this.win.on('scroll.fl-theme-builder-header-sticky',$.proxy(this._doSticky,this));this._doSticky();}else{this.win.off('scroll.fl-theme-builder-header-sticky');this.header.removeClass('fl-theme-builder-header-sticky');this.body.css('padding-top','0');}},_doSticky:function()
{var winTop=this.win.scrollTop(),headerTop=this.header.data('original-top'),hasStickyClass=this.header.hasClass('fl-theme-builder-header-sticky'),hasScrolledClass=this.header.hasClass('fl-theme-builder-header-scrolled');if(this.hasAdminBar){winTop+=32;}
if(winTop>=headerTop){if(!hasStickyClass){this.header.addClass('fl-theme-builder-header-sticky');if(!this.overlay){this.body.css('padding-top',this.header.outerHeight()+'px');}}}
else if(hasStickyClass){this.header.removeClass('fl-theme-builder-header-sticky');this.body.css('padding-top','0');}
if(winTop>headerTop){if(!hasScrolledClass){this.header.addClass('fl-theme-builder-header-scrolled');}}else if(hasScrolledClass){this.header.removeClass('fl-theme-builder-header-scrolled');}},_initShrink:function()
{if(this.win.width()>=this.breakpointWidth){this.win.on('scroll.fl-theme-builder-header-shrink',$.proxy(this._doShrink,this));this._setImageMaxHeight();if(this.win.scrollTop()>0){this._doShrink();}}else{this.body.css('padding-top','0');this.win.off('scroll.fl-theme-builder-header-shrink');this._removeShrink();this._removeImageMaxHeight();}},_doShrink:function()
{var winTop=this.win.scrollTop(),headerTop=this.header.data('original-top'),headerHeight=this.header.data('original-height'),shrinkImageHeight=this.header.data('shrink-image-height'),hasClass=this.header.hasClass('fl-theme-builder-header-shrink');if(this.hasAdminBar){winTop+=32;}
if(winTop>headerTop+headerHeight){if(!hasClass){this.header.addClass('fl-theme-builder-header-shrink');this.header.find('img').css('max-height',shrinkImageHeight);this.header.find('.fl-row-content-wrap').each(function(){var row=$(this);if(parseInt(row.css('padding-bottom'))>5){row.addClass('fl-theme-builder-header-shrink-row-bottom');}
if(parseInt(row.css('padding-top'))>5){row.addClass('fl-theme-builder-header-shrink-row-top');}});this.header.find('.fl-module-content').each(function(){var module=$(this);if(parseInt(module.css('margin-bottom'))>5){module.addClass('fl-theme-builder-header-shrink-module-bottom');}
if(parseInt(module.css('margin-top'))>5){module.addClass('fl-theme-builder-header-shrink-module-top');}});}}else if(hasClass){this.header.find('img').css('max-height','');this._removeShrink();}},_removeShrink:function()
{var rows=this.header.find('.fl-row-content-wrap'),modules=this.header.find('.fl-module-content');rows.removeClass('fl-theme-builder-header-shrink-row-bottom');rows.removeClass('fl-theme-builder-header-shrink-row-top');modules.removeClass('fl-theme-builder-header-shrink-module-bottom');modules.removeClass('fl-theme-builder-header-shrink-module-top');this.header.removeClass('fl-theme-builder-header-shrink');},_setImageMaxHeight:function()
{var head=$('head'),stylesId='fl-header-styles-'+this.header.data('post-id'),styles='',images=this.header.find('.fl-module-content img');if($('#'+stylesId).length){return;}
images.each(function(i){var image=$(this),height=image.height(),node=image.closest('.fl-module').data('node'),className='fl-node-'+node+'-img-'+i;image.addClass(className);styles+='.'+className+' { max-height: '+height+'px }';});if(''!==styles){head.append('<style id="'+stylesId+'">'+styles+'</style>');}},_removeImageMaxHeight:function()
{$('#fl-header-styles-'+this.header.data('post-id')).remove();},};$(function(){FLThemeBuilderHeaderLayout.init();});})(jQuery);
(function($){$(function(){new FLBuilderMenu({id:'5b50e2d7ab2fa',type:'vertical',mobile:'expanded',mobileBelowRow:false,mobileFlyout:false,breakPoints:{medium:1023,small:767},mobileBreakpoint:'mobile'});});})(jQuery);jQuery(function($){$(function(){$('.fl-node-5b50e08f314e1 .fl-photo-img').on('mouseenter',function(e){$(this).data('title',$(this).attr('title')).removeAttr('title');}).on('mouseleave',function(e){$(this).attr('title',$(this).data('title')).data('title',null);});});});