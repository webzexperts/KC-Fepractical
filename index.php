<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exercise</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="custom.css">
    <style type="text/css"></style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-xl-12">
            <p class="category"><h1> Promotion List </h1></p>
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#all_promotions" role="tab">All Promotions</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#new_customers" role="tab">New Customers</a>
                            </li>
                        </ul><hr class="mt-0" />
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content text-center">
                            <div class="tab-pane active" id="all_promotions" class="connected-sortable" role="tabpanel"></div>
                            <div class="tab-pane" id="new_customers" role="tabpanel"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
$(document).ready(function() {
    var promotion_result  = JSON.parse(localStorage.getItem('promotion_result'));

    if(promotion_result){
        renderList(promotion_result);
    }
    else{
        $.ajax({
            type: "GET",
            url: 'https://run.mocky.io/v3/484016a8-3cdb-44ad-97db-3e5d20d84298',
            dataType: 'json',
            success: function (result){
                if(result) {
                    renderList(result);
                }
            }   
        });
    }
});

$( init );
function init() {
    $( "#all_promotions").sortable({
        connectWith: ".connected-sortable",
        stack: '.connected-sortable div',
        stop: function(e, ui) {
            var order  = $.map($(this).find('div'), function(el) {
                if($(el).attr('id')){
                    return $(el).attr('id');   
                }
            });
            localStorage.setItem("promotion_row_order", order);
        }
    }).disableSelection();
}

function renderList(result){
    localStorage.setItem("promotion_result", JSON.stringify(result));
    var promotion_row_order = localStorage.getItem('promotion_row_order');
    var is_show = 1;
    $.each(result, function(key, value) {
        //if(value.onlyNewCustomers == false){
            if(promotion_row_order){
                if(is_show == 1){
                    is_show = 2;
                    var split_string = promotion_row_order.split(',');
                    $.each(split_string, function(keys, values) {
                        $("#all_promotions").append("<div class='row promotion_row draggable-item' id='"+values+"'><div class='col-md-12'></div><div class='promotion_row_body'><h3>"
                            +result[values].name+"</h3><p class='description'>"+result[values].description+"</p></div></div></div>");
                    });
                }
            }
            else{
                $("#all_promotions").append("<div class='row promotion_row draggable-item' id='"+key+"'><div class='col-md-12'></div><div class='promotion_row_body'><h3>"+value.name+"</h3><p class='description'>"+value.description+"</p></div></div></div>");
            }      
        //}
        if(value.onlyNewCustomers == true){
            $("#new_customers").append("<div class='row promotion_row'><img class='customer-img' src='"+value.heroImageUrl+"' /><div class='promotion_row_body'><h3>"+value.name+"</h3><p class='description'>"+value.description+"</p></div><div class='col-md-12 mb-2 btns-row'><button class='btn btn-outline-dark'>Terms & Conditions</button><button class='btn btn-dark'>Join Now</button></div></div>");   
        }
    });
}

</script>