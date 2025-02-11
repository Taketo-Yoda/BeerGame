insert into room_status
(name, display_flg, entry_flg, watching_flg, description, created_by, updated_by)
values
 ('Standby', true, true, false, 'メンバー待ち', 'yoda', 'yoda')
,('Ready', true, false, true, 'ゲーム開始待ち', 'yoda', 'yoda')
,('Gaming', true, false, true, 'ゲーム中', 'yoda', 'yoda')
,('Canceled', false, false, false, '中止', 'yoda', 'yoda')
,('Finished', false, false, true, 'ゲーム終了', 'yoda', 'yoda')
;
