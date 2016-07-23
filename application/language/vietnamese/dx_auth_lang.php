<?php

/*
	It is recommended for you to change 'auth_login_incorrect_password' and 'auth_login_username_not_exist' into something vague.
	For example: Username and password do not match.
*/

$lang['auth_login_incorrect_password'] = "Mật khẩu của bạn không đúng.";
$lang['auth_login_username_not_exist'] = "Tên người dùng không tồn tại.";

$lang['auth_username_or_email_not_exist'] = "Tên người dùng hoặc địa chỉ email không tồn tại.";
$lang['auth_not_activated'] = "Tài khoản của bạn chưa được kích hoạt. Vui lòng kiểm tra email của bạn.";
$lang['auth_request_sent'] = "Yêu cầu thay đổi mật khẩu của bạn đã được gửi. Vui lòng kiểm tra email của bạn.";
$lang['auth_incorrect_old_password'] = "Mật khẩu cũ của bạn không đúng.";
$lang['auth_incorrect_password'] = "Mật khẩu của bạn là không chính xác.";

// Email subject
$lang['auth_account_subject'] = "Chi tiết tài khoản %s";
$lang['auth_activate_subject'] = "Kích hoạt %s";
$lang['auth_forgot_password_subject'] = "Yêu cầu mật khẩu mới";

// Email content
$lang['auth_account_content'] = "Chào mừng bạn đến %s,

Cảm ơn bạn đã đăng ký. Tài khoản của bạn đã được tạo thành công.

Bạn có thể đăng nhập bằng tên người dùng hoặc địa chỉ email:

Tài khoản: %s
Email: %s
Mật khẩu: %s

Bạn có thể thử đăng nhập bằng cách vào %s

Chúng tôi hy vọng rằng bạn thích thú với chúng tôi.

Trân trọng,
Đội nhóm %s";

$lang['auth_activate_content'] = "Chào mừng bạn đến %s,

Để kích hoạt tài khoản của bạn, bạn phải làm theo các liên kết kích hoạt bên dưới:
%s

Hãy kích hoạt tài khoản của bạn trong vòng %s giờ, nếu không đăng ký của bạn sẽ trở thành không hợp lệ và bạn sẽ phải đăng ký lại.

Bạn có thể sử dụng tên đăng nhập hoặc địa chỉ email để đăng nhập.
Chi tiết đăng nhập của bạn như sau:

Tài khoản: %s
Email: %s
Mật khẩu: %s

Chúng tôi hy vọng rằng bạn thích thú với chúng tôi. :)

Trân trọng,
Đội nhóm %s";

$lang['auth_forgot_password_content'] = "%s,

Bạn đã yêu cầu mật khẩu của bạn sẽ được thay đổi, bởi vì bạn quên mật khẩu.
Xin hãy theo liên kết này để hoàn tất quá trình thay đổi mật khẩu:
%s

Mật khẩu mới của bạn: %s
Khóa kích hoạt: %s

Sau khi bạn hoàn thành quá trình này, bạn có thể thay đổi mật khẩu mới này vào mật khẩu mà bạn muốn.

Nếu bạn có bất kỳ vấn đề với truy cập vào account của bạn xin vui lòng liên hệ với %s.

Trân trọng,
Đội nhóm %s";

/* End of file dx_auth_lang.php */
/* Location: ./application/language/vietnamese/dx_auth_lang.php */