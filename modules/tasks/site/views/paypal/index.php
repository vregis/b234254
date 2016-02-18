<form action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='post'>
<input type='hidden' name='business' value='vregprog-facilitator@mail.ru'>
    <input type='hidden' name='cmd' value='_xclick'>
    <input type='hidden' name='item_name' value='task'>
    <input type='hidden' name='item_number' value='1'>
    <input type='hidden' name='amount' value='3'>
    <input type='hidden' name='no_shipping' value='1'>
    <input type='hidden' name='currency_code' value='USD'>
    <input type='hidden' name='cancel_return' value='http://yoursite.com/cancel.php'>
    <input type='hidden' name='return' value='http://yoursite.com/success.php'>
    <input type="image" src="https://paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" name="submit">
</form>