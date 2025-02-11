var myMemberId = null;
var $orderCard = null;
var $customerCard = null;

// 初期処理
$(function(){

	myMemberId = $('#my-member-id').val();
	// 数量情報取得
	getUnitInfo($('.nav-item .active'));

	// タブクリック時のイベント設定
	$('.nav-link').on('click', function() {
		getUnitInfo($(this));
	});

	// 受領ボタンクリックイベント設定
	$('.btn-receipt').on('click', function() {
		receipt();
	});

	// 受注ボタンクリックイベント設定
	$('.btn-order').on('click', function() {
		openOrder();
	});

	// 販売・出荷ボタンクリックイベント設定
	$('.btn-sale').on('click', function() {
		sale();
	});

	// 発注・生産依頼送信ボタンクリックイベント設定
	$('.btn-send').on('click', function() {
		purchash();
	});
});

/**
 * ユニット情報取得
 * @param {*} $tabObj 
 */
function getUnitInfo($tabObj) {
	startLoad();
	// タブのmemberIDを取得
	const memberId = $tabObj.data('member-id');
	// タブのhref属性値を取得
	const panelId = $tabObj.attr('href');
	// URL取得
	const unitInfoUrl = $('#unit-info-url').val();
	// パラメータ設定
	const param = {
		memberId: memberId,
        ts: new Date().getTime()
	};
	$.getJSON(unitInfoUrl, param, function (response) {
		// メンバーのステータス表示
		if (response.unitInfo.status == 'Wait') {
			$(panelId).find('.bg-wait').first().show();
			$(panelId).find('.bg-playing').first().hide();
		} else {
			$(panelId).find('.bg-wait').first().hide();
			$(panelId).find('.bg-playing').first().show();
			if (response.unitInfo.isPlayer){
				controllButtons($(panelId), response.unitInfo.status);
			}
		}
		// 各種数量表示
		dispDeliveryCount($(panelId), response.unitInfo.num_of_received);
		dispInventoryCount($(panelId), response.unitInfo.num_of_inventory, response.unitInfo.num_of_backordered);
		dispShippingCount($(panelId), response.unitInfo.num_of_shipping);
		stopLoad();
	});
}

/**
 * 配送中件数表示
 * @param {*} $panel パネルオブジェクト
 * @param {*} num 配送中件数
 */
function dispDeliveryCount($panel, num) {
	const $delReqCntObj = $panel.find('.delivery-request-count');
	if ($delReqCntObj.length != 0) {
		displayToken($panel.find('.delivery-icons'), num);
		$delReqCntObj.first().text(num);
	}
}

/**
 * 在庫件数表示
 * @param {1} $panel パネルオブジェクト
 * @param {*} numOfInv 在庫件数
 * @param {*} numOfBackOrdered 受注残件数
 */
function dispInventoryCount($panel, numOfInv, numOfBackOrdered) {
	if (numOfBackOrdered != null && numOfBackOrdered > 0) {
		$panel.find('.inventory-icons').find('.token').hide();
	} else {
		displayToken($panel.find('.inventory-icons'), numOfInv);
	}
	$panel.find('.inventory-count').first().text(numOfInv);
	if (numOfBackOrdered != null) {
		$panel.find('.num-backlog-order').first().text(numOfBackOrdered);
	}
}

/**
 * 配送依頼中件数表示
 * @param {*} $panel パネルオブジェクト
 * @param {*} num 配送中件数
 */
function dispShippingCount($panel, num) {
	displayToken($panel.find('.ship-icons'), num);
	$panel.find('.shipping-count').first().text(num);
}

/**
 * トークン表示処理
 * @param {*} $parentElem トークンの親要素
 * @param {*} num 表示数量
 */
function displayToken($parentElem, num) {
	$parentElem.find('.token').hide();
	if (0 < num && num < 10) {
		for (let i = 1; i <= num; i++) {
			$parentElem.find('.single-token-' + i).show();
		}
	} else if (10 <= num && num < 20) {
		$parentElem.find('.ten-token-1').show();
		let roopCnt = num - 10;
		for (let i = 1; i <= roopCnt; i++) {
			$parentElem.find('.single-token-' + (i + 1)).show();
		}
	}  else if (20 <= num) {
		let roopCnt = Math.ceil(num / 10);
		for (let i = 1; i <= roopCnt; i++) {
			$parentElem.find('.ten-token-' + i).show();
		}
	}
}

/**
 * ボタン制御
 * @param {*} $panel 
 * @param {*} status 
 */
function controllButtons($panel, status){
	if (status == "Transport") {
		$panel.find(".btn-receipt").prop("disabled", false);
		$panel.find(".btn-order").prop("disabled", true);
		$panel.find(".btn-sale").prop("disabled", true);
		$panel.find(".btn-send").prop("disabled", true);
	} else if (status == "Order Receive") {
		$panel.find(".btn-receipt").prop("disabled", true);
		$panel.find(".btn-order").prop("disabled", false);
		$panel.find(".btn-sale").prop("disabled", true);
		$panel.find(".btn-send").prop("disabled", true);
	} else if (status == "Order") {
		$panel.find(".btn-receipt").prop("disabled", true);
		$panel.find(".btn-order").prop("disabled", true);
		$panel.find(".btn-sale").prop("disabled", false);
		$panel.find(".btn-send").prop("disabled", true);
	} else if (status == "Send") {
		$panel.find(".btn-receipt").prop("disabled", true);
		$panel.find(".btn-order").prop("disabled", true);
		$panel.find(".btn-sale").prop("disabled", true);
		$panel.find(".btn-send").prop("disabled", false);
	} else {
		$panel.find(".btn-receipt").prop("disabled", true);
		$panel.find(".btn-order").prop("disabled", true);
		$panel.find(".btn-sale").prop("disabled", true);
		$panel.find(".btn-send").prop("disabled", true);
	}
}

/**
 * 受領処理
 */
function receipt() {
	const panelId = $('.nav-item .active').attr('href');
	const $panel = $(panelId);
	// 受領ボタン非活性化
	$panel.find(".btn-receipt").prop("disabled", true);
	// TODO:リクエスト送信
	let response = {
		num_of_received : 4,
		num_of_inventory : 10,
		num_of_added : 2,
	};
	// レスポンス反映
	// TODO:増減アイコンのフェード対応
	dispDeliveryCount($panel, 0);
	if (response.num_of_added > 0) {
		$panel.find('.inventory-icons .up-icon').fadeIn(500).fadeOut(200, function(){
			dispInventoryCount($panel, response.num_of_inventory, null);
		});
	}
	dispDeliveryCount($panel, response.num_of_received);
	// 受注ボタン活性化
	$panel.find(".btn-order").prop("disabled", false);
}

/**
 * 受注オープン
 */
function openOrder() {
	const panelId = $('.nav-item .active').attr('href');
	const $panel = $(panelId);
	// 受注ボタン非活性化
	$panel.find(".btn-order").prop("disabled", true);
	// TODO:リクエスト送信
	let response = {
		num_of_order : 10,
	};
	// レスポンス反映
	$panel.find('.num-of-order').first().text(response.num_of_order);
	$orderCard = $panel.find('.card-order .open-flg');
	$orderCard.addClass('close-flg').removeClass('open-flg');
	$orderCard.find('.i1').addClass('card-open-1').removeClass('card-close-1');
	$orderCard.find('.i2').addClass('card-open-2').removeClass('card-close-2');
	// 販売・出荷ボタン活性化
	$panel.find(".btn-sale").prop("disabled", false);
}

/**
 * 販売・出荷
 */
function sale() {
	const panelId = $('.nav-item .active').attr('href');
	const $panel = $(panelId);
	// 販売・出荷ボタン非活性化
	$panel.find(".btn-sale").prop("disabled", true);
	// TODO:リクエスト送信
	let response = {
		num_of_inventory : 0,
		num_of_backordered : 6,
		num_of_shipping : 12,
	};
	// 受注カードクローズ
	$orderCard.find('.i1').addClass('card-close-1').removeClass('card-open-1');
	$orderCard.find('.i2').addClass('card-close-2').removeClass('card-open-2');
	$orderCard.removeClass('close-flg').addClass('open-flg');
	// 在庫数反映
	dispInventoryCount($panel, response.num_of_inventory, response.num_of_backordered);
	// 小売店の場合アニメーション表示
	if ($panel.hasClass('pane-retailer')) {
		if (response.num_of_backordered > 0) {
			$('#happy-image').hide();
			$('#sad-image').show();
		} else {
			$('#happy-image').show();
			$('#sad-image').hide();
		}
		$customerCard = $('#customer-img').find('.open-flg');
		$customerCard.addClass('close-flg').removeClass('open-flg');
		$customerCard.find('.i1').addClass('card-open-1').removeClass('card-close-1');
		$customerCard.find('.i2').addClass('card-open-2').removeClass('card-close-2');
	} else {
		dispDeliveryCount($panel, num_of_shipping);
	}
	// 発注・生産依頼送信ボタン非活性化
	$panel.find(".btn-send").prop("disabled", false);
}

/**
 * 発注
 */
function purchash() {
	const panelId = $('.nav-item .active').attr('href');
	const $panel = $(panelId);
	// 販売・出荷ボタン非活性化
	$panel.find(".btn-send").prop("disabled", true);
	// 小売店の場合アニメーション表示
	if ($panel.hasClass('pane-retailer')) {
		$customerCard.addClass('open-flg').removeClass('close-flg');
		$customerCard.find('.i1').addClass('card-close-1').removeClass('card-open-1');
		$customerCard.find('.i2').addClass('card-close-2').removeClass('card-open-2');
	}
}