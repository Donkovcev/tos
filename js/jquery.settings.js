(function ($) {
	var escapeable = /["\\\x00-\x1f\x7f-\x9f]/g, meta = {
		'\b':'\\b',
		'\t':'\\t',
		'\n':'\\n',
		'\f':'\\f',
		'\r':'\\r',
		'"':'\\"',
		'\\':'\\\\'
	};

	$.toJSON = typeof JSON === 'object' && JSON.stringify ? JSON.stringify : function (o) {
		if (o === null) {
			return'null';
		}
		var type = typeof o;
		if (type === 'undefined') {
			return undefined;
		}
		if (type === 'number' || type === 'boolean') {
			return'' + o;
		}
		if (type === 'string') {
			return $.quoteString(o);
		}
		if (type === 'object') {
			if (typeof o.toJSON === 'function') {
				return $.toJSON(o.toJSON());
			}
			if (o.constructor === Date) {
				var month = o.getUTCMonth() + 1, day = o.getUTCDate(), year = o.getUTCFullYear(), hours = o.getUTCHours(), minutes = o.getUTCMinutes(), seconds = o.getUTCSeconds(), milli = o.getUTCMilliseconds();
				if (month < 10) {
					month = '0' + month;
				}
				if (day < 10) {
					day = '0' + day;
				}
				if (hours < 10) {
					hours = '0' + hours;
				}
				if (minutes < 10) {
					minutes = '0' + minutes;
				}
				if (seconds < 10) {
					seconds = '0' + seconds;
				}
				if (milli < 100) {
					milli = '0' + milli;
				}
				if (milli < 10) {
					milli = '0' + milli;
				}
				return'"' + year + '-' + month + '-' + day + 'T' +
					hours + ':' + minutes + ':' + seconds + '.' + milli + 'Z"';
			}
			if (o.constructor === Array) {
				var ret = [];
				for (var i = 0; i < o.length; i++) {
					ret.push($.toJSON(o[i]) || 'null');
				}
				return'[' + ret.join(',') + ']';
			}
			var name, val, pairs = [];
			for (var k in o) {
				type = typeof k;
				if (type === 'number') {
					name = '"' + k + '"';
				} else if (type === 'string') {
					name = $.quoteString(k);
				} else {
					continue;
				}
				type = typeof o[k];
				if (type === 'function' || type === 'undefined') {
					continue;
				}
				val = $.toJSON(o[k]);
				pairs.push(name + ':' + val);
			}
			return'{' + pairs.join(',') + '}';
		}
	};

	$.evalJSON = typeof JSON === 'object' && JSON.parse ? JSON.parse : function (src) {
		return eval('(' + src + ')');
	};

	$.secureEvalJSON = typeof JSON === 'object' && JSON.parse ? JSON.parse : function (src) {
		var filtered = src.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, '');
		if (/^[\],:{}\s]*$/.test(filtered)) {
			return eval('(' + src + ')');
		} else {
			throw new SyntaxError('Error parsing JSON, source is not valid.');
		}
	};

	$.quoteString = function (string) {
		if (string.match(escapeable)) {
			return'"' + string.replace(escapeable, function (a) {
				var c = meta[a];
				if (typeof c === 'string') {
					return c;
				}
				c = a.charCodeAt();
				return'\\u00' + Math.floor(c / 16).toString(16) + (c % 16).toString(16);
			}) + '"';
		}
		return'"' + string + '"';
	};

})(jQuery);

$.fn.stickyfloat = function (options, lockBottom) {
	var $obj = this;
	var parentPaddingTop = parseInt($obj.parent().css('padding-top'));
	var startOffset = $obj.parent().offset().top;
	var opts = $.extend({
		startOffset:startOffset,
		offsetY:parentPaddingTop,
		duration:200,
		lockBottom:true
	}, options);

	$obj.css({
		position:'relative'
	});


	if (opts.lockBottom) {
		var bottomPos = $obj.parent().height() - $obj.height() + parentPaddingTop;
		if (bottomPos < 0)
			bottomPos = 0;
	}

	$(window).scroll(function () {
		$obj.stop();
		var pastStartOffset = $(document).scrollTop() > opts.startOffset;
		var objFartherThanTopPos = $obj.offset().top > startOffset;
		var objBiggerThanWindow = $obj.outerHeight() < $(window).height();

		if ((pastStartOffset || objFartherThanTopPos) && objBiggerThanWindow) {
			var newpos = ($(document).scrollTop() - startOffset + opts.offsetY );
			if (newpos > bottomPos)
				newpos = bottomPos;
			if ($(document).scrollTop() < opts.startOffset)
				newpos = parentPaddingTop;

			$obj.animate({
				top:newpos
			}, opts.duration);
		}
	});
};


$(function () {

	/* FAKE SUBMIT */
	$.fn.fakeSubmit = function (target) {
		$(this).click(function () {
			$(target).trigger('click');
			return false;
		});
	}

	// курс доллара для корзины
	var current_currency_rate = getCurrentCurrencyRate();

	$('#send_comment, #send').fakeSubmit('#adminForm input[type="submit"]:first');
	$('#reg_button').fakeSubmit('input.real_submit');
	/* /FAKE SUBMIT */

	/* Аяксовое обновление фактов на главной странице */
	$('div.facts a.more').click(function () {
		var link = $(this);
		link.prev().find('p').html('');
		/* Это для нормального отображения в опере */
		link.prev().find('p').load("/ajax/?random_fact=" + link.attr('href').replace('#', ''));
		return false;
	});
	/* /Аяксовое обновление фактов на главной странице */

	$('body').addClass('js');

	/* Главное меню */
	$('#nav > li > a').click(function () {
		var target = $(this).parent();
		var child = target.find('> ul');

		$('#nav > li > ul').fadeOut("fast", function () {
			$(this).parent().removeClass('sel_alt');
		});

		if (child.size() > 0) {
			if (child.css('display') == 'none') {
				target.addClass('sel_alt');
				child.stop(true, true).slideDown("fast");
			}
			return false;
		}
	});

	$('body').click(function () {
		$('li.sel_alt').find('ul').fadeOut("fast", function () {
			$(this).parent().removeClass('sel_alt');
		});
	});
	/* /Главное меню */

	/* Аккордион */
	$('.accordion').each(function () {
		$('dt .boxed', this).click(
			function (e) {
				function action(setter) {
					setter.toggleClass('sel').next('dd').toggleClass('sel').slideToggle('medium');
				}

				e.preventDefault();
				action($(this).closest('dt'));
			}).each(function () {
				if (!$(this).children('.ic').length) {
					$(this).append('<span class="ic"></span>');
				}
			});
	});
	/* Цифры для страницы http://tos-invest.com/project/guide/ */
	$('ol.num-list').each(function () {
		var $i = 1;
		var $str;
		var $j;
		$('> li', this).each(function () {
			$j = $i.toString();
			$str = '<span class="ic">';
			for (i = 0; i < $j.length; i++) {
				$str += '<span class="num num-' + $j.charAt(i) + '"></span>';
			}
			$str += '</span>';
			$(this).prepend($str);
			$i++;
		});
	});
	/* /Цифры для страницы http://tos-invest.com/project/guide/ */

	$('.guide').each(function () {
		var $str = '';
		var $all = $('.num-list > li', this).length;
		var $limit = Math.round($all / 2);
		var $item = $('.num-list > li', this);
		for (i = 0; i < $limit; i++) {
			$str += '<div class="block';
			if ((i % 2) == 0)$str += ' light-block';
			$str += '"><div class="col">' + $item.eq(i).html() + '</div>';
			if ((i + $limit) < $all) {
				$str += '<div class="col">' + $item.eq(i + $limit).html() + '</div>';
			}
			$str += '<div class="clear"></div></div>';
		}
		$(this).append($str).find('.num-list').hide();
	});

	$('.pict, .auth-block, .cart-block').live('shadow',
		function () {
			if (!$(this).hasClass('.sh')) {
				$(this).addClass('sh').prepend('<span class="sh-wrapper"><img src="/images/texasonshore/img/sht.png" alt="" class="s t" /><img src="/images/texasonshore/img/shl.png" alt="" class="s l" /><img src="/images/texasonshore/img/shr.png" alt="" class="s r" /><img src="/images/texasonshore/img/shb.png" alt="" class="s b" /></span>');
			}
		}).trigger('shadow');


	/* FORUM ANSWER BUTTON */
	$('div.answers a.answer').click(function () {
		var button = $(this);
		var el = button.parent();
		$('div.answers a.answer').removeClass('active-answer');
		button.addClass('active-answer');
		$('#answer-form').show().css('visibility', 'visible').appendTo(el);
		$('#answer-form input[name="f_parent_id"]').val($('.active-answer').attr('href').replace('#', ''));
		return false;
	});
	/* /FORUM ANSWER BUTTON */
	/* FAQ ANSWER BUTTON */
	$('div.questions a.answer').click(function () {
		var button = $(this);
		var el = button.parent();
		$('div.questions a.answer').removeClass('active-answer');
		button.addClass('active-answer');
		$('div.answerer-form').show().css('visibility', 'visible').appendTo(el);
		$('div.answerer-form input[name="message"]').val($('.active-answer').attr('href').replace('#', ''));
		return false;
	});
	/* /FAQ ANSWER BUTTON */

	/* FORUM EDITOR */
	$('#answer-form').appendTo('div.answers .item:first');
	if (typeof nicEditors != 'undefined')
		nicEditors.allTextAreas('f_Message', '', '/netcat/editors/nc_UserEditor/', '/images/smiles/');
	$('#answer-form').hide();
	$('form#adminForm table tbody tr td > div').eq(1).css('background', '#fff');
	/* /FORUM EDITOR */
	/* UPDATE FORUM CAPTCHA */
	$('a.update-captcha').click(function () {
		$('div.captcha-wrapper').empty().load('/ajax/?captcha');
		return false;
	});
	/* /UPDATE FORUM CAPTCHA */
	/* FORUM TREE */
	$('.answers > .item:even').addClass('even');
	$('.answers > .item:odd').addClass('odd');
	/* FORUM TREE */
	/* PROFILE */
	/* EDIT PROFILE */
	$('div.profile input[name="password"]').val('');
	/* /EDIT PROFILE */
	$('.subscribe-checkboxes input[type="checkbox"]').addClass('checkbox');

	// красивые чекбоксы
	$('table.table_reg label > input[type="checkbox"]').parent().addClass('custom_checkbox_label');
	/* NOT SUBSCRIBED */
	$('.subscribe-checkboxes input.not-subscribed').each(function () {
		var label = $(this).parent();
		var checkbox = label.find('input');
		label.append('<div class="pseudo_checkbox"></div>');

		if ($(this).is(':checked')) {
			$(this).next('div.pseudo_checkbox').addClass('checked');
		} else {
			$(this).next('div.pseudo_checkbox').removeClass('checked');
		}
	});
	$('.subscribe-checkboxes input.not-subscribed').change(function () {
		if ($(this).is(':checked')) {
			$(this).next('div.pseudo_checkbox').addClass('checked');
		} else {
			$(this).next('div.pseudo_checkbox').removeClass('checked');
		}
	});
	/* /NOT SUBSCRIBED */
	/* SUBSCRIBED */
	$('.subscribe-checkboxes input.subscribed').each(function () {
		var label = $(this).parent();
		var checkbox = label.find('input');
		label.append('<div class="pseudo_checkbox"></div>');

		if (!$(this).is(':checked')) {
			$(this).next('div.pseudo_checkbox').addClass('checked');
		} else {
			$(this).next('div.pseudo_checkbox').removeClass('checked');
		}
	});
	$('.subscribe-checkboxes input.subscribed').change(function () {
		if (!$(this).is(':checked')) {
			$(this).next('div.pseudo_checkbox').addClass('checked');
		} else {
			$(this).next('div.pseudo_checkbox').removeClass('checked');
		}
	});
	/* /SUBSCRIBED */

	/* Подписка на проекты */
	$('input[name="new_projects[]"]').change(function () {
		var subscribe = "on";
		if ($(this).is(':checked')) {
			subscribe = "off";
		} else {
			subscribe = "on";
		}
		var data = {
			"project":$(this).val(),
			"subscribe":subscribe
		};
		$.ajax({
			url:'/ajax/',
			type:'POST',
			data:'subscribe=' + $.toJSON(data)
		});
	});
	/* /Подписка на проекты */

	// /красивые чекбоксы

	/* /REPORTS POPUP */
	$('a.reports').click(function (e) {
		var button = $(this);
		$('a.reports').removeClass('opened');
		button.addClass('opened');
		$('div.popup-statistics').hide();
		if ((e.pageX + 370) > $('body').width()) {
			e.pageX = e.pageX - 370;
		}
		button.next().css({
			left:e.pageX + 'px',
			top:e.pageY + 'px'
		}).show();
		var popupoffsetheight = button.next().height() + e.pageY;

		if (popupoffsetheight > $(document).height()) {
			var difference = parseInt(popupoffsetheight - $(document).height());
			var height = $(document).height() + difference + 100;
			$('body').height(height);
		}
		return false;
	});
	$('div.popup-statistics ul.navigation a').click(function () {
		var tab_button = $(this);
		if (!tab_button.parent().is('.inactive')) {
			var hash = tab_button.attr('href').replace('#', '');
			tab_button.parent().addClass('active').siblings().removeClass('active');
			tab_button.parent().parent().parent().parent().find('.' + hash).show().siblings('.tab').hide();
		}
	});
	$('a.popup-close').click(function () {
		var block = $(this).parent().parent().parent();
		var blockParent = block.parent();
		
		
		if (block.is('.popup-statistics')) {
			block.parent().find('.opened').removeClass('opened');
			block.hide();
		} else if (block.is('.sell-form')) {
			$('td.actions a.sell-link').removeClass('opened');
			block.hide();
		} else if (block.is('.buy-form') || blockParent.is('.buy-form')) {
			blockParent.hide();
			$('td.actions a.buy-link').removeClass('opened');
		} else if (block.is('.company-offer')) {
			$('td.actions a.buy-p-link').removeClass('opened');
			block.hide();
		}
		
		$('body').css('height', '100%');
		return false;
	});
	$('div.popup-statistics .tab').each(function () {
		$(this).find('td').each(function (e) {
			$(this).addClass('item-' + (e + 1));
		});
	});
	/* /REPORTS POPUP */


	/* SELL PROJECT POPUP */

	$('td.actions a.sell-link').click(function (e) {
		var link = $(this);
		$('td.actions a.sell-link').removeClass('opened');
		link.addClass('opened');
		var sell_buy_project = link.attr('href').replace('#', '').replace(/(\d+)-\d+/g, '$1');
		max_shares = parseInt(link.parent().parent().find('td.purchased div.quantity-wrapper').html());
		$('div.sell-form input[type="hidden"][name="project"]').val(sell_buy_project);
		$('div.sell-form input[type="hidden"][name="parent"]').val(link.attr('href').replace('#', '').replace(/\d+-(\d+)/g, '$1'));
		$('div.sell-form input[type="hidden"][name="max_shares"]').val(max_shares);

		if ((e.pageX + 170) > $('body').width()) {
			e.pageX = e.pageX - 170;
		}
		$('div.sell-form').css({
			left:e.pageX + 'px',
			top:e.pageY + 'px'
		}).show();
		return false;
	});

	/* /SELL PROJECT POPUP */

	/* BUY PROJECT POPUP */

	$('.buy-form table tr').each(function () {
		$(this).find(' > td').each(function (e) {
			$(this).addClass('item-' + (e + 1));
		});
	});
	$('.buy-form table').each(function () {
		var table = $(this);
		table.find('tr:even').addClass('even');
		table.find('tr:odd').addClass('odd');
	});

	$('a.buy-project-link').click(function () {
		$(this).prev().trigger('click');
		return false;
	});
	$('td.actions a.buy-link').click(function (e) {
		var button = $(this);
		var buyform = button.siblings('div.buy-form');

		$('td.actions a.buy-link').removeClass('opened');
		$('div.buy-form').hide();
		button.addClass('opened');

		if ((e.pageX + 390) > $('body').width()) {
			e.pageX = e.pageX - 390;
		}
		buyform.css({
			left:e.pageX + 'px',
			top:e.pageY + 'px'
		}).show();
		return false;
	});

	/* Одинаковая высота для всех блоков с ценником на странице activity */
	$('.quantity-wrapper').each(function () {
		if (!$(this).parents(6).is('.shopping-cart')) {
			var block = $(this);
			var height = block.parent().height();
			block.css({
				'height':height + 'px',
				'line-height':height + 'px'
			});
		}

	});

	/* /BUY PROJECT POPUP */
	/* SELL SHARES FROM COMPANY OWNER */
	$('td.actions a.buy-p-link').click(function (e) {
		var link1 = $(this);
		var sellform = link1.siblings('.company-offer');
		$('td.actions a.buy-p-link').removeClass('opened');
		link1.addClass('opened');

		$('div.company-offer').hide();

		if ((e.pageX + 170) > $('body').width()) {
			e.pageX = e.pageX - 170;
		}
		sellform.css({
			left:e.pageX + 'px',
			top:e.pageY + 'px'
		}).show();
		return false;
	});

	$('a.submit-link').click(function () {
	
		$(this).parents('form').find('input.check-available').checkAvailableShares();
		$(this).siblings('input.real_submit').trigger('click');
		return false;
	});
	/* /SELL SHARES FROM COMPANY OWNER */


	$.fn.activityTable = function () {
		var table = $(this);
		table.find('> tbody > tr:first').addClass('first-row');
		table.find('> tbody > tr:last').addClass('last-row');
		table.find('tr').each(function () {
			$(this).find('> td:first').addClass('first-column');
			$(this).find('> td:last').addClass('last-column');
		});
	}
	$('div.display-table table, .buy-form table').activityTable();
	$('a.activity-description').click(function () {
		return false;
	});

	/* /PROFILE */

	/* BUY */
	$('.article.project #BuyForm').each(function () {
		$(this).parent().hide().prependTo($(this).parent().parent());
	});
	$('a.button_buy_listener.open_form').click(function () {
		var main_block = $(this).parent().parent().parent().parent().parent().next();
		var price_block = main_block.find('div:first');
		main_block.slideDown('fast');
		price_block.show();
		return false;
	});
	/* OPEN BLOCK BY HASH IN LINK */

	var url = document.URL;
	var anchor = ""; // Эту строку не трогать
	var GET = Array(); // Это пожалуй тоже
	function parseGET(str) {
		str = str.split('?');
		str = str[1];
		if (str) {
			if (str.indexOf('#') != -1) {
				anchor = str.substr(str.indexOf('#') + 1);
				str = str.substr(0, str.indexOf('#'));
			}
			params = str.split('&');
			for (i = 0; i < params.length; i++) {
				var keyval = params[i].split('=');
				GET[keyval[0]] = keyval[1];
			}
		}
		return (GET);
	}

	;
	GET = parseGET(url);


	if (GET['item'] || GET['buy-item']) {
		if (GET['item']) {
			var str = 'item-' + GET['item'];
		}
		else if (GET['buy-item']) {
			var str = 'buy-item-' + GET['item'];
		}
		re = /buy-item-/i;
		re_2 = /item-/i;
		found = str.match(re);
		found_2 = str.match(re_2);
		if (found != null) {
			$('.buy-item-' + GET['buy-item']).trigger('click');
			setTimeout('$(\'.buy-item-\' + GET[\'buy-item\']).parent().next().find(\'a.button_buy_listener\').trigger(\'click\');', 300);
		} else if (found_2 != null) {
			$('.item-' + GET['item']).trigger('click');
		}
	}
	/* /BUY */

	if ($('#floatingbar').length > 0) {
		$('#floatingbar').stickyfloat({
			duration:400
		});
	}


	/* Смена блоков с проектами на главной */
	/*
	$('div.sales-block div[class*="project-"]').hide();
	$('div.sales-block div[class*="project-"]:first').show();
	var totalProjectBlocks = $('div.sales-block div[class*="project-"]').size();
	var currentBlock = 0;

	function sec() {
		if (currentBlock++ == (totalProjectBlocks - 1)) {
			currentBlock = 0;
		}
		$('div.sales-block div[class*="project-"]').hide().eq(currentBlock).show();


	}

	setInterval(sec, 5000); // использовать функцию
	*/
	/* Смена блоков с проектами на главной */


	/* CART */
	/* Показ и скрытие корзины в шапке */
	toggleCart();
	function toggleCart() {
		if ($('div.cart-wrapper .cart').hasClass('full')) {
			$('div.cart-wrapper .cart, div.cart-wrapper .cart .cart-block').hover(function (e) {
					e.preventDefault();
					var link = $('div.cart-wrapper .cart a .meta');
					var linksBlock = link.parent().next();
					/*			if(linksBlock.is('.cart-block:visible')) {
					 link.removeClass('opened');
					 linksBlock.hide();
					 } else if(!linksBlock.is('.cart-block:visible')) {
					 */
					link.addClass('opened');
					linksBlock.show(1);
					cart_open = true;
					/*			}*/
				},
				function (e) {
					e.preventDefault();
					var link = $('div.cart-wrapper .cart a .meta');
					var linksBlock = link.parent().next();
					cart_open = false;
					window.setTimeout(
						function () {
							asdf(link, linksBlock);
						},
						1000
					);
				});
		}
	}

	var cart_open = false;

	function asdf(link, linksBlock) {
		if (cart_open == false) {
			link.removeClass('opened');
			linksBlock.hide(1);
		}
	}

	$('.cart-block a').click(function () {
		location.reload(true);
	});
	/* Проверка количества акций в корзине */
	$('input[name=buy_quantity]').bind('change', function(){
		
		var price = $(this).parent().find('input[type=hidden][name=price]').val();
		$(this).parents('td.purchased').find('.cost p').html(parseInt(price*$(this).val()));
		var sum = 0;
		$.each($('input[type=checkbox][class=purchased-checkbox]:checked'), function(index, el){
			sum += parseInt($(el).parents('td.purchased').find('.cost p').html());
		});
		$('#footer-sum .cost p').html(sum);
	});
	$('.quantity-field .increase, .quantity-field .decrease').click(function () {
		var link = $(this);
		var input = link.parent().find('input[name="buy_quantity"]');
		/* фикс для учета валюты и курса при изменении кол-ва товара в корзине */
		current_currency = link.parent().parent().parent().find('.valute button.currency');
		if (current_currency.hasClass('usd')) {
			var price = link.parent().find('input[name="price"]').val();
		} else if (current_currency.hasClass('rub')) {
			var price = link.parent().find('input[name="price"]').val() * current_currency_rate;//getCurrentCurrencyRate();
		}
		/* конец фикса */
		var available = parseInt(input.parent().parent().parent().parent().find('td.available').text());
		var value = parseInt(input.val());
		if (isNaN(value)) {
			value = 0;
		}
		inp = $(this).parent().parent().parent().find('.purchased-check input');
		if (link.is('.increase')) {
			value++;
			// увеличение общей суммы в корзине
			if (inp.attr('checked') == 'checked') {
				$('#footer-sum .cost p').html(function (index, val) {
					return parseInt(val) + parseInt(price);
				});
			}
		} else if (link.is('.decrease')) {
			value--;
			if (inp.attr('checked') == 'checked') {
				// уменьшение общей суммы в корзине
				$('#footer-sum .cost p').html(function (index, val) {
					// не уменьшать общую сумму в корзине если кол-во товара меньше 1
					if (value >= 1) {
						return parseInt(val) - price;
					}
				});
			}
		}
		if (value < 1) {
			value = 1;
		}
		input.val(value);
		/* Если количество акций, которое хочет купить пользователь больше, чем количество, 
		 указанное в столбце «Avaliable shares», то поле с количеством для покупки должно 
		 выделяться красной рамкой */
		if (value > available) {
			input.parent().css('border-color', 'red');
			input.val(available);
		} else if (value <= available) {
			input.parent().css('border-color', '#9AA19F');
			link.parent().parent().parent().find('.cost p').html(value * price);
		}

		// запись кол-ва товаров в базу
		project = parseInt(link.parent().find('input[name="project_id"]').val());
		order = link.parent().find('input[name="OrderNumber"]').val();
		getAjaxRequest({
			auction_action:'7',
			mw_project_id:project,
			mw_quantity:value,
			mw_order:order
		});
		return false;
	});
	/* /Проверка количества акций в корзине */

	// выделение товара чекбоксом в корзине
	$('.purchased-checkbox').click(function () {
		var cart_id = $(this).parent().parent().parent().parent().find('input[name="cart_id"]').val();
		//var project_id = $(this).parent().parent().parent().parent().find('input[name="project_id"]').val();
		//var order_number = $(this).parent().parent().parent().parent().find('input[name="OrderNumber"]').val();
		var buy_quantity = $(this).parent().parent().parent().parent().find('input[name="buy_quantity"]').val();
		var price = $(this).parent().parent().parent().parent().find('input[name="price"]').val();
		// содержит стоимость товара с учетом валюты
		trueAmountNow = parseInt($(this).parent().parent().parent().parent().find('.cost p').html());
		// пересчет общей стоимости если товар в корзине выделен
		if ($(this).attr('checked') == 'checked') {
			$('#footer-sum div.cost p').html(function (index, value) {
				return parseInt(value) + trueAmountNow;
			});
			$.get('/ajax/', {
				auction_action:'5',
				mw_cart_id:cart_id,

				mw_order:'1'
			}, function (data) {
				AmountNow = $('body').find('input[name="OrderAmount"]').val();
				AmountNow = AmountNow - 1 + 1 + price * buy_quantity
				if (AmountNow < 0) {
					AmountNow = 0;
				}
				$('body').find('input[name="OrderAmount"]').val(AmountNow);

			});
		}
		else {
			$('#footer-sum div.cost p').html(function (index, value) {
				return parseInt(value) - trueAmountNow;
			});
			$.get('/ajax/', {
				auction_action:'5',
				mw_cart_id:cart_id,
				mw_order:'0'
			}, function (data) {
				AmountNow = $('body').find('input[name="OrderAmount"]').val();
				AmountNow = AmountNow - price * buy_quantity
				if (AmountNow < 0) {
					AmountNow = 0;
				}
				$('body').find('input[name="OrderAmount"]').val(AmountNow);
				//$('#footer-sum div.cost p').html(AmountNow)
			});
		}
	});


	// удаление выбранного чекбоксом товара из корзины по коду auction_action = 6
	$('.small-rbutton-del').click(function () {
		$('.purchased-checkbox').each(function () {
			var cart_id = $(this).parent().parent().parent().parent().find('input[name="cart_id"]').val();
			var project_id = $(this).parent().parent().parent().parent().find('input[name="project_id"]').val();
			var order_number = $(this).parent().parent().parent().parent().find('input[name="OrderNumber"]').val();
			var buy_quantity = $(this).parent().parent().parent().parent().find('input[name="buy_quantity"]').val();
			var price = $(this).parent().parent().parent().parent().find('input[name="price"]').val();
			if ($(this).attr('checked') == 'checked') {
				$.get('/ajax/', {
					auction_action:'6',
					mw_cart_id:cart_id,
					mw_project_id:project_id,
					mw_order_number:order_number,
				}, function (data) {
					location.reload();
				});
			}
		});
		return false;
	});

	/* Валидация инпутов, чтобы можно было ввести только числа */
	function validateNumber(event) {
		var key = window.event ? event.keyCode : event.which;
		if (event.keyCode == 8 || event.keyCode == 46 || event.keyCode == 37 || event.keyCode == 39) {
			return true;
		}
		else if (key < 48 || key > 57) {
			return false;
		}
		else return true;
	}

	;
	$('.quantity-field input, div.BuyForm input[name="f_quantity"][type="text"]').keypress(validateNumber);
	/* /Валидация инпутов, чтобы можно было ввести только числа */

	/* Проверка поля с количеством в корзине */
	if ($('div.quantity-field input[name="buy_quantity"]').length > 0) {
		function ckeckQuantity() {
			$('div.quantity-field input[name="buy_quantity"]').each(function () {
				var input = $(this);
				var price = input.next('input[name="price"]');
				var sum = parseInt(input.val()) * parseInt(price.val());
				var OrderAmount = input.parent().parent().parent().next().find('input[type="hidden"][name="OrderAmount"]');

				var cart_id = input.parent().find('input[name="cart_id"]').val();
				var auth = input.parent().find('input[name="auth"]').val(); // Смотрим авторизован пользователь или нет

				//if(parseInt(OrderAmount.val()) != sum) {
				if (auth == 1) {
					$.get('/ajax/', {
						auction_action:'4',
						mw_quantity:input.val(),
						mw_cart_id:cart_id
					}, function (data) {
						input.val(data);
						OrderAmount.val(sum);
					});
				} else {
					OrderAmount.val(sum);
				}
				//}
			});
		}

		//setInterval(ckeckQuantity, 1000);
	}
	/* /Проверка инпута с колличеством в корзине */

	/* Аяксовая покупка акций на странице проектов */
	if ($('div.BuyForm form.form').length > 0) {
		var form; // Форма, которая отдается туда сюда
		var cart = $('div.cart'); // DOM корзины
		var options = {
			beforeSubmit:showRequest,
			success:showResponse
		};
		$('div.BuyForm form.form').ajaxForm(options);
	}

	function showRequest(formData, jqForm, options) {
		form = jqForm;
		return true;
	}

	// вывод сообщения при покупке акций
	function showResponse(responseText, statusText, xhr, $form) {
		var response = "";
		if (responseText.indexOf("Private Office") > 0) {
			response = 'Your shares added to the <a href="/profile/shopping-cart/">cart</a>.';
		} else if (responseText.indexOf("Личный кабинет") > 0) {
			response = 'Ваши акции добавлены в <a href="/profile/shopping-cart/">корзину</a>.';
		} else {
			if (self.location.host == 'tos-invest.com') {
				response = "Error, you may buy only available shares";
			} else {
				response = "Ошибка, вы можете купить только доступное количество акций";
			}
		}
		form.find('td.message_display').html(response);
		$(".cart-wrapper").empty().load("/ .cart", function () {
			toggleCart();
		});
	}

	/* Отображение диалогового окна, если пользователь будучи неавторизованным купил акции, а теперь авторизовался*/
	if ($("div.ui-dialog").length > 0) {
		$("div.ui-dialog").dialog({
			resizable:false,
			height:140,
			modal:true,
			buttons:{
				"Yes":function () {
					$(this).dialog("close");
					window.location = "/profile/shopping-cart/";
				},
				"No, I would like to come back":function () {
					$(this).dialog("close");
					window.location = "/";
				}
			}
		});
	}

	/* /CART */

	$('.gallery .pict').lightBox({
		imageLoading:'/images/texasonshore/img/lightbox-ico-loading.gif',
		imageBtnPrev:'/images/texasonshore/img/lightbox-btn-prev.gif',
		imageBtnNext:'/images/texasonshore/img/lightbox-btn-next.gif',
		imageBtnClose:'/images/texasonshore/img/lightbox-btn-close.png',
		imageBlank:'/images/texasonshore/img/lightbox-blank.gif'
	});


	/* переключение валют в корзине */
	$('button.currency').click(function (e) {
		e.preventDefault();
		$.each($('button.currency'), function (index, value) {
			par = $(value).parent().parent().find('div.cost p');
			if ($(value).hasClass('usd')) {
				$(value).removeClass('usd').addClass('rub');
				par.text(function () {
					return Math.round(par.text().replace(/\s/g, '') * current_currency_rate);
				});
			} else if ($(value).hasClass('rub')) {
				$(value).removeClass('rub').addClass('usd');
				par.text(function () {
					return Math.round(par.text().replace(/\s/g, '') / current_currency_rate);
				});
			}
		});
		// пересчитать общую сумму по текущей валюте
		//changeTotalSum();
		/*el = $(this);
		 par = el.parent().parent().find('div.cost p');
		 if (el.hasClass('usd')){
		 el.removeClass('usd').addClass('rub');
		 par.text(function(){
		 return Math.round(par.text().replace(/\s/g,'') * current_currency_rate);
		 }) ;
		 } else {
		 el.removeClass('rub').addClass('usd');
		 par.text(function(){
		 return Math.round(par.text().replace(/\s/g,'') / current_currency_rate
		 }*/
	});

	/* При клике по кнопке BUY в форме должны быть ограничения по количеству 
	акций для покупки: возможно допустимое значение для покупки не должно 
	превышать количество акций, указанных в поле "Avaliable Shares". Если 
	количество для покупки превышает допустимое количество, то поле 
	выделяется красным */
	$('input.check-available').keyup(function(){
		$(this).checkAvailableShares();
	});
	$('input.check-available-sell').keyup(function(){
		$(this).checkAvailableSellShares();
	});
	$('input[name="buy_quantity"]').keyup(function(){
		$(this).checkAvailableSharesInCart();
	});


	// вывести попап продажи акций с уведомлением
	$('#sell-project-link').click(function(e){
		$(this).parents('form').find('input.check-available-sell').checkAvailableSellShares();
		e.preventDefault();
		dialog = $("#sell-shares-dialog");
		if (getSiteLanguage() == 'ru') {
			dialog.html('Ваш запрос отправлен на обработку. Если цена будет одобрена компанией Taxes Onshore, ваши акции будут активны на рынке и доступны для покупки другим пользователям в течение 24 часов, вам на электронный адрес придет уведомление');
		} else {
			dialog.html('[ENG] Ваш запрос отправлен на обработку. Если цена будет одобрена компанией Taxes Onshore, ваши акции будут активны на рынке и доступны для покупки другим пользователям в течение 24 часов, вам на электронный адрес придет уведомление');
		}
		dialog.dialog({
			resizable: false,
			height: 240,
			modal: true,
			buttons:{
				"Ok":function(){
					$(this).dialog("close");
					// отправка запроса на продажу
					$('#sell-project-submit').trigger('click');
					//$('#sell-project-link').fakeSubmit('#sell-project-submit');
				}
			}
		});
	});

	// отправляет письмо пользователю с прикрепленным файлом проекта
	$('.icon.email').click(function(e){
		e.preventDefault();
		filepath = $(this).parent().parent().find('.icon.save').attr('href');
		file = filepath.replace(/^.*[\\\/]/, '');
		getAjaxRequest({
			auction_action:'12',
			filepath: filepath,
			file: file,
		});
	})

});

// возвращает текущий язык сайт в зависимости от домена
function getSiteLanguage() {
	if (self.location.host == 'tos-invest.com') {
		return 'en';
	}
	if (self.location.host == 'ru.tos-invest.com') {
		return 'ru';
	}
}

// возвращает курс доллара из настроек сайта
function getCurrentCurrencyRate() {
	rate = 1;
	rate = $.ajax({
		type:'POST',
		url:'/ajax/',
		async:false,
		cache:true,
		data:{request:'getCurrencyRate'}
	}).responseText;
	return rate;
}

// обертка для вызова /ajax/
function getAjaxRequest(params) {
	$.get(
		'/ajax/',
		params,
		function (data) {
			console.log(data);
		}
	);
}

// for debug only, then remove
$('#test-action').click(function(e){
	e.preventDefault();
	
})

jQuery.fn.extend({
	// валидация кол-ва покупаемых акций
	checkAvailableShares:function() {
		max = parseInt(this.parent().parent().parent().find('.available-shares').html());
		if (this.val() > max) {
			this.css('border-color', 'red');
			this.val(max);
			this.css('border-color', '#ADB2B0');
		} else {
			this.css('border-color', '#ADB2B0');
		}
	},
	// валидация кол-ва покупаемых акций в корзине
	checkAvailableSharesInCart:function() {
		console.log('ol');
		max = parseInt(this.parent().parent().parent().parent().find('.available').html());
		console.log(max);
		if (this.val() > max) {
			this.css('border-color', 'red');
			this.val(max);
			this.css('border-color', '#ADB2B0');
		} else {
			this.css('border-color', '#ADB2B0');
		}
	},
	// валидация кол-ва продаваемых акций
	checkAvailableSellShares:function() {
		max = parseInt(this.parent().parent().parent().parent().parent().find('input[type="hidden"][name="max_shares"]').val());
		if (this.val() > max) {
			this.val(max);
		}
	}
});