<form id="charge-form">
    <div class="form-group col-md-2">
        <label>Enter sum</label>
        <input type="text" name="sum" class="form-control">
    </div>
    <div class="form-group col-md-2">
        <label>Enter card number</label>
        <input type="text" name="card_number" class="form-control">
    </div>
    <div class="form-group col-md-2">
        <label>Enter card cvc</label>
        <input type="text" name="cvc" class="form-control">
    </div>
    <div class="form-group col-md-2">
        <label>Enter card exp month</label>
        <input type="text" name="month" class="form-control">
    </div>
    <div class="form-group col-md-2">
        <label>Enter card exp year</label>
        <input type="text" name="year" class="form-control">
    </div>
    <div class="form-group col-md-2">
        <label>Send</label>
        <button class="btn btn-success create_charge form-control">Send</button>
    </div>
</form>

<script>
    $(function(){
        $('.create_charge').on('click', function(e){
            e.preventDefault();
            alert('asfk');
        })
    })
</script>