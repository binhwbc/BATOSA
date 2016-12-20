<?php
/*
Hỗ trợ tốt trên OC 2.x
*/
// Heading
$_['heading_title']      	= 'Cổng thanh toán WebMoney';
// Text 
$_['text_payment']       	= 'Thanh toán';
$_['text_success']          = 'Thông báo: Bạn vừa sửa đổi phương thức thanh toán WebMoney';
$_['text_authorization']    = 'Chili - Webnoney';
$_['text_webmoney']        = '<img src="view/image/payment/webmoney.png" width="100px">';
$_['entry_order_notify']        = 'Thông báo cho khách hàng';
$_['entry_order_des_notify']        = 'Nếu chọn có thì sau khi thanh toán thành công, hệ thống sẽ gửi mail thông báo thông tin đơn hàng cho khách hàng';
// Entry
$_['entry_passcode']        = 'Passcode';
$_['entry_passcode_hepl']        = 'Mã định dạng API, hay còn gọi là Public key, được cung cấp bới Webmoney. Dùng để tìm kiếm thông tin của website tích hợp với WebMoney và kết hợp chuỗi mã hóa. Mã này là duy nhất, không bị trùng trong hệ thống Webmoney Cần giữ an toàn, bí mật';
$_['entry_secretkey']        = 'Secretkey';
$_['entry_secretkey_hepl']        = 'Là mã bí mật thống nhất giữa Webmoney và website tích hợp. Dùng để băm dữ liệu. Khóa cần giữ an toàn, bí mật';
$_['entry_merchant_code']        = 'Merchant Code';
$_['entry_merchant_code_hepl']        = 'Mã đối tác, dùng để nhận diện trong hệ thống Webmoney. Mã này là duy nhất, không bị trùng trong hệ thống Webmoney';

$_['entry_order_status_start']    = 'Trạng thái đơn hàng bắt đầu';
$_['entry_order_status_start_help']    = 'Là trạng thái của đơn hàng khi khách hàng chọn phương thức thanh toán này';
$_['entry_order_status_end']          = 'Trạng thái đơn hàng kết thúc';
$_['entry_order_status_end_help']          = 'Là trạng thái sau khi khách hàng hoàn thành việc thanh toán ở Webmoney';
$_['entry_status']          = 'Trạng thái';
$_['entry_sort_order']      = 'Sắp xếp độ ưu tiên xuất hiện:';

// Error
$_['error_permission']  	= 'Thông báo: Bạn chưa được phân quyền để sửa đổi các thông số này';
$_['error_passcode']     	= 'Cảnh báo: Trường này không thể trống, Vui lòng nhập Passcode vào';
$_['error_secretkey']     	= 'Cảnh báo: Trường này không thể trống, Vui lòng nhập Secretkey vào';
$_['error_merchant_code']     	= 'Cảnh báo: Trường này không thể trống, Vui lòng nhập Merchant code vào';
?>