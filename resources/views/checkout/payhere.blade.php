<form method="post" action="https://sandbox.payhere.lk/pay/checkout">
    <!-- Sandbox Merchant ID -->
    <input type="hidden" name="merchant_id" value="4OVyIwJEZm44JH5Enin4T63Xe">

    <!-- URLs -->
    <input type="hidden" name="return_url" value="http://127.0.0.1:8000/payment/success">
    <input type="hidden" name="cancel_url" value="http://127.0.0.1:8000/payment/cancel">
    <input type="hidden" name="notify_url" value="http://127.0.0.1:8000/payment/notify">

    <!-- Order Details -->
    <input type="hidden" name="order_id" value="TEST001">
    <input type="hidden" name="items" value="Test Item">
    <input type="hidden" name="currency" value="LKR">
    <input type="hidden" name="amount" value="1000.00">

    <!-- Customer Details -->
    <input type="hidden" name="first_name" value="Test">
    <input type="hidden" name="last_name" value="User">
    <input type="hidden" name="email" value="test@test.com">
    <input type="hidden" name="phone" value="0771234567">
    <input type="hidden" name="address" value="Colombo">
    <input type="hidden" name="city" value="Colombo">
    <input type="hidden" name="country" value="Sri Lanka">

    <button type="submit">Pay Now</button>
</form>
